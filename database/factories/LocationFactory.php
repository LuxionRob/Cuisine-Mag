<?php

namespace Database\Factories;

use Grimzy\LaravelMysqlSpatial\Types\Point;
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
            'coordinates' => new Point(rand(110473, 111633) / 10000.0, rand(1063433, 1070261) / 10000.0),
            'detail' => $this->faker->address,
        ];
    }
}
