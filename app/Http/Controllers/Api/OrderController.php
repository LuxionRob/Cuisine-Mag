<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    const DEFAULT_LIMIT = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');
        $orderCol = $request->input('order');
        $orderDirection = $request->input('direction');

        $orders = Order::with('orderItems', 'contact')
            ->orderBy($orderCol ?? 'id', $orderDirection ?? 'desc')
            ->paginate($limit ?? self::DEFAULT_LIMIT, ['*'], 'page', $page ?? 1);

        return response()->json($orders);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function groupIndex(Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');
        $groupCol = $request->input('groupCol');
        $orderCol = $request->input('orderCol');
        $orderDirection = $request->input('direction');
        $condition = $request->input('condition');

        $orders = Order::with(['orderItems', 'contact'])
            ->addSelect(DB::raw('count(*) as user_count'))
            ->where(isset($condition) ? true : $condition)
            ->groupBy($groupCol ?? 'id')
            ->orderBy($orderCol ?? 'id', $orderDirection ?? 'desc')
            ->paginate($limit ?? self::DEFAULT_LIMIT, ['*'], 'page', $page ?? 1);

        return response()->json($orders);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order, Request $request)
    {
        $order->load('orderItems');

        return response()->json($order, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->load('orderItems');
        foreach ($order->orderItems as $item) {
            $item->status = $request->status;
            $item->save();
        }
        $order->save();

        return response()->json($order, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {
            $order->load('orderItems');
            foreach ($order->orderItems as $item) {
                $item->status = OrderStatus::CANCELED;
                $item->save();
            }
        });

        return response()->json($order, Response::HTTP_OK);
    }
}
