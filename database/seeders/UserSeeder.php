<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'ndiandie@gmail.com'],
            [
                'name' => 'Admin MikPay',
                'password' => Hash::make('MikPayandidev.id'),
                'role' => 'admin',
                'status' => 'active',
                'subdomain' => null,
            ]
        );

        // User
        User::updateOrCreate(
            ['email' => 'user@andidev.id'],
            [
                'name' => 'User Test',
                'password' => Hash::make('andidev.id'),
                'role' => 'user',
                'status' => 'active',
                'subdomain' => 'test-user',
            ]
        );
    }
}
