<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Location;
use App\Models\Store;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
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
            Contact::create([
                'name' => 'Contact' . $locationId,
                'phone_number' => '0321515461' . $locationId,
                'user_id' => rand(2, 11),
                'location_id' => $locationId,
            ]);
        }
    }
}
