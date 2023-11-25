<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Location;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Nette\Schema\Schema;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; ++$i) {
            Store::create([
                'name' => 'Store - Location ' . $i,
                'location_id' => $i,
                'owner_id' => $i + 5,
            ]);
        }
    }
}
