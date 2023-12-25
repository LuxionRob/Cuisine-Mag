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
            'coordinates' => new Point(11.040305555507092 + (rand(-60, 60) / 1000.0), 106.63763888911924 + (rand(-200, 200) / 1000.0)),
            'detail' => $this->faker->address,
        ];
    }
}
