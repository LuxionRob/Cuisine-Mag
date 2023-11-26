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
        for ($i = 11; $i <= 20; ++$i) {
            Contact::create([
                'name' => 'Contact' . $i,
                'phone_number' => '0321515461' . $i,
                'user_id' => rand(2, 11),
                'location_id' => $i,
            ]);
        }
    }
}
