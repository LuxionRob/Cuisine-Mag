<?php

namespace Database\Factories;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $username = $this->faker->userName;

        return [
            'username' => $username,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $username . '@gmail.com',
            'password' => bcrypt('12345678'),
            'is_active' => true,
            'role' => UserRole::ROLE_USER,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }
}
