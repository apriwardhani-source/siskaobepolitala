<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Tahun;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilObeController extends Controller
{
    public function index(Request $request)
    {
        $tahun_angkatan = $request->tahun_angkatan;
        $kode_prodi = $request->kode_prodi;
        
        $mahasiswas = collect();
        $tahun_options = Tahun::orderBy('tahun', 'desc')->get();
        $prodi_options = Prodi::all();
        
        if ($tahun_angkatan) {
            $query = Mahasiswa::where('tahun_kurikulum', $tahun_angkatan)
                ->with('prodi');
                
            if ($kode_prodi) {
                $query->where('kode_prodi', $kode_prodi);
            }
            
            $mahasiswas = $query->orderBy('nama')->get();
        }
        
        return view('admin.hasilobe.index', compact('mahasiswas', 'tahun_options', 'prodi_options', 'tahun_angkatan', 'kode_prodi'));
    }
    
    public function detail($nim)
    {
        $mahasiswa = Mahasiswa::with('prodi')->where('nim', $nim)->firstOrFail();
        
        // Query untuk mengambil data nilai dengan struktur MK -> CPL -> CPMK
        $hasil_obe = DB::table('nilai_mahasiswa as nm')
            ->join('mata_kuliahs as mk', 'nm.kode_mk', '=', 'mk.kode_mk')
            ->leftJoin('capaian_profil_lulusans as cpl', 'nm.id_cpl', '=', 'cpl.id_cpl')
            ->leftJoin('capaian_pembelajaran_mata_kuliahs as cpmk', 'nm.id_cpmk', '=', 'cpmk.id_cpmk')
            ->leftJoin('teknik_penilaian as tp', 'nm.id_teknik', '=', 'tp.id_teknik')
            ->where('nm.nim', $nim)
            ->select(
                'mk.kode_mk',
                'mk.nama_mk',
                'mk.semester_mk',
                'mk.sks_mk',
                'cpl.kode_cpl',
                'cpl.deskripsi_cpl',
                'cpmk.kode_cpmk',
                'cpmk.deskripsi_cpmk',
                'tp.bobot as skor_maks',
                DB::raw('COALESCE(nm.nilai_akhir, 0) as nilai_perkuliahan')
            )
            ->orderBy('mk.semester_mk')
            ->orderBy('mk.kode_mk')
            ->orderBy('cpl.kode_cpl')
            ->orderBy('cpmk.kode_cpmk')
            ->get();
        
        // Group data by MK
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
        
        return view('admin.hasilobe.detail', compact('mahasiswa', 'grouped_data'));
    }
}
