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
        for ($i = 0; $i < 10; ++$i) {
            Location::create([
                'x' => rand(-10, 10),
                'y' => rand(-10, 10),
                'detail' => 'location' . $i,
            ]);
        }
    }
}
