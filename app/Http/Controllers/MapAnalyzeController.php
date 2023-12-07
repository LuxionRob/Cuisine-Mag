<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class MapAnalyzeController extends Controller
{
    public function stores()
    {
        $stores = Store::with('location')->get();
        $storesWithLocation = $stores->map(function ($store) use ($stores) {
            return [
                "id" => $store->id,
                "x" => $store->location->x,
                "y" => $store->location->y,
                "name" => $store->name,
                "details" => $store->location->detail,
            ];
        });

        return $storesWithLocation;
    }
}
