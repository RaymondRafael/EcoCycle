<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator EcoCycle',
            'email' => 'admin@ecocycle.com',
            'password' => Hash::make('password123'), // Ganti dengan password yang aman nanti
            'role' => 'admin',
        ]);
    }
}   