<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->numberBetween(1, 50),
            'user_id' => $this->faker->numberBetween(2, 11),
            'product_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
