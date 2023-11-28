<?php

namespace App\Http\Controllers\Salesman;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorized\Order\AuthorizedOrderRequest;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class SalesmanOrderController extends Controller
{
    public function index()
    {
        $store = Store::where('owner_id', Auth::id())->first();
        $store->load('products.orderItems.order');


        $uniqueOrderItemByProduct = $store->products->map(function ($product) {
            return $product->orderItems->unique('order_id')->all();
        });

        $orders = $uniqueOrderItemByProduct->collapse()->map(function ($product) {
            return $product->order;
        })->unique('id');

        return view('authorized.orders.index', compact('orders'));
    }

    public function edit(Order $order)
    {
        $order->load('orderItems');

        return view('authorized.orders.edit', compact('order'));
    }

    public function update(AuthorizedOrderRequest $request, Order $order)
    {
        $request->validated();

        $order->load('orderItems');
        for ($i = 0; $i < $order->orderItems->count(); $i++) {
            $order->orderItems[$i]->status = $request->status;
            $order->orderItems[$i]->save();
        }
        $order->save();

        return redirect(route('orders.show', $order))->with('success', trans('order.update.success'));
    }
}
