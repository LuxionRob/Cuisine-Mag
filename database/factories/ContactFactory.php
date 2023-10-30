<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'user_id' => $this->faker->numberBetween(2, 11),
        ];
    }
}
