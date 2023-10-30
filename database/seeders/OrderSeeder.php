<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; ++$i) {
            Order::create([
                'contact_id' => rand(2, 10),
                'user_id' => rand(1, 10),
            ]);
        }
    }
}
