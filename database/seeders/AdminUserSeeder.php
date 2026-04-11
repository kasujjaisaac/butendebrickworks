<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@butende.com'],
            [
                'name' => 'System Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('Admin@123'),
                'is_admin' => true,
            ]
        );
    }
}