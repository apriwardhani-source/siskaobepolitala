<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenUserSeeder extends Seeder
{
    public function run()
    {
        // Create a sample dosen user
        DB::table('users')->insert([
            'name' => 'Dosen Pengampu',
            'email' => 'dosen@example.com',
            'nip' => '198001012010011001',
            'nohp' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'dosen', // This will bypass the check constraint in SQLite during seeding
            'kode_prodi' => null,
            'id_jurusan' => null,
            'status' => 'approved',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}