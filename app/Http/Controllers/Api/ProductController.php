<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    const DEFAULT_LIMIT = 10;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->input('page');
        $limit = $request->input('limit');
        $orderCol = $request->input('order');
        $orderDirection = $request->input('direction');

        $products = DB::table('products')->where('number_in_stock', '>', '-1')
            ->orderBy($orderCol ?? 'id', $$orderDirection ?? 'desc')
            ->paginate($limit ?? self::DEFAULT_LIMIT, ['*'], 'page', $page ?? 1);

        return response()->json($products, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            $product->number_in_stock = -1;
            $product->load('categories');
            $product->categories()->detach();
            $product->load('cartItems');
            $product->cartItems()->delete();
            $product->save();
        });
        return response()->json();
    }
}
