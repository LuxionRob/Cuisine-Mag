<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorized\Order\AuthorizedOrderRequest;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $orders->load('orderItems');
        $orders->load('user');

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
        foreach ($order->orderItems as $item) {
            $item->status = $request->status;
            $item->save();
        }
        $order->save();

        return redirect(route('orders.show', $order))->with('success', 'order.update.success');
    }
}
