<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo tài khoản admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Tạo tài khoản editor
        User::create([
            'name' => 'Editor',
            'email' => 'editor@example.com',
            'password' => Hash::make('password'),
            'role' => 'editor'
        ]);

        // Tạo tài khoản user thường
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
    }
} 