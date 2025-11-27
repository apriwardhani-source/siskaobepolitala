<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Wadir1PemetaanCplMkController extends Controller
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

        // Izinkan tampil jika salah satu filter terisi (prodi atau tahun)
        $hasFilter = !empty($kode_prodi) || !empty($id_tahun);
        if (!$hasFilter) {
            return view('wadir1.pemetaancplmk.index', [
                'cpls' => collect(),
                'mks' => collect(),
                'relasi' => [],
                'kode_prodi' => '',
                'prodis' => $prodis,
                'prodi' => null,
                'prodiByCpl' => collect(),
                'id_tahun' => $id_tahun,
                'tahun_tersedia' => $tahun_tersedia,
            ]);
        }

        $prodi = $kode_prodi ? $prodis->where('kode_prodi', $kode_prodi)->first() : null;

        // Ambil CPL langsung dari tabel CPL, filter dinamis prodi/tahun
        $cpls = DB::table('capaian_profil_lulusans as cpl')
            ->select('cpl.*')
            ->when($kode_prodi, fn($q) => $q->where('cpl.kode_prodi', $kode_prodi))
            ->when($id_tahun, fn($q) => $q->where('cpl.id_tahun', $id_tahun))
            ->orderBy('cpl.kode_cpl', 'asc')
            ->get();

        $cplIds = $cpls->pluck('id_cpl')->toArray();

        // Prodi berdasarkan CPL (untuk tooltip atau info)
        $prodiByCpl = DB::table('capaian_profil_lulusans as cpl')
            ->join('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->select('cpl.id_cpl', 'prodis.nama_prodi')
            ->when($kode_prodi, fn($q) => $q->where('cpl.kode_prodi', $kode_prodi))
            ->when($id_tahun, fn($q) => $q->where('cpl.id_tahun', $id_tahun))
            ->get()
            ->groupBy('id_cpl')
            ->map(fn($items) => $items->first()->nama_prodi ?? '-');

        // Ambil Mata Kuliah khusus untuk prodi ini
        $mks = DB::table('cpl_mk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->join('mata_kuliahs as mk', 'cpl_mk.kode_mk', '=', 'mk.kode_mk')
            ->leftJoin('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->when($kode_prodi, fn($q) => $q->where('cpl.kode_prodi', $kode_prodi))
            ->when($id_tahun, fn($q) => $q->where('cpl.id_tahun', $id_tahun))
            ->select('mk.*', 'prodis.nama_prodi')
            ->orderBy('mk.kode_mk', 'asc')
            ->distinct()
            ->get();

        // Ambil relasi CPL - MK, filter CPL yang relevan dengan prodi ini
        $relasi = DB::table('cpl_mk')
            ->whereIn('id_cpl', $cplIds)
            ->get()
            ->groupBy('kode_mk');

        return view('wadir1.pemetaancplmk.index', compact(
            'cpls',
            'mks',
            'relasi',
            'kode_prodi',
            'prodis',
            'prodi',
            'prodiByCpl',
            'id_tahun',
            'tahun_tersedia'
        ));
    }
}
