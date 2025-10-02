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
        $admin = User::factory()->create([
            'name' => 'Admin Apri',
            'email' => 'apri@politala.ac.id',
            'password' => Hash::make('Wrrdhnii16'),
        ]);
        $admin->assignRole('Admin');

        // Kaprodi
        $kaprodi = User::factory()->create([
            'name' => 'Kaprodi TI',
            'email' => 'kaprodi@politala.ac.id',
            'password' => Hash::make('Kaprodi123'),
        ]);
        $kaprodi->assignRole('Kaprodi');

        // Wadir 1
        $wadir = User::factory()->create([
            'name' => 'Wadir 1',
            'email' => 'wadir1@politala.ac.id',
            'password' => Hash::make('Wadir123'),
        ]);
        $wadir->assignRole('Wadir 1');
    }
}
