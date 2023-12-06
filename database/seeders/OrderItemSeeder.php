<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::all();
        foreach ($orders as $order) {
            OrderItem::create([
                'quantity' => rand(1, 50),
                'payment_method' => PaymentMethod::$types[rand(0, 1)],
                'payment_status' => false,
                'status' => OrderStatus::$types[rand(0, 4)],
                'product_id' => Product::inRandomOrder()->first()->id,
                'order_id' => $order->id,
            ]);
        }
    }
}
