<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Order;
use App\Models\Store;
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
        Order::factory()->count(1500)->create();
    }

}
