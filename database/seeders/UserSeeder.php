<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::factory()->create([
            'name' => 'Admin Apri',
            'email' => 'apri@politala.ac.id', // Ganti dengan email admin kamu
            'password' => Hash::make('Wrrdhnii16'), // Ganti dengan password kuat
            'role' => 'admin',
        ]);
    }
}