<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $salesman = User::where('role', UserRole::ROLE_SALESMAN)->get();

        foreach ($salesman as $value) {
            Store::factory()->hasLocation()->hasProducts(50)->for($value)->create();
        }
    }
}
