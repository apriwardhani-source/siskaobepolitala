<?php

namespace App\Imports;

use App\Models\NilaiMahasiswa;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Tahun;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class NilaiMahasiswaImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    protected $default_kode_mk;
    protected $default_id_tahun;
    protected $successCount = 0;
    protected $errorCount = 0;
    protected $errors = [];

    public function __construct($kode_mk = null, $id_tahun = null)
    {
        $this->default_kode_mk = $kode_mk;
        $this->default_id_tahun = $id_tahun;
    }

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cari NIM
        $nim = $row['nim'] ?? null;
        
        // Kode MK - dari file atau parameter default
        $kode_mk = $row['kode_mk'] ?? $this->default_kode_mk;
        
        // Tahun - dari file atau parameter default
        $tahun_value = $row['id_tahun'] ?? $row['tahun'] ?? $this->default_id_tahun;
        
        // Convert tahun (2025) ke id_tahun (foreign key)
        // Cek dulu apakah ada tahun dengan id_tahun = $tahun_value
        $tahunById = Tahun::where('id_tahun', $tahun_value)->first();
        if ($tahunById) {
            // Sudah berupa id_tahun yang valid
            $id_tahun = $tahun_value;
        } else {
            // Cari berdasarkan field tahun (misal "2025")
            $tahunByYear = Tahun::where('tahun', $tahun_value)->first();
            $id_tahun = $tahunByYear ? $tahunByYear->id_tahun : null;
        }
        
        // Validasi id_tahun
        if (!$id_tahun) {
            $this->errors[] = "Tahun tidak ditemukan: $tahun_value";
            $this->errorCount++;
            return null;
        }
        
        // Nilai
        $nilai = $row['nilai'] ?? $row['nilai_akhir'] ?? null;
        
        // Skip jika nilai kosong
        if ($nilai === null || $nilai === '') {
            return null;
        }
        
        // Validasi NIM
        if (!$nim) {
            $this->errors[] = "NIM tidak ditemukan";
            $this->errorCount++;
            return null;
        }

        // Validasi kode_mk
        if (!$kode_mk) {
            $this->errors[] = "Kode MK tidak ditemukan untuk NIM: $nim";
            $this->errorCount++;
            return null;
        }

        // Cek mahasiswa ada
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        if (!$mahasiswa) {
            $this->errors[] = "Mahasiswa tidak ditemukan: $nim";
            $this->errorCount++;
            return null;
        }

        // Cek mata kuliah ada
        $mataKuliah = MataKuliah::where('kode_mk', $kode_mk)->first();
        if (!$mataKuliah) {
            $this->errors[] = "Mata kuliah tidak ditemukan: $kode_mk";
            $this->errorCount++;
            return null;
        }

        // Ambil CPMK dan CPL pertama yang terkait dengan MK ini
        $cpmk = DB::table('cpmk_mk')
            ->where('kode_mk', $kode_mk)
            ->first();

        $id_cpmk = $cpmk ? $cpmk->id_cpmk : null;
        $id_cpl = null;

        if ($id_cpmk) {
            $cpl = DB::table('cpl_cpmk')
                ->where('id_cpmk', $id_cpmk)
                ->first();
            $id_cpl = $cpl ? $cpl->id_cpl : null;
        }

        // Update or create nilai
        NilaiMahasiswa::updateOrCreate(
            [
                'nim' => $nim,
                'kode_mk' => $kode_mk,
                'id_tahun' => $id_tahun,
            ],
            [
                'nilai_akhir' => $nilai,
                'user_id' => Auth::id(),
                'id_cpmk' => $id_cpmk,
                'id_cpl' => $id_cpl,
            ]
        );

        $this->successCount++;

        return null;
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function getErrorCount(): int
    {
        return $this->errorCount;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
