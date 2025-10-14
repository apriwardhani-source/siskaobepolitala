<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Create sample department
        DB::table('jurusans')->insert([
            'nama_jurusan' => 'Teknologi Informasi',
            'nama_kajur' => 'Dr. Ir. Ahmad Kurniawan, M.T.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $jurusan_id = DB::getPdo()->lastInsertId();
        
        // Create sample study program
        DB::table('prodis')->insert([
            'kode_prodi' => 'TI',
            'nama_prodi' => 'Teknik Informatika',
            'id_jurusan' => $jurusan_id,
            'visi_prodi' => 'Menjadi program studi unggulan dalam bidang teknologi informasi yang menghasilkan lulusan kompeten',
            'nama_kaprodi' => 'Dr. Eng. Siti Aisyah, S.T., M.T.',
            'tgl_berdiri_prodi' => '2010-09-01',
            'penyelenggaraan_prodi' => '2010-09-01',
            'nomor_sk' => '045/D/T/2010',
            'tanggal_sk' => '2010-09-01',
            'peringkat_akreditasi' => 'A',
            'nomor_sk_banpt' => '1234/BAN-PT/SK/2020',
            'jenjang_pendidikan' => 'D4',
            'gelar_lulusan' => 'Sarjana Terapan Teknik Informatika',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Create sample academic year
        DB::table('tahun')->insert([
            'nama_kurikulum' => 'Kurikulum Berbasis OBE 2024',
            'tahun' => '2024/2025',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $tahun_id = DB::getPdo()->lastInsertId();
        
        // Create sample graduate profile
        DB::table('profil_lulusans')->insert([
            'kode_pl' => 'PL001',
            'kode_prodi' => 'TI',
            'id_tahun' => $tahun_id,
            'deskripsi_pl' => 'Lulusan mampu merancang dan mengembangkan sistem informasi',
            'profesi_pl' => 'Software Developer, System Analyst, IT Consultant',
            'unsur_pl' => 'Keterampilan Khusus',
            'keterangan_pl' => 'Kompetensi Utama Bidang',
            'sumber_pl' => 'KKNI, Kerangka Kualifikasi Nasional Indonesia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $pl_id = DB::getPdo()->lastInsertId();
        
        // Create sample CPL
        DB::table('capaian_profil_lulusans')->insert([
            'kode_cpl' => 'CPL001',
            'deskripsi_cpl' => 'Mampu menganalisis kebutuhan pengguna dalam pengembangan sistem informasi',
            'status_cpl' => 'Kompetensi Utama Bidang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $cpl_id = DB::getPdo()->lastInsertId();
        
        // Map CPL to PL
        DB::table('cpl_pl')->insert([
            'id_pl' => $pl_id,
            'id_cpl' => $cpl_id,
        ]);
        
        // Create sample study material
        DB::table('bahan_kajians')->insert([
            'kode_bk' => 'BK001',
            'nama_bk' => 'Pemrograman',
            'deskripsi_bk' => 'Materi dasar tentang pemrograman komputer',
            'status_bk' => 'core',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $bk_id = DB::getPdo()->lastInsertId();
        
        // Map CPL to BK
        DB::table('cpl_bk')->insert([
            'id_cpl' => $cpl_id,
            'id_bk' => $bk_id,
        ]);
        
        // Create sample course
        DB::table('mata_kuliahs')->insert([
            'kode_mk' => 'IF101',
            'nama_mk' => 'Pemrograman Dasar',
            'jenis_mk' => 'Wajib',
            'sks_mk' => 3,
            'semester_mk' => '1',
            'kompetensi_mk' => 'utama',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Map CPL to MK
        DB::table('cpl_mk')->insert([
            'id_cpl' => $cpl_id,
            'kode_mk' => 'IF101',
        ]);
        
        // Create sample CPMK
        DB::table('capaian_pembelajaran_mata_kuliahs')->insert([
            'kode_cpmk' => 'CPMK001',
            'deskripsi_cpmk' => 'Mampu membuat algoritma sederhana',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $cpmk_id = DB::getPdo()->lastInsertId();
        
        // Map CPMK to CPL
        DB::table('cpl_cpmk')->insert([
            'id_cpl' => $cpl_id,
            'id_cpmk' => $cpmk_id,
        ]);
        
        // Map CPMK to MK
        DB::table('cpmk_mk')->insert([
            'id_cpmk' => $cpmk_id,
            'kode_mk' => 'IF101',
        ]);
        
        // Create sample student
        DB::table('mahasiswas')->insert([
            'nim' => '24001',
            'nama_mahasiswa' => 'Budi Santoso',
            'kode_prodi' => 'TI',
            'id_tahun_angkatan' => $tahun_id,
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Create sample assessment technique
        DB::table('teknik_penilaian')->insert([
            'nama_teknik' => 'UTS',
            'kode_mk' => 'IF101',
            'id_cpl' => $cpl_id,
            'id_cpmk' => $cpmk_id,
            'bobot' => 40,
            'id_tahun' => $tahun_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $tek_pen_id = DB::getPdo()->lastInsertId();
        
        // Add sample grade
        DB::table('nilai_mahasiswa')->insert([
            'nim' => '24001',
            'kode_mk' => 'IF101',
            'id_teknik' => $tek_pen_id,
            'id_cpl' => $cpl_id,
            'id_cpmk' => $cpmk_id,
            'nilai' => 85,
            'id_tahun' => $tahun_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}