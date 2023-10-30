<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->paragraph,
            'rate' => $this->faker->randomFloat(1, 1, 5),
            'user_id' => $this->faker->numberBetween(2, 11),
            'product_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
