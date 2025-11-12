<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswas = [
            [
                'nim' => '2301301001',
                'nama_mahasiswa' => 'Rizqia Febrianoor',
                'kode_prodi' => 'TI',
                'id_tahun_kurikulum' => 1,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '2301301002',
                'nama_mahasiswa' => 'Ahmad Dwi Kurnia',
                'kode_prodi' => 'TI',
                'id_tahun_kurikulum' => 1,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '2301301003',
                'nama_mahasiswa' => 'Sherly Sandrina',
                'kode_prodi' => 'TI',
                'id_tahun_kurikulum' => 1,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '2301301004',
                'nama_mahasiswa' => 'Alma Nabila',
                'kode_prodi' => 'TI',
                'id_tahun_kurikulum' => 1,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '2301301005',
                'nama_mahasiswa' => 'Maulida Yanti',
                'kode_prodi' => 'TI',
                'id_tahun_kurikulum' => 1,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '2301301006',
                'nama_mahasiswa' => 'Zubaidah Nur Jumiah',
                'kode_prodi' => 'TI',
                'id_tahun_kurikulum' => 1,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '2301301007',
                'nama_mahasiswa' => 'Siti Fatimah',
                'kode_prodi' => 'TI',
                'id_tahun_kurikulum' => 1,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '2301301011',
                'nama_mahasiswa' => 'M.Galih Katon Bagaskara',
                'kode_prodi' => 'TI',
                'id_tahun_kurikulum' => 1,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '2301301013',
                'nama_mahasiswa' => 'Mahyudianoor',
                'kode_prodi' => 'TI',
                'id_tahun_kurikulum' => 1,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '2301301014',
                'nama_mahasiswa' => 'Muhammad Hafidl Badali',
                'kode_prodi' => 'TI',
                'id_tahun_kurikulum' => 1,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data, skip jika sudah ada (berdasarkan NIM)
        foreach ($mahasiswas as $mhs) {
            DB::table('mahasiswas')->updateOrInsert(
                ['nim' => $mhs['nim']],  // Cek berdasarkan NIM
                $mhs                      // Data yang akan diinsert/update
            );
        }
    }
}
