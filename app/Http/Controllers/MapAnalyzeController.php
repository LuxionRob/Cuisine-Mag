<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Order;
use App\Models\PopulationDensity;
use App\Models\Road;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        $latitudeFrom,
        $longitudeFrom,
        $latitudeTo,
        $longitudeTo,
        $earthRadius = 6371000
    ) {
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
        $sumAndRevenue = Location::join('contacts', 'contacts.location_id', '=', 'locations.id')
            ->join('orders', 'orders.contact_id', '=', 'contacts.id')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('store_id', '=', $store->id)->selectRaw(DB::raw('COUNT(*) as orderQuantity, SUM(products.price * order_items.quantity) as totalRevenue'))->first();

        $multiPoints = Location::join('contacts', 'contacts.location_id', '=', 'locations.id')
            ->join('orders', 'orders.contact_id', '=', 'contacts.id')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('store_id', '=', $store->id)->selectRaw(DB::raw('coordinates, ROUND(products.price * order_items.quantity, 2) as revenue'))->get();

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
                            $store->location->coordinates->getLng(),
                            6371000
                        )
                    ],
                ];
            })
        ];

        return response()->json(['geo' => $geojs, 'total' => $sumAndRevenue]);
    }

    public function showDensity(Request $request)
    {
        $page = $request->input('page');
        $limit = $request->input('limit');

        try {
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
                        "geometry" => $point->coordinates,
                        "properties" => [
                            'populationDensity' => $point->density,
                        ],
                    ];
                })
            ];

            $response['geo'] = $geojs;
            $response['lastPage'] = $multiPoints->lastPage();

            return response()->json($response, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
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
                $filterArray = [
                    'footway',
                    'pedestrian',
                    'motorway',
                    'motorway_link',
                    'cycleway',
                    'construction',
                    'proposed',
                    'unclassified'
                ];

                if (!in_array($string->type, $filterArray)) {
                    return [
                        "type" => "Feature",
                        "geometry" => $string->coordinates,
                        "properties" => [
                            'type' => $string->type,
                        ],
                    ];
                }
            })->filter(function ($value) {
                return $value != null;
            })->values()
        ];
        $response['geo'] = $geojs;
        $response['lastPage'] = $multiString->lastPage();

        return response()->json($response, Response::HTTP_OK);
    }

    public function getRevenueByOrderLocation()
    {
        $orderItems = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->groupBy('contact_id')
            ->with('contact.location')
            ->whereDate('orders.created_at', '>', Carbon::now()->firstOfMonth())
            ->addSelect(
                DB::raw(
                    ("orders.contact_id, COUNT(orders.contact_id) as orderFrequency, SUM(quantity * price) as totalRevenue")
                )
            )
            ->get();

        $res = [
            "type" => "FeatureCollection",
            "features" => $orderItems->map(function ($item) {
                return [
                    "type" => "Feature",
                    "geometry" => $item->contact->location->coordinates,
                    "properties" => [
                        'revenue' => $item->totalRevenue,
                        'frequency' => $item->orderFrequency,
                        'rate' => $item->orderFrequency > 1 ? 1 : 0
                    ],
                ];
            })
        ];

        return response()->json($res);
    }
}
