<?php

namespace App\Imports;

use App\Models\CapaianProfilLulusan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CplImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $user = Auth::user();
        $kodeProdi = $user->kode_prodi ?? null;

        // Ambil tahun kurikulum terbaru sebagai default
        $tahunTerbaru = \App\Models\Tahun::orderBy('tahun', 'desc')->first();
        $idTahun = $tahunTerbaru ? $tahunTerbaru->id_tahun : null;

        return CapaianProfilLulusan::create([
            'kode_cpl' => $row['kode_cpl'],
            'deskripsi_cpl' => $row['deskripsi_cpl'],
            'status_cpl' => null,
            'kode_prodi' => $kodeProdi,
            'id_tahun' => $idTahun,
        ]);
    }

    public function rules(): array
    {
        return [
            'kode_cpl' => 'required|string|max:10|unique:capaian_profil_lulusans,kode_cpl',
            'deskripsi_cpl' => 'required|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'kode_cpl.required' => 'Kode CPL wajib diisi',
            'kode_cpl.unique' => 'Kode CPL sudah ada di database',
            'kode_cpl.max' => 'Kode CPL maksimal 10 karakter',
            'deskripsi_cpl.required' => 'Deskripsi CPL wajib diisi',
        ];
    }
}
