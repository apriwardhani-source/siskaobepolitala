<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KaprodiDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403, 'Akses ditolak.');
        }

        $kodeProdi = $user->kode_prodi;
        $tahun_progress = $request->get('tahun_progress'); // untuk progress display
        $id_tahun = $request->get('id_tahun'); // untuk export excel
        $availableYears = Tahun::orderBy('tahun', 'desc')->get();

        // Get single prodi info
        $prodi = Prodi::where('kode_prodi', $kodeProdi)->first();
        
        if (!$prodi) {
            abort(403, 'Program studi tidak ditemukan.');
        }

        // Initialize stats
        $stats = null;

        if ($tahun_progress) {
            // Hitung CPL per prodi & tahun (tanpa PL dan BK)
            $cpl_count = DB::table('capaian_profil_lulusans')
                ->where('kode_prodi', $kodeProdi)
                ->where('id_tahun', $tahun_progress)
                ->count();

            // Hitung total SKS Mata Kuliah per prodi
            $sks_mk = DB::table('mata_kuliahs')
                ->where('kode_prodi', $kodeProdi)
                ->sum('sks_mk');

            // Hitung jumlah Mata Kuliah
            $mk_count = DB::table('mata_kuliahs')
                ->where('kode_prodi', $kodeProdi)
                ->count();

            // Hitung CPMK per prodi & tahun (lewat CPL)
            $cpmk_count = DB::table('cpl_cpmk')
                ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
                ->where('cpl.kode_prodi', $kodeProdi)
                ->where('cpl.id_tahun', $tahun_progress)
                ->distinct()
                ->count('cpl_cpmk.id_cpmk');

            // Hitung Sub CPMK per prodi & tahun (lewat CPMK → CPL)
            $subcpmk_count = DB::table('sub_cpmks')
                ->join('capaian_pembelajaran_mata_kuliahs as cpmk', 'sub_cpmks.id_cpmk', '=', 'cpmk.id_cpmk')
                ->join('cpl_cpmk', 'cpmk.id_cpmk', '=', 'cpl_cpmk.id_cpmk')
                ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
                ->where('cpl.kode_prodi', $kodeProdi)
                ->where('cpl.id_tahun', $tahun_progress)
                ->distinct()
                ->count('sub_cpmks.id_sub_cpmk');

            // Hitung progress (tanpa PL dan BK)
            $target = [
                'cpl' => 9,
                'sks_mk' => 144,
                'mk' => 48,
                'cpmk' => 20,
                'subcpmk' => 40
            ];

            $progress = [
                'cpl' => min(100, $cpl_count > 0 ? round(($cpl_count / $target['cpl']) * 100) : 0),
                'sks_mk' => min(100, $sks_mk > 0 ? round(($sks_mk / $target['sks_mk']) * 100) : 0),
                'mk' => min(100, $mk_count > 0 ? round(($mk_count / $target['mk']) * 100) : 0),
                'cpmk' => min(100, $cpmk_count > 0 ? round(($cpmk_count / $target['cpmk']) * 100) : 0),
                'subcpmk' => min(100, $subcpmk_count > 0 ? round(($subcpmk_count / $target['subcpmk']) * 100) : 0),
            ];

            $avg_progress = round(array_sum($progress) / count($progress));

            // Only create stats if there's any data
            if ($cpl_count > 0 || $sks_mk > 0 || $cpmk_count > 0 || $subcpmk_count > 0) {
                $stats = [
                    'cpl_count' => $cpl_count,
                    'sks_mk' => $sks_mk,
                    'mk_count' => $mk_count,
                    'cpmk_count' => $cpmk_count,
                    'subcpmk_count' => $subcpmk_count,
                    'progress_cpl' => $progress['cpl'],
                    'progress_sks_mk' => $progress['sks_mk'],
                    'progress_mk' => $progress['mk'],
                    'progress_cpmk' => $progress['cpmk'],
                    'progress_subcpmk' => $progress['subcpmk'],
                    'avg_progress' => $avg_progress,
                    'target' => $target
                ];
            }
        }

        return view('kaprodi.dashboard', compact(
            'prodi',
            'stats',
            'id_tahun',
            'availableYears'
        ));
    }
}
