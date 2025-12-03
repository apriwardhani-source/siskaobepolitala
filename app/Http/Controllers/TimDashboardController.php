<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TimDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403, 'Akses ditolak.');
        }

        $kodeProdi = $user->kode_prodi;
        $tahun_progress = $request->get('tahun_progress');
        $id_tahun = $request->get('id_tahun');
        $availableYears = Tahun::orderBy('tahun', 'desc')->get();

        $prodis = Prodi::with(['profillulusans' => function ($query) use ($tahun_progress) {
            if ($tahun_progress) {
                $query->where('id_tahun', $tahun_progress);
            }
        }])->where('kode_prodi', $kodeProdi)->get();

        $prodicount = $tahun_progress ? $prodis->count() : 0;
        $ProdiSelesai = 0;
        $ProdiProgress = 0;
        $ProdiBelumMulai = 0;

        if ($tahun_progress) {
            foreach ($prodis as $prodi) {
                // Hitung Profil Lulusan (tidak masuk ke rata-rata, hanya informasi tambahan)
                $prodi->pl_count = DB::table('profil_lulusans')
                    ->where('kode_prodi', $prodi->kode_prodi)
                    ->when($tahun_progress, fn($q) => $q->where('id_tahun', $tahun_progress))
                    ->count();

                // Hitung CPL per prodi & tahun (mengikuti AdminDashboardController)
                $prodi->cpl_count = DB::table('capaian_profil_lulusans')
                    ->where('kode_prodi', $prodi->kode_prodi)
                    ->when($tahun_progress, fn($q) => $q->where('id_tahun', $tahun_progress))
                    ->count();

                // Total SKS & jumlah MK per prodi
                $prodi->sks_mk = DB::table('mata_kuliahs')
                    ->where('kode_prodi', $prodi->kode_prodi)
                    ->sum('sks_mk');

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

                // Hitung Sub CPMK per prodi & tahun (lewat CPMK + CPL)
                $prodi->subcpmk_count = DB::table('sub_cpmks')
                    ->join('capaian_pembelajaran_mata_kuliahs as cpmk', 'sub_cpmks.id_cpmk', '=', 'cpmk.id_cpmk')
                    ->join('cpl_cpmk', 'cpmk.id_cpmk', '=', 'cpl_cpmk.id_cpmk')
                    ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
                    ->where('cpl.kode_prodi', $prodi->kode_prodi)
                    ->when($tahun_progress, fn($q) => $q->where('cpl.id_tahun', $tahun_progress))
                    ->distinct()
                    ->count('sub_cpmks.id_sub_cpmk');

                // Target sama seperti AdminDashboardController
                $target_cpl = 9;
                $target_sks_mk = 144;
                $target_cpmk = 20;
                $target_subcpmk = 40;

                // Progress 4 komponen (CPL, SKS MK, CPMK, Sub CPMK)
                $progress_cpl = $prodi->cpl_count > 0 ? min(100, round(($prodi->cpl_count / $target_cpl) * 100)) : 0;
                $progress_sks_mk = $prodi->sks_mk > 0 ? min(100, round(($prodi->sks_mk / $target_sks_mk) * 100)) : 0;
                $progress_cpmk = $prodi->cpmk_count > 0 ? min(100, round(($prodi->cpmk_count / $target_cpmk) * 100)) : 0;
                $progress_subcpmk = $prodi->subcpmk_count > 0 ? min(100, round(($prodi->subcpmk_count / $target_subcpmk) * 100)) : 0;

                // Rata-rata sama seperti admin
                $avg = round(($progress_cpl + $progress_sks_mk + $progress_cpmk + $progress_subcpmk) / 4);

                $prodi->progress_cpl = $progress_cpl;
                $prodi->progress_sks_mk = $progress_sks_mk;
                $prodi->progress_cpmk = $progress_cpmk;
                $prodi->progress_subcpmk = $progress_subcpmk;
                $prodi->avg_progress = $avg;

                if ($avg == 100) {
                    $ProdiSelesai++;
                } elseif ($avg > 0) {
                    $ProdiProgress++;
                } else {
                    $ProdiBelumMulai++;
                }
            }
        }

        return view('tim.dashboard', compact(
            'prodis',
            'prodicount',
            'ProdiSelesai',
            'ProdiProgress',
            'ProdiBelumMulai',
            'tahun_progress',
            'id_tahun',
            'availableYears'
        ));
    }
}
