<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DensitySeeder2 extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    for ($i = 3; $i < 6; $i++) {
      $path = 'database/seeders/raw/population_density_' . $i . '.sql';
      DB::unprepared(file_get_contents($path));
    }
  }
}
