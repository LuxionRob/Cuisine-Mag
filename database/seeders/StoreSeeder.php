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
        $locationIds = Location::pluck('id');
        foreach ($locationIds as $locationId) {
            for ($i = 0; $i < 3; $i++) {
                Store::create([
                    'name' => 'Store ' . ($i + 1) . ' - Location ' . $locationId,
                    'location_id' => $locationId,
                    'owner_id' => rand(6, 11),
                ]);
            }
        }
    }
}
