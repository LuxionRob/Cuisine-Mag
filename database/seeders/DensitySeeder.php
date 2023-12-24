<?php

namespace Database\Seeders;

use Eloquent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DensitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'database/seeders/raw/population_density.sql';
        DB::unprepared(file_get_contents($path));
    }
}
