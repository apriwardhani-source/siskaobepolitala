<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Support\Facades\DB;

class Wadir1DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        // Parameter filter
        $id_tahun = $request->get('id_tahun');              // disiapkan untuk export excel (jika diperlukan)
        $tahun_progress = $request->get('tahun_progress');  // tahun yang dipakai untuk progress

        $availableYears = Tahun::orderBy('tahun', 'desc')->get();

        // Wadir 1 melihat semua prodi
        $prodis = Prodi::all();

        // Hitung total prodi dan status hanya jika tahun dipilih
        $prodicount = $tahun_progress ? Prodi::count() : 0;
        $ProdiSelesai = 0;
        $ProdiProgress = 0;
        $ProdiBelumMulai = 0;

        foreach ($prodis as $prodi) {
            if (!$tahun_progress) {
                $prodi->avg_progress = 0;
                $prodi->progress_cpl = 0;
                $prodi->progress_sks_mk = 0;
                $prodi->progress_mk = 0;
                $prodi->progress_cpmk = 0;
                $prodi->progress_subcpmk = 0;
                continue;
            }

            // CPL per prodi & tahun
            $prodi->cpl_count = DB::table('capaian_profil_lulusans')
                ->where('kode_prodi', $prodi->kode_prodi)
                ->when($tahun_progress, fn ($q) => $q->where('id_tahun', $tahun_progress))
                ->count();

            // Total SKS Mata Kuliah per prodi (tanpa filter tahun, sama seperti Kaprodi/Admin)
            $prodi->sks_mk = DB::table('mata_kuliahs')
                ->where('kode_prodi', $prodi->kode_prodi)
                ->sum('sks_mk');

            // Jumlah Mata Kuliah per prodi
            $prodi->mk_count = DB::table('mata_kuliahs')
                ->where('kode_prodi', $prodi->kode_prodi)
                ->count();

            // CPMK per prodi & tahun (lewat CPL)
            $prodi->cpmk_count = DB::table('cpl_cpmk')
                ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
                ->where('cpl.kode_prodi', $prodi->kode_prodi)
                ->when($tahun_progress, fn ($q) => $q->where('cpl.id_tahun', $tahun_progress))
                ->distinct()
                ->count('cpl_cpmk.id_cpmk');

            // Sub CPMK per prodi & tahun (lewat CPMK + CPL)
            $prodi->subcpmk_count = DB::table('sub_cpmks')
                ->join('capaian_pembelajaran_mata_kuliahs as cpmk', 'sub_cpmks.id_cpmk', '=', 'cpmk.id_cpmk')
                ->join('cpl_cpmk', 'cpmk.id_cpmk', '=', 'cpl_cpmk.id_cpmk')
                ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
                ->where('cpl.kode_prodi', $prodi->kode_prodi)
                ->when($tahun_progress, fn ($q) => $q->where('cpl.id_tahun', $tahun_progress))
                ->distinct()
                ->count('sub_cpmks.id_sub_cpmk');

            // Target sama seperti KaprodiDashboardController (tanpa PL dan BK)
            $target = [
                'cpl'      => 9,
                'sks_mk'   => 144,
                'mk'       => 48,
                'cpmk'     => 20,
                'subcpmk'  => 40,
            ];

            // Progress komponen
            $progress_cpl = $prodi->cpl_count > 0
                ? min(100, round(($prodi->cpl_count / $target['cpl']) * 100))
                : 0;

            $progress_sks_mk = $prodi->sks_mk > 0
                ? min(100, round(($prodi->sks_mk / $target['sks_mk']) * 100))
                : 0;

            $progress_mk = $prodi->mk_count > 0
                ? min(100, round(($prodi->mk_count / $target['mk']) * 100))
                : 0;

            $progress_cpmk = $prodi->cpmk_count > 0
                ? min(100, round(($prodi->cpmk_count / $target['cpmk']) * 100))
                : 0;

            $progress_subcpmk = $prodi->subcpmk_count > 0
                ? min(100, round(($prodi->subcpmk_count / $target['subcpmk']) * 100))
                : 0;

            // Rata-rata 5 komponen (CPL, SKS, MK, CPMK, SubCPMK) mengikuti Kaprodi
            $avg = round(
                ($progress_cpl + $progress_sks_mk + $progress_mk + $progress_cpmk + $progress_subcpmk) / 5
            );

            $prodi->progress_cpl = $progress_cpl;
            $prodi->progress_sks_mk = $progress_sks_mk;
            $prodi->progress_mk = $progress_mk;
            $prodi->progress_cpmk = $progress_cpmk;
            $prodi->progress_subcpmk = $progress_subcpmk;
            $prodi->avg_progress = $avg;

            // Hitung status
            if ($avg === 100) {
                $ProdiSelesai++;
            } elseif ($avg > 0) {
                $ProdiProgress++;
            } else {
                $ProdiBelumMulai++;
            }
        }

        return view('wadir1.dashboard', compact(
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

