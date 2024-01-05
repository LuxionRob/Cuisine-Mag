<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DensitySeeder1::class,
            DensitySeeder2::class,
            DensitySeeder3::class,
            RoadSeeder::class,
        ]);
    }
}
