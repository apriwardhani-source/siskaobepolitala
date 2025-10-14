<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdateRoleEnumSeeder extends Seeder
{
    public function run()
    {
        // Drop the constraint in SQLite by recreating the table
        DB::statement('PRAGMA foreign_keys = OFF');
        
        // Create the new table structure with 'dosen' role included
        DB::statement('
            CREATE TABLE users_new (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                nip TEXT NULL,
                nohp TEXT NULL,
                email TEXT NOT NULL UNIQUE,
                email_verified_at DATETIME NULL,
                password TEXT NOT NULL,
                role TEXT CHECK(role IN ("admin", "wadir1", "kaprodi", "tim", "kajur", "dosen")) NOT NULL,
                kode_prodi TEXT NULL,
                id_jurusan INTEGER NULL,
                status TEXT CHECK(status IN ("pending", "approved")) DEFAULT "approved",
                remember_token TEXT NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL,
                FOREIGN KEY (kode_prodi) REFERENCES prodis (kode_prodi) ON UPDATE CASCADE ON DELETE CASCADE,
                FOREIGN KEY (id_jurusan) REFERENCES jurusans (id_jurusan) ON UPDATE CASCADE ON DELETE CASCADE
            )
        ');
        
        // Copy the existing data
        DB::statement('
            INSERT INTO users_new
            SELECT id, name, nip, nohp, email, email_verified_at, password, role, kode_prodi, id_jurusan, status, remember_token, created_at, updated_at
            FROM users
        ');
        
        // Drop the old table and rename the new one
        DB::statement('DROP TABLE users');
        DB::statement('ALTER TABLE users_new RENAME TO users');
        
        DB::statement('PRAGMA foreign_keys = ON');
    }
}