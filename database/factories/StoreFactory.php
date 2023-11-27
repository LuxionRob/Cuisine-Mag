<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Store - Location ' . $this->faker->randomAscii(),
            'location_id' => Location::factory()->create(),
            // 'owner_id' => User::where('role', UserRole::ROLE_SALESMAN)->get()->random()->id,
        ];
    }
}
