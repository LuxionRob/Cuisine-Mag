<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Models\OrderItem;
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
        for ($i = 0; $i < 100; ++$i) {
            OrderItem::create([
                'quantity' => rand(1, 50),
                'payment_method' => PaymentMethod::$types[rand(0, 1)],
                'payment_status' => false,
                'status' => OrderStatus::$types[rand(0, 4)],
                'product_id' => rand(1, 5),
                'order_id' => rand(1, 5),
            ]);
        }
    }
}
