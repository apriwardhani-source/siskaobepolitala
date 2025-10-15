<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use App\Models\Tahun;
use App\Models\NilaiMahasiswa;

class DosenController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get mata kuliah yang diampu oleh dosen ini
        $mataKuliahs = $user->mataKuliahDiajar()
            ->with(['prodi', 'dosen'])
            ->get();
        
        // Get tahun kurikulum
        $tahunKurikulums = Tahun::all();
        
        // Statistik
        $totalMK = $mataKuliahs->count();
        $totalMahasiswa = Mahasiswa::where('kode_prodi', $user->kode_prodi)
            ->where('status', 'aktif')
            ->count();
        
        return view('dosen.dashboard', compact('mataKuliahs', 'tahunKurikulums', 'totalMK', 'totalMahasiswa'));
    }

    public function penilaian(Request $request)
    {
        $user = Auth::user();
        
        // Get mata kuliah yang diampu
        $mataKuliahs = $user->mataKuliahDiajar()
            ->with(['prodi'])
            ->get();
        
        // Get tahun kurikulum
        $tahunKurikulums = Tahun::all();
        
        // Jika form sudah disubmit (ada filter)
        $mahasiswas = null;
        $selectedMK = null;
        $selectedTahun = null;
        
        if ($request->filled('kode_mk') && $request->filled('id_tahun')) {
            $selectedMK = MataKuliah::where('kode_mk', $request->kode_mk)->first();
            $selectedTahun = $request->id_tahun;
            
            // Get mahasiswa berdasarkan prodi dan tahun kurikulum
            $mahasiswas = Mahasiswa::where('kode_prodi', $user->kode_prodi)
                ->where('id_tahun_kurikulum', $request->id_tahun)
                ->where('status', 'aktif')
                ->with(['tahunKurikulum'])
                ->orderBy('nim')
                ->get();
            
            // Get nilai yang sudah ada
            foreach ($mahasiswas as $mhs) {
                $nilai = NilaiMahasiswa::where('nim', $mhs->nim)
                    ->where('kode_mk', $request->kode_mk)
                    ->where('id_tahun', $request->id_tahun)
                    ->first();
                $mhs->nilai_akhir = $nilai ? $nilai->nilai_akhir : null;
            }
        }
        
        return view('dosen.penilaian.index', compact('mataKuliahs', 'tahunKurikulums', 'mahasiswas', 'selectedMK', 'selectedTahun'));
    }

    public function storeNilai(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'kode_mk' => 'required|exists:mata_kuliahs,kode_mk',
            'id_tahun' => 'required|exists:tahun,id_tahun',
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ]);
        
        $updated = 0;
        $created = 0;
        
        foreach ($request->nilai as $nim => $nilai_akhir) {
            if ($nilai_akhir === null || $nilai_akhir === '') {
                continue;
            }
            
            // Cek apakah mahasiswa ada dan aktif
            $mahasiswa = Mahasiswa::where('nim', $nim)
                ->where('kode_prodi', $user->kode_prodi)
                ->where('status', 'aktif')
                ->first();
            
            if (!$mahasiswa) {
                continue;
            }
            
            // Update or create nilai
            $nilaiMhs = NilaiMahasiswa::updateOrCreate(
                [
                    'nim' => $nim,
                    'kode_mk' => $request->kode_mk,
                    'id_tahun' => $request->id_tahun,
                ],
                [
                    'nilai_akhir' => $nilai_akhir,
                    'user_id' => $user->id, // dosen yang input
                ]
            );
            
            if ($nilaiMhs->wasRecentlyCreated) {
                $created++;
            } else {
                $updated++;
            }
        }
        
        $message = "Berhasil menyimpan nilai: {$created} data baru, {$updated} data diupdate.";
        return redirect()->route('dosen.penilaian.index', [
            'kode_mk' => $request->kode_mk,
            'id_tahun' => $request->id_tahun
        ])->with('success', $message);
    }
}
