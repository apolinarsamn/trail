<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@trail.test',
            ],
            [
                'name' => 'TRAIL Administrator',
                'role' => 'admin',
                'password' => Hash::make('TrailAdmin2026!'),
            ]
        );
    }
}