<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Http\Requests\Order\OrderCreateRequest;
use App\Http\Requests\Order\OrderUpdateRequest;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    const ORDER_STATUS_DEFAULT = OrderStatus::WAITING;

    private function getPaymentStatusOnStore($paymentMethods)
    {
        switch ($paymentMethods) {
            case PaymentMethod::CASH:
                return false;
            case PaymentMethod::VISA_CARD:
                return true;
            default:
                return true;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->load('orders.orderItems.product');
        foreach ($user->orders as $order) {
            $cancel = 0;
            foreach ($order->orderItems as $orderItem) {
                if ($orderItem->status !== OrderStatus::CANCELED && $orderItem->product->number_in_stock == -1) {
                    $cancel = 1;
                    break;
                }
            }
            if ($cancel == 1) {
                foreach ($order->orderItems as $orderItem) {
                    $orderItem->status = OrderStatus::CANCELED;
                    $orderItem->save();
                }
            }
        }

        return view('orders.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->load('cartItems');
        $user->load('contacts');
        $paymentMethods = PaymentMethod::$types;

        if ($user->cartItems->count() <= 0) {
            return redirect()->back()->with('fail', trans('order.create.cart.required'));
        }

        return view('orders.create', compact('user', 'paymentMethods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderCreateRequest $request)
    {
        $request->validated();
        $user = Auth::user()->load('cartItems');

        if ($user->cartItems->count() <= 0) {
            return redirect()->back()->with('fail', trans('order.store.fail'));
        }

        $groupedProducts = $user->cartItems->groupBy('product.salesman_id');

        foreach ($groupedProducts as $salesmanId => $items) {
            DB::transaction(function () use ($request, $items) {
                $order = new Order;
                $order->user_id = Auth::id();
                $order->contact_id = $request["contact_id"];
                $order->save();

                foreach ($items as $item) {
                    $orderItem = new OrderItem;
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $item->product_id;
                    $orderItem->quantity = $item->quantity;
                    $orderItem->payment_method = $request["payment_method"];
                    $orderItem->status = self::ORDER_STATUS_DEFAULT;
                    $orderItem->payment_status = $this->getPaymentStatusOnStore($request["payment_method"]);
                    $orderItem->save();
                };
            });
        }
        $user->cartItems()->delete();

        return redirect(route('products.index'))->with('success', trans('order.store.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order->load('contact');
        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        if ($order->orderItems[0]->status !== OrderStatus::WAITING) {
            return redirect(route('orders.show', $order))->with('fail', trans('auth.403'));
        }

        $order->load('orderItems');
        $order->load('contact');
        $user = Auth::user();

        return view('orders.edit', compact('order', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdateRequest $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return redirect('/')->with('fail', trans('auth.403'));
        }

        if ($order->orderItems[0]->status === OrderStatus::WAITING) {
            $order->contact_id = $request->contact_id;
            $order->save();
            return redirect(route('orders.show', $order))->with('success', trans('order.update.success'));
        }

        return redirect(route('orders.show', $order))->with('fail', trans('order.update.fail'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return redirect(route('orders.index'))->with('fail', trans('auth.403'));
        }

        DB::transaction(function () use ($order) {
            $order->load('orderItems');
            foreach ($order->orderItems as $item) {
                $item->status = OrderStatus::CANCELED;
                $item->save();
            }
        });

        return redirect(route('orders.show', $order))->with('success', trans('order.cancel.success'));
    }
}
