<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPemetaanCplMkController extends Controller
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

        if (empty($kode_prodi)) {
            return view('admin.pemetaancplmk.index', [
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

        $prodi_aktif = $prodis->where('kode_prodi', $kode_prodi)->first();

        // Query CPL dengan struktur baru: CPL langsung punya kode_prodi dan id_tahun
        $cpls = DB::table('capaian_profil_lulusans as cpl')
            ->where('cpl.kode_prodi', $kode_prodi)
            ->when($id_tahun, function ($query) use ($id_tahun) {
                return $query->where('cpl.id_tahun', $id_tahun);
            })
            ->select('cpl.*')
            ->orderBy('cpl.kode_cpl', 'asc')
            ->distinct()
            ->get();

        $cplIds = $cpls->pluck('id_cpl')->toArray();

        // Query nama prodi langsung dari CPL
        $prodiByCpl = DB::table('capaian_profil_lulusans as cpl')
            ->join('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->when($kode_prodi, function ($query) use ($kode_prodi) {
                return $query->where('cpl.kode_prodi', $kode_prodi);
            })
            ->when($id_tahun, function ($query) use ($id_tahun) {
                return $query->where('cpl.id_tahun', $id_tahun);
            })
            ->select('cpl.id_cpl', 'prodis.nama_prodi')
            ->distinct()
            ->get()
            ->groupBy('id_cpl')
            ->map(function ($items) {
                return $items->first()->nama_prodi ?? '-';
            });

        // Query Mata Kuliah yang sudah di-mapping dengan CPL
        $mks = DB::table('cpl_mk')
            ->join('mata_kuliahs', 'cpl_mk.kode_mk', '=', 'mata_kuliahs.kode_mk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->join('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->where('cpl.kode_prodi', $kode_prodi)
            ->when($id_tahun, function ($query) use ($id_tahun) {
                return $query->where('cpl.id_tahun', $id_tahun);
            })
            ->whereIn('cpl_mk.id_cpl', $cplIds)
            ->select('mata_kuliahs.*', 'prodis.nama_prodi')
            ->orderBy('mata_kuliahs.kode_mk', 'asc')
            ->distinct()
            ->get();

        // Query relasi CPL-MK
        $relasi = DB::table('cpl_mk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->where('cpl.kode_prodi', $kode_prodi)
            ->when($id_tahun, function ($query) use ($id_tahun) {
                return $query->where('cpl.id_tahun', $id_tahun);
            })
            ->whereIn('cpl_mk.id_cpl', $cplIds)
            ->select('cpl_mk.*')
            ->get()
            ->groupBy('kode_mk');

        return view('admin.pemetaancplmk.index', compact(
            'cpls',
            'mks',
            'relasi',
            'kode_prodi',
            'prodis',
            'prodi_aktif',
            'prodiByCpl',
            'id_tahun',
            'tahun_tersedia'
        ));
    }
}
