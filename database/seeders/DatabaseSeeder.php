<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\ProductReview;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([

            OrderSeeder::class,
            OrderItemSeeder::class,
            DensitySeeder1::class,
            DensitySeeder2::class,
            DensitySeeder3::class,
            RoadSeeder::class,
        ]);

        CartItem::factory(10)->create();
        ProductReview::factory(5)->create();
    }
}
