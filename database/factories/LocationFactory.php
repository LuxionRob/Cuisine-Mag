<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'x' => 10.8617 + (rand(-100, 100) / 1000.0),
            'y' => 106.6944 + (rand(-100, 100) / 1000.0),
            'detail' => $this->faker->address,
        ];
    }
}
