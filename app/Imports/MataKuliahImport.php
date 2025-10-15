<?php

namespace App\Imports;

use App\Models\MataKuliah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MataKuliahImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $user = Auth::user();
        $kodeProdi = $user->kode_prodi ?? null;

        // Create mata kuliah
        $mk = MataKuliah::create([
            'kode_mk' => $row['kode_mk'],
            'nama_mk' => $row['nama_mk'],
            'sks_mk' => (int) $row['sks_mk'],
            'semester_mk' => (int) $row['semester_mk'],
            'kompetensi_mk' => $row['kompetensi_mk'],
            'jenis_mk' => $row['jenis_mk'] ?? 'Wajib',
            'kode_prodi' => $kodeProdi,
        ]);

        // Insert CPL relationships jika ada
        if (!empty($row['kode_cpl'])) {
            $kodeCpls = explode(',', $row['kode_cpl']);
            
            foreach ($kodeCpls as $kodeCpl) {
                $kodeCpl = trim($kodeCpl);
                
                $cpl = DB::table('capaian_profil_lulusans')
                    ->where('kode_cpl', $kodeCpl)
                    ->where('kode_prodi', $kodeProdi)
                    ->first();

                if ($cpl) {
                    DB::table('cpl_mk')->insert([
                        'kode_mk' => $mk->kode_mk,
                        'id_cpl' => $cpl->id_cpl
                    ]);
                }
            }
        }

        return $mk;
    }

    public function rules(): array
    {
        return [
            'kode_mk' => 'required|unique:mata_kuliahs,kode_mk',
            'nama_mk' => 'required|string|max:100',
            'sks_mk' => 'required|integer|min:1|max:24',
            'semester_mk' => 'required|integer|in:1,2,3,4,5,6,7,8',
            'kompetensi_mk' => 'required|in:pendukung,utama',
            'jenis_mk' => 'nullable|string|max:50',
            'kode_cpl' => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'kode_mk.required' => 'Kode MK wajib diisi',
            'kode_mk.unique' => 'Kode MK sudah ada di database',
            'nama_mk.required' => 'Nama MK wajib diisi',
            'sks_mk.required' => 'SKS wajib diisi',
            'sks_mk.min' => 'SKS minimal 1',
            'sks_mk.max' => 'SKS maksimal 24',
            'semester_mk.in' => 'Semester harus antara 1-8',
            'kompetensi_mk.in' => 'Kompetensi harus pendukung atau utama',
        ];
    }
}
