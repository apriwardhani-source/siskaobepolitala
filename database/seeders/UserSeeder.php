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

        // Kaprodi
        User::factory()->create([
            'name' => 'Kaprodi TI',
            'email' => 'kaprodi@politala.ac.id', // email kaprodi
            'password' => Hash::make('Kaprodi123'), // password kaprodi
            'role' => 'kaprodi',
        ]);

        // Dosen
        User::factory()->create([
            'name' => 'Dosen TI',
            'email' => 'Dosen@politala.ac.id', // email kaprodi
            'password' => Hash::make('Dosen123'), // password kaprodi
            'role' => 'dosen',
        ]);
        User::factory()->create([
            'name' => 'Dosen',
            'email' => 'Dose@politala.ac.id', // email kaprodi
            'password' => Hash::make('osen123'), // password kaprodi
            'role' => 'dosen',
        ]);
    }
    
}