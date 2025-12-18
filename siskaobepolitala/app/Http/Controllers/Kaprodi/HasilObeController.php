<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HasilObeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || !$user->kode_prodi) {
            abort(403, 'Akses ditolak.');
        }
        
        $kode_prodi = $user->kode_prodi;
        $tahun_angkatan = $request->tahun_angkatan;
        
        $mahasiswas = collect();
        $tahun_options = Tahun::orderBy('tahun', 'desc')->get();
        $prodi_options = \App\Models\Prodi::where('kode_prodi', $kode_prodi)->get();
        
        if ($tahun_angkatan) {
            $tahun = Tahun::where('tahun', $tahun_angkatan)->first();
            if ($tahun) {
                $mahasiswas = Mahasiswa::where('id_tahun_kurikulum', $tahun->id_tahun)
                    ->where('kode_prodi', $kode_prodi)
                    ->with(['prodi', 'tahunKurikulum'])
                    ->orderBy('nama_mahasiswa')
                    ->get();
            }
        }
        
        return view('kaprodi.hasilobe.index', compact('mahasiswas', 'tahun_options', 'tahun_angkatan', 'kode_prodi', 'prodi_options'));
    }
    
    public function detail($nim)
    {
        $user = Auth::user();
        
        $mahasiswa = Mahasiswa::with('prodi')
            ->where('nim', $nim)
            ->where('kode_prodi', $user->kode_prodi)
            ->firstOrFail();
        
        $nilaiMahasiswa = DB::table('nilai_mahasiswa')
            ->where('nim', $nim)
            ->get()
            ->keyBy('kode_mk');
        
        $hasil_obe = DB::table('mata_kuliahs as mk')
            ->join('cpmk_mk', 'mk.kode_mk', '=', 'cpmk_mk.kode_mk')
            ->join('capaian_pembelajaran_mata_kuliahs as cpmk', 'cpmk_mk.id_cpmk', '=', 'cpmk.id_cpmk')
            ->leftJoin('cpl_cpmk', 'cpmk.id_cpmk', '=', 'cpl_cpmk.id_cpmk')
            ->leftJoin('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
            ->whereIn('mk.kode_mk', $nilaiMahasiswa->keys()->toArray())
            ->select(
                'mk.kode_mk',
                'mk.nama_mk',
                'mk.semester_mk',
                'mk.sks_mk',
                'cpl.kode_cpl',
                'cpl.deskripsi_cpl',
                'cpmk.kode_cpmk',
                'cpmk.deskripsi_cpmk'
            )
            ->orderBy('mk.semester_mk')
            ->orderBy('mk.kode_mk')
            ->orderBy('cpl.kode_cpl')
            ->orderBy('cpmk.kode_cpmk')
            ->get()
            ->map(function($item) use ($nilaiMahasiswa) {
                $nilai = $nilaiMahasiswa->get($item->kode_mk);
                $item->skor_maks = 100;
                $item->nilai_perkuliahan = $nilai ? $nilai->nilai_akhir : 0;
                return $item;
            });
        
        $grouped_data = $hasil_obe->groupBy('kode_mk')->map(function ($items) {
            return [
                'kode_mk' => $items->first()->kode_mk,
                'nama_mk' => $items->first()->nama_mk,
                'semester_mk' => $items->first()->semester_mk,
                'sks_mk' => $items->first()->sks_mk,
                'details' => $items->map(function ($item) {
                    return [
                        'kode_cpl' => $item->kode_cpl ?? '-',
                        'kode_cpmk' => $item->kode_cpmk ?? '-',
                        'skor_maks' => $item->skor_maks ?? 100,
                        'nilai_perkuliahan' => $item->nilai_perkuliahan
                    ];
                })
            ];
        });
        
        return view('kaprodi.hasilobe.detail', compact('mahasiswa', 'grouped_data'));
    }
}
