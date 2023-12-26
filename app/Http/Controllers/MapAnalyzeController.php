<?php

namespace App\Http\Controllers;

use App\Models\PopulationDensity;
use App\Models\Road;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MapAnalyzeController extends Controller
{
    const DEFAULT_LIMIT = 10000;

    public function stores()
    {
        $stores = Store::with('location')->get();
        $storesWithLocation = $stores->map(function ($store) {
            return [
                "id" => $store->id,
                "x" => $store->location->coordinates->getLng(),
                "y" => $store->location->coordinates->getLat(),
                "name" => $store->name,
                "details" => $store->location->detail,
            ];
        });

        return $storesWithLocation;
    }
    private function haversineGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }
    public function showStore(Store $store)
    {
        $multiPoints = PopulationDensity::distanceValue('coordinates', $store->location->coordinates)
            ->distance('coordinates', $store->location->coordinates, 0.05) //Radius: ~5.95km
            ->get();

        $geojs = [
            "type" => "FeatureCollection",
            "features" => $multiPoints->map(function ($point) use ($store) {

                return [
                    "type" => "Feature",
                    "geometry" => [
                        "type" => "Point",
                        "coordinates" => [$point->coordinates->getLat(), $point->coordinates->getLng()],
                    ],
                    "properties" => [
                        'distance' => $this->haversineGreatCircleDistance(
                            $point->coordinates->getLat(),
                            $point->coordinates->getLng(),
                            $store->location->coordinates->getLat(),
                            $store->location->coordinates->getLng(), 6371000
                        ),
                        'populationDensity' => $point->density,
                    ],
                ];
            })

        ];

        return response()->json($geojs);
    }

    public function showDensity(Request $request)
    {
        $page = $request->input('page');
        $limit = $request->input('limit');

        $multiPoints = PopulationDensity::paginate($limit ?? self::DEFAULT_LIMIT, ['*'], 'page', $page ?? 1);

        if ($page > $multiPoints->lastPage()) {
            return response()->json(Response::HTTP_NOT_FOUND);
        } else if ($page < $multiPoints->lastPage()) {
            $response = ['nextPage' => $multiPoints->currentPage() + 1];
        }

        $geojs = [
            "type" => "FeatureCollection",
            "features" => $multiPoints->map(function ($point) {

                return [
                    "type" => "Feature",
                    "geometry" => [
                        "type" => "Point",
                        "coordinates" => [$point->coordinates->getLat(), $point->coordinates->getLng()],
                    ],
                    "properties" => [
                        'populationDensity' => $point->density,
                    ],
                ];
            })
        ];

        $response['geo'] = $geojs;
        $response['lastPage'] = $multiPoints->lastPage();

        return response()->json($response, Response::HTTP_OK);
    }

    function showRoads(Request $request)
    {
        $page = $request->input('page');
        $limit = $request->input('limit');

        $multiString = Road::paginate($limit ?? self::DEFAULT_LIMIT, ['*'], 'page', $page ?? 1);

        if ($page > $multiString->lastPage()) {
            return response()->json(Response::HTTP_NOT_FOUND);
        } else if ($page < $multiString->lastPage()) {
            $response = ['nextPage' => $multiString->currentPage() + 1];
        }

        $geojs = [
            "type" => "FeatureCollection",
            "features" => $multiString->map(function ($string) {

                return [
                    "type" => "Feature",
                    "geometry" => 
                      $string->coordinates,
                    "properties" => [
                        'type' => $string->type,
                    ],
                ];
            })
        ];
        $response['geo'] = $geojs;
        $response['lastPage'] = $multiString->lastPage();

        return response()->json($response, Response::HTTP_OK);
    }
}
