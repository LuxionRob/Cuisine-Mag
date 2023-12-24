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
            'coordinates' => new Point(11.054305555507092 + (rand(-80, 80) / 1000.0), 106.83763888911924 + (rand(-100, 100) / 1000.0)),
            'detail' => $this->faker->address,
        ];
    }
}
