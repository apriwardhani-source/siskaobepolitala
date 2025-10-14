<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Wadir1PemetaanCplBkMkController extends Controller
{
    public function index(Request $request)
    {
        $prodis = DB::table('prodis')->get();
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');

        $tahun_tersedia = DB::table('tahun')
            ->select('id_tahun', 'nama_kurikulum', 'tahun')
            ->orderBy('tahun', 'desc')
            ->get();

        if (!$kode_prodi) {
            return view('wadir1.pemetaancplmkbk.index', [
                'cpls' => collect(),
                'bks' => collect(),
                'matrix' => [],
                'kode_prodi' => '',
                'prodis' => $prodis,
                'prodiByCpl' => [],
                'prodi' => null,
                'id_tahun' => $id_tahun,
                'tahun_tersedia' => $tahun_tersedia,
            ]);
        }

        // Ambil prodi
        $prodi = $prodis->where('kode_prodi', $kode_prodi)->first();

        // Ambil CPL
        $cpls = DB::table('capaian_profil_lulusans as cpl')
            ->join('cpl_pl as cp', 'cpl.id_cpl', '=', 'cp.id_cpl')
            ->join('profil_lulusans as pl', 'cp.id_pl', '=', 'pl.id_pl')
            ->where('pl.kode_prodi', $kode_prodi)
            ->when($id_tahun, fn($q) => $q->where('pl.id_tahun', $id_tahun))
            ->select('cpl.*')
            ->orderByRaw("CAST(SUBSTRING(cpl.kode_cpl, 4) AS UNSIGNED)")
            ->get();

        $cplIds = $cpls->pluck('id_cpl');

        // Ambil BK yang terhubung dengan CPL
        $bks = DB::table('bahan_kajians as bk')
            ->join('cpl_bk as cb', 'bk.id_bk', '=', 'cb.id_bk')
            ->whereIn('cb.id_cpl', $cplIds)
            ->select('bk.*')
            ->distinct()
            ->orderBy('bk.kode_bk')
            ->get();

        // Ambil MK yang berelasi dengan CPL & BK
        $mkCplBk = DB::table('mata_kuliahs as mk')
            ->leftJoin('cpl_mk', 'mk.kode_mk', '=', 'cpl_mk.kode_mk')
            ->leftJoin('bk_mk', 'mk.kode_mk', '=', 'bk_mk.kode_mk')
            ->whereIn('cpl_mk.id_cpl', $cplIds)
            ->select('cpl_mk.id_cpl', 'bk_mk.id_bk', 'mk.nama_mk')
            ->get();

        $matrix = [];
        foreach ($mkCplBk as $row) {
            if ($row->id_cpl && $row->id_bk) {
                $matrix[$row->id_cpl][$row->id_bk][] = $row->nama_mk;
            }
        }

        // Prodi untuk tooltip CPL
        $prodiByCpl = [];
        foreach ($cpls as $cpl) {
            $prodiByCpl[$cpl->id_cpl] = DB::table('cpl_pl')
                ->join('profil_lulusans', 'cpl_pl.id_pl', '=', 'profil_lulusans.id_pl')
                ->join('prodis', 'profil_lulusans.kode_prodi', '=', 'prodis.kode_prodi')
                ->where('cpl_pl.id_cpl', $cpl->id_cpl)
                ->where('profil_lulusans.kode_prodi', $kode_prodi)
                ->when($id_tahun, fn($q) => $q->where('profil_lulusans.id_tahun', $id_tahun))
                ->value('prodis.nama_prodi');
        }

        return view('wadir1.pemetaancplmkbk.index', compact(
            'cpls',
            'bks',
            'matrix',
            'kode_prodi',
            'prodis',
            'prodiByCpl',
            'prodi',
            'id_tahun',
            'tahun_tersedia'
        ));
    }
}
