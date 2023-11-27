<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin' . '-account',
            'first_name' => 'admin',
            'last_name' => 'account',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'is_active' => true,
            'role' => UserRole::ROLE_ADMIN,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
