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
            ['email' => 'apri@politala.ac.id'],
            [
                'name' => 'Admin Apri',
                'password' => Hash::make('Wrrdhnii16'),
                'role' => 'admin',
            ]
        );

        // Kaprodi
        User::updateOrCreate(
            ['email' => 'kaprodi@politala.ac.id'],
            [
                'name' => 'Kaprodi TI',
                'password' => Hash::make('Kaprodi123'),
                'role' => 'kaprodi',
            ]
        );

        // Wadir 1
        User::updateOrCreate(
            ['email' => 'wadir1@politala.ac.id'],
            [
                'name' => 'Wadir 1',
                'password' => Hash::make('Wadir123'),
                'role' => 'wadir',
            ]
        );

        // Dosen
        User::updateOrCreate(
            ['email' => 'dosen@politala.ac.id'],
            [
                'name' => 'Dosen TI',
                'password' => Hash::make('Dosen123'),
                'role' => 'dosen',
            ]
        );

        User::updateOrCreate(
            ['email' => 'dose@politala.ac.id'],
            [
                'name' => 'Dosen',
                'password' => Hash::make('osen123'),
                'role' => 'dosen',
            ]
        );
    }
}
