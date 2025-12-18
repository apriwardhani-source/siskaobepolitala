<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $id_tahun = $request->get('id_tahun'); // untuk export Excel
        $tahun_progress = $request->get('tahun_progress'); // untuk progress bar

        $availableYears = Tahun::orderBy('tahun', 'desc')->get();

        $prodis = Prodi::all();

        // Hitung total prodi hanya jika pilih tahun, agar summary 0 semua sebelum difilter
        $prodicount = $tahun_progress ? Prodi::count() : 0;
        $ProdiSelesai = 0;
        $ProdiProgress = 0;
        $ProdiBelumMulai = 0;

        foreach ($prodis as $prodi) {
            if (!$tahun_progress) {
                $prodi->avg_progress = 0;
                $prodi->progress_cpl = 0;
                $prodi->progress_sks_mk = 0;
                $prodi->progress_cpmk = 0;
                $prodi->progress_subcpmk = 0;
                continue;
            }

            // Hitung Profil Lulusan (PL) per prodi & tahun
            $prodi->pl_count = DB::table('profil_lulusans')
                ->where('kode_prodi', $prodi->kode_prodi)
                ->when($tahun_progress, fn($q) => $q->where('id_tahun', $tahun_progress))
                ->count();

            // Hitung CPL per prodi & tahun (struktur baru: CPL langsung punya kode_prodi)
            $prodi->cpl_count = DB::table('capaian_profil_lulusans')
                ->where('kode_prodi', $prodi->kode_prodi)
                ->when($tahun_progress, fn($q) => $q->where('id_tahun', $tahun_progress))
                ->count();

            // Hitung total SKS Mata Kuliah per prodi
            $prodi->sks_mk = DB::table('mata_kuliahs')
                ->where('kode_prodi', $prodi->kode_prodi)
                ->sum('sks_mk');
            
            // Hitung jumlah Mata Kuliah
            $prodi->mk_count = DB::table('mata_kuliahs')
                ->where('kode_prodi', $prodi->kode_prodi)
                ->count();

            // Hitung CPMK per prodi & tahun (lewat CPL)
            $prodi->cpmk_count = DB::table('cpl_cpmk')
                ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
                ->where('cpl.kode_prodi', $prodi->kode_prodi)
                ->when($tahun_progress, fn($q) => $q->where('cpl.id_tahun', $tahun_progress))
                ->distinct()
                ->count('cpl_cpmk.id_cpmk');

            // Hitung Sub CPMK per prodi & tahun (lewat CPMK → CPL)
            $prodi->subcpmk_count = DB::table('sub_cpmks')
                ->join('capaian_pembelajaran_mata_kuliahs as cpmk', 'sub_cpmks.id_cpmk', '=', 'cpmk.id_cpmk')
                ->join('cpl_cpmk', 'cpmk.id_cpmk', '=', 'cpl_cpmk.id_cpmk')
                ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
                ->where('cpl.kode_prodi', $prodi->kode_prodi)
                ->when($tahun_progress, fn($q) => $q->where('cpl.id_tahun', $tahun_progress))
                ->distinct()
                ->count('sub_cpmks.id_sub_cpmk');

            // Target default berdasarkan standar kurikulum OBE
            $target_cpl = 9;          // Minimal 9 CPL (3 sikap, 3 pengetahuan, 3 keterampilan)
            $target_sks_mk = 144;     // Total SKS untuk program D4 (144 SKS)
            $target_cpmk = 20;        // Minimal CPMK berdasarkan jumlah MK
            $target_subcpmk = 40;     // Minimal Sub CPMK (2x CPMK)

            // Hitung progress (hanya 4 komponen: CPL, MK, CPMK, Sub CPMK)
            $progress_cpl = $prodi->cpl_count > 0 ? min(100, round(($prodi->cpl_count / $target_cpl) * 100)) : 0;
            $progress_sks_mk = $prodi->sks_mk > 0 ? min(100, round(($prodi->sks_mk / $target_sks_mk) * 100)) : 0;
            $progress_cpmk = $prodi->cpmk_count > 0 ? min(100, round(($prodi->cpmk_count / $target_cpmk) * 100)) : 0;
            $progress_subcpmk = $prodi->subcpmk_count > 0 ? min(100, round(($prodi->subcpmk_count / $target_subcpmk) * 100)) : 0;

            // Average dari 4 komponen
            $avg = round(($progress_cpl + $progress_sks_mk + $progress_cpmk + $progress_subcpmk) / 4);

            $prodi->progress_cpl = $progress_cpl;
            $prodi->progress_sks_mk = $progress_sks_mk;
            $prodi->progress_cpmk = $progress_cpmk;
            $prodi->progress_subcpmk = $progress_subcpmk;
            $prodi->avg_progress = $avg;

            // Hitung status
            if ($avg == 100) {
                $ProdiSelesai++;
            } elseif ($avg > 0) {
                $ProdiProgress++;
            } else {
                $ProdiBelumMulai++;
            }
        }

        return view('admin.dashboard', compact(
            'prodis',
            'prodicount',
            'ProdiSelesai',
            'ProdiProgress',
            'ProdiBelumMulai',
            'id_tahun',
            'tahun_progress',
            'availableYears'
        ));
    }
}
