<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DensitySeeder3 extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    for ($i = 6; $i < 10; $i++) {
      $path = 'database/seeders/raw/population_density_' . $i . '.sql';
      DB::unprepared(file_get_contents($path));
    }
  }
}
