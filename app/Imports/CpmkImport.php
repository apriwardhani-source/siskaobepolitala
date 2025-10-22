<?php

namespace App\Imports;

use App\Models\CapaianPembelajaranMataKuliah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CpmkImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $idCpl;

    public function __construct($idCpl)
    {
        $this->idCpl = $idCpl;
    }

    public function model(array $row)
    {
        $user = Auth::user();
        $kodeProdi = $user->kode_prodi ?? null;

        // Create CPMK
        $cpmk = CapaianPembelajaranMataKuliah::create([
            'kode_cpmk' => $row['kode_cpmk'],
            'deskripsi_cpmk' => $row['deskripsi_cpmk'],
        ]);

        // Insert relasi CPL-CPMK dengan id_cpl yang dipilih
        DB::table('cpl_cpmk')->insert([
            'id_cpmk' => $cpmk->id_cpmk,
            'id_cpl' => $this->idCpl
        ]);

        // Insert relasi CPMK-MK jika ada kode_mk
        if (!empty($row['kode_mk'])) {
            // Support both comma (,) and semicolon (;) as separators
            $separator = strpos($row['kode_mk'], ';') !== false ? ';' : ',';
            $kodeMks = explode($separator, $row['kode_mk']);
            
            foreach ($kodeMks as $kodeMk) {
                $kodeMk = trim($kodeMk);
                
                if (empty($kodeMk)) continue;
                
                $mk = DB::table('mata_kuliahs')
                    ->where('kode_mk', $kodeMk)
                    ->where('kode_prodi', $kodeProdi)
                    ->first();

                if ($mk) {
                    DB::table('cpmk_mk')->insert([
                        'id_cpmk' => $cpmk->id_cpmk,
                        'kode_mk' => $mk->kode_mk
                    ]);
                }
            }
        }

        return $cpmk;
    }

    public function rules(): array
    {
        return [
            'kode_cpmk' => 'required|string|max:50',
            'deskripsi_cpmk' => 'required|string',
            'kode_mk' => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'kode_cpmk.required' => 'Kode CPMK wajib diisi',
            'kode_cpmk.max' => 'Kode CPMK maksimal 50 karakter',
            'deskripsi_cpmk.required' => 'Deskripsi CPMK wajib diisi',
        ];
    }
}
