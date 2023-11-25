<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 20; ++$i) {
            Location::create([
                'x' => rand(-200, 200) / 10.0,
                'x' => rand(-200, 200) / 10.0,
                'detail' => 'location' . $i,
            ]);
        }
    }
}
