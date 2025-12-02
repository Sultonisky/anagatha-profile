<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Recruiter user
        User::updateOrCreate(
            ['email' => 'recruiter@example.com'],
            [
                'first_name' => 'Recruiter',
                'last_name' => 'Demo',
                'password' => Hash::make('password'),
                'role' => 'recruiter',
                'phone' => '6281234567890',
                'company_name' => 'Demo Company',
                'job_title' => 'HR Manager',
                'email_verified_at' => now(),
            ]
        );

        // Regular employee user
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'first_name' => 'Regular',
                'last_name' => 'User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );
    }
}


