<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prodi;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        Prodi::insert([
            [
                'kode_prodi' => 'C0303',
                'nama_prodi' => 'Teknik Informatika',
                'visi_prodi' => 'Menjadi Program Studi Teknik Informatika yang unggul dalam bidang teknologi informasi dan komunikasi.',
                'nama_kaprodi' => 'Dr. Ir. Joko Prasetyo',
                'tgl_berdiri_prodi' => '2002-08-01',
                'penyelenggaraan_prodi' => '2003-01-01',
                'nomor_sk' => '123/SK/DIKTI/2002',
                'tanggal_sk' => '2002-07-15',
                'peringkat_akreditasi' => 'B',
                'nomor_sk_banpt' => '456/BAN-PT/Ak/XI/2020',
                'jenjang_pendidikan' => 'D4',
                'gelar_lulusan' => 'S.Tr.Kom',
                'telepon_prodi' => '0511-3301234',
                'faksimili_prodi' => '0511-3301235',
                'website_prodi' => 'https://ti.politala.ac.id',
                'email_prodi' => 'ti@politala.ac.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_prodi' => 'F0105',
                'nama_prodi' => 'Teknik Listrik',
                'visi_prodi' => 'Menjadi Program Studi Teknik Listrik yang berkomitmen pada pengembangan teknologi kelistrikan yang berkelanjutan.',
                'nama_kaprodi' => 'Dr. Ir. Siti Aminah',
                'tgl_berdiri_prodi' => '2000-06-10',
                'penyelenggaraan_prodi' => '2001-01-01',
                'nomor_sk' => '789/SK/DIKTI/2000',
                'tanggal_sk' => '2000-05-20',
                'peringkat_akreditasi' => 'B',
                'nomor_sk_banpt' => '789/BAN-PT/Ak/XII/2021',
                'jenjang_pendidikan' => 'D3',
                'gelar_lulusan' => 'A.Md.T',
                'telepon_prodi' => '0511-3302222',
                'faksimili_prodi' => '0511-3302223',
                'website_prodi' => 'https://elka.politala.ac.id',
                'email_prodi' => 'elka@politala.ac.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_prodi' => 'C0505',
                'nama_prodi' => 'Sistem Informasi Kota Cerdas',
                'visi_prodi' => 'Menjadi Program Studi Sistem Informasi yang berfokus pada pengembangan solusi teknologi untuk kota cerdas.',
                'nama_kaprodi' => 'Dr. Ir. Budi Santoso',
                'tgl_berdiri_prodi' => '2020-09-01',
                'penyelenggaraan_prodi' => '2021-01-01',
                'nomor_sk' => '321/SK/DIKTI/2020',
                'tanggal_sk' => '2020-08-15',
                'peringkat_akreditasi' => 'B',
                'nomor_sk_banpt' => '987/BAN-PT/Ak/X/2022',
                'jenjang_pendidikan' => 'D4',
                'gelar_lulusan' => 'S.Tr.SI',
                'telepon_prodi' => '0511-3305555',
                'faksimili_prodi' => '0511-3305556',
                'website_prodi' => 'https://smartcity.politala.ac.id',
                'email_prodi' => 'smartcity@politala.ac.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

}
