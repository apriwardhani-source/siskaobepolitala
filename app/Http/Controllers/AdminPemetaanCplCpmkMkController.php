<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CapaianProfilLulusan;
use App\Models\CapaianPembelajaranMataKuliah;
use App\Models\MataKuliah;

class AdminPemetaanCplCpmkMkController extends Controller
{
    public function index(Request $request)
    {
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');
        $prodis = DB::table('prodis')->get();

        if (!$kode_prodi) {
            $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
            return view("admin.pemetaancplcpmkmk.index", compact("prodis", "kode_prodi", "id_tahun", "tahun_tersedia"));
        }

        $prodi = $prodis->where('kode_prodi', $kode_prodi)->first();

        // Query tahun berdasarkan CPL (struktur baru)
        $tahun_tersedia = DB::table('capaian_profil_lulusans as cpl')
            ->join('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->where('cpl.kode_prodi', $kode_prodi)
            ->select('tahun.id_tahun', 'tahun.nama_kurikulum', 'tahun.tahun')
            ->distinct()
            ->orderBy('tahun.tahun', 'desc')
            ->get();

        // Query CPL-CPMK-MK (struktur baru)
        $query = DB::table('capaian_profil_lulusans as cpl')
            ->join('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->join('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->leftJoin('cpl_cpmk', 'cpl.id_cpl', '=', 'cpl_cpmk.id_cpl')
            ->leftJoin('capaian_pembelajaran_mata_kuliahs as cpmk', 'cpl_cpmk.id_cpmk', '=', 'cpmk.id_cpmk')
            ->leftJoin('cpmk_mk', 'cpmk.id_cpmk', '=', 'cpmk_mk.id_cpmk')
            ->leftJoin('mata_kuliahs as mk', 'cpmk_mk.kode_mk', '=', 'mk.kode_mk')
            ->select(
                'cpl.id_cpl',
                'cpl.kode_cpl',
                'cpl.deskripsi_cpl',
                'cpmk.id_cpmk',
                'cpmk.kode_cpmk',
                'cpmk.deskripsi_cpmk',
                'mk.nama_mk',
                'tahun.tahun'
            )
            ->where('cpl.kode_prodi', $kode_prodi);

        if ($id_tahun) {
            $query->where('cpl.id_tahun', $id_tahun);
        }

        $data = $query->orderBy('cpl.kode_cpl', 'asc')
            ->orderBy('cpmk.id_cpmk', 'asc')
            ->get();

        // Menyusun data dalam format yang mudah dipakai
        $matrix = [];
        foreach ($data as $row) {
            $matrix[$row->kode_cpl]['deskripsi'] = $row->deskripsi_cpl;
            if ($row->kode_cpmk) {
                $matrix[$row->kode_cpl]['cpmk'][$row->kode_cpmk]['deskripsi'] = $row->deskripsi_cpmk;
                if ($row->nama_mk) {
                    $matrix[$row->kode_cpl]['cpmk'][$row->kode_cpmk]['mk'][] = $row->nama_mk;
                }
            }
        }

        $dataKosong = empty($matrix) && $kode_prodi;

        return view('admin.pemetaancplcpmkmk.index', compact('matrix', 'prodis', 'kode_prodi', 'prodi', 'id_tahun', 'tahun_tersedia', 'dataKosong'));
    }

    public function pemenuhancplcpmkmk(Request $request)
    {
        $prodis = DB::table('prodis')->get();
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');

        if (!$kode_prodi) {
            $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
            return view("admin.pemetaancplcpmkmk.pemenuhancplcpmkmk", compact("prodis", "kode_prodi", "id_tahun", "tahun_tersedia"));
        }

        $prodi = $prodis->where('kode_prodi', $kode_prodi)->first();

        // Query tahun berdasarkan CPL
        $tahun_tersedia = DB::table('capaian_profil_lulusans as cpl')
            ->join('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->where('cpl.kode_prodi', $kode_prodi)
            ->select('tahun.id_tahun', 'tahun.nama_kurikulum', 'tahun.tahun')
            ->distinct()
            ->orderBy('tahun.tahun', 'desc')
            ->get();

        // Ambil semua CPL (struktur baru)
        $semuaCplQuery = DB::table('capaian_profil_lulusans as cpl')
            ->where('cpl.kode_prodi', $kode_prodi);

        if ($id_tahun) {
            $semuaCplQuery->where('cpl.id_tahun', $id_tahun);
        }

        $semuaCpl = $semuaCplQuery
            ->select('cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->orderBy('cpl.kode_cpl', 'asc')
            ->get();

        // Query CPL-CPMK-MK dengan semester
        $dataQuery = DB::table('capaian_profil_lulusans as cpl')
            ->join('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->join('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->leftJoin('cpl_cpmk as cpl_cpmk', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
            ->leftJoin('capaian_pembelajaran_mata_kuliahs as cpmk', 'cpl_cpmk.id_cpmk', '=', 'cpmk.id_cpmk')
            ->leftJoin('cpmk_mk', 'cpl_cpmk.id_cpmk', '=', 'cpmk_mk.id_cpmk')
            ->leftJoin('mata_kuliahs as mk', 'cpmk_mk.kode_mk', '=', 'mk.kode_mk')
            ->select(
                'cpl.kode_cpl',
                'cpl.deskripsi_cpl',
                'cpmk.kode_cpmk',
                'cpmk.deskripsi_cpmk',
                'mk.kode_mk',
                'mk.nama_mk',
                'mk.semester_mk',
                'tahun.tahun'
            )
            ->where('cpl.kode_prodi', $kode_prodi);

        if ($id_tahun) {
            $dataQuery->where('cpl.id_tahun', $id_tahun);
        }

        $data = $dataQuery->orderBy('cpl.kode_cpl')->get();

        $matrix = [];

        // Masukkan semua CPL ke matrix
        foreach ($semuaCpl as $cpl) {
            $matrix[$cpl->kode_cpl]['deskripsi'] = $cpl->deskripsi_cpl;
            $matrix[$cpl->kode_cpl]['cpmk'] = [];
        }

        // Tambahkan data CPMK dan MK
        foreach ($data as $row) {
            $kode_cpl = $row->kode_cpl;
            $kode_cpmk = $row->kode_cpmk;
            $semester = $row->semester_mk;

            if ($kode_cpmk) {
                $matrix[$kode_cpl]['cpmk'][$kode_cpmk]['deskripsi'] = $row->deskripsi_cpmk;

                if ($semester >= 1 && $semester <= 8) {
                    $matrix[$kode_cpl]['cpmk'][$kode_cpmk]['semester'][$semester][] = $row->nama_mk;
                }
            }
        }

        $dataKosong = empty($matrix) && $kode_prodi;

        return view('admin.pemetaancplcpmkmk.pemenuhancplcpmkmk', compact('matrix', 'prodis', 'kode_prodi', 'prodi', 'id_tahun', 'tahun_tersedia', 'dataKosong'));
    }

    public function pemetaanmkcpmkcpl(Request $request)
    {
        $prodis = DB::table('prodis')->get();
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');

        if (empty($kode_prodi)) {
            $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
            return view('admin.pemetaancplcpmkmk.pemetaanmkcplcpmk', [
                'kode_prodi' => '',
                'prodis' => $prodis,
                'prodi' => null,
                'matrix' => [],
                'semuaCpl' => collect(),
                'semuaMk' => collect(),
                'id_tahun' => $id_tahun,
                'tahun_tersedia' => $tahun_tersedia,
            ]);
        }

        $prodi = $prodis->where('kode_prodi', $kode_prodi)->first();

        $tahun_tersedia = DB::table('tahun')
            ->select('id_tahun', 'nama_kurikulum', 'tahun')
            ->orderBy('tahun', 'desc')
            ->get();

        // Get all CPL (struktur baru)
        $semuaCplQuery = DB::table('capaian_profil_lulusans as cpl')
            ->join('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->join('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->where('cpl.kode_prodi', $kode_prodi);

        if ($id_tahun) {
            $semuaCplQuery->where('cpl.id_tahun', $id_tahun);
        }

        $semuaCpl = $semuaCplQuery
            ->select('cpl.kode_cpl', 'cpl.deskripsi_cpl', 'prodis.nama_prodi', 'tahun.tahun')
            ->orderBy('cpl.kode_cpl', 'asc')
            ->get();

        // Get ALL mata kuliah melalui CPL
        $semuaMkQuery = DB::table('capaian_profil_lulusans as cpl')
            ->join('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->join('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->join('cpl_mk', 'cpl.id_cpl', '=', 'cpl_mk.id_cpl')
            ->join('mata_kuliahs as mk', 'cpl_mk.kode_mk', '=', 'mk.kode_mk')
            ->where('cpl.kode_prodi', $kode_prodi);

        if ($id_tahun) {
            $semuaMkQuery->where('cpl.id_tahun', $id_tahun);
        }

        $semuaMk = $semuaMkQuery
            ->select('mk.kode_mk', 'mk.nama_mk', 'mk.semester_mk', 'tahun.tahun')
            ->distinct()
            ->orderBy('mk.kode_mk')
            ->get();

        // Get relationships
        $relasiQuery = DB::table('cpl_cpmk')
            ->join('capaian_pembelajaran_mata_kuliahs as cpmk', 'cpl_cpmk.id_cpmk', '=', 'cpmk.id_cpmk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
            ->join('cpmk_mk', 'cpl_cpmk.id_cpmk', '=', 'cpmk_mk.id_cpmk')
            ->join('mata_kuliahs as mk', 'cpmk_mk.kode_mk', '=', 'mk.kode_mk')
            ->join('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->join('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->where('cpl.kode_prodi', $kode_prodi);

        if ($id_tahun) {
            $relasiQuery->where('cpl.id_tahun', $id_tahun);
        }

        $relasi = $relasiQuery
            ->select(
                'mk.kode_mk',
                'mk.nama_mk',
                'cpl.id_cpl',
                'cpl.kode_cpl',
                'cpmk.kode_cpmk',
                'prodis.nama_prodi',
                'cpmk.deskripsi_cpmk',
                'tahun.tahun'
            )
            ->get();

        // Initialize matrix
        $matrix = [];

        foreach ($semuaMk as $mk) {
            $matrix[$mk->kode_mk]['nama'] = $mk->nama_mk;

            foreach ($semuaCpl as $cpl) {
                $matrix[$mk->kode_mk]['cpl'][$cpl->kode_cpl] = [
                    'cpmks' => [],
                    'cpmk_details' => []
                ];
            }
        }

        // Populate matrix
        foreach ($relasi as $row) {
            if (isset($matrix[$row->kode_mk])) {
                if (!in_array($row->kode_cpmk, $matrix[$row->kode_mk]['cpl'][$row->kode_cpl]['cpmks'])) {
                    $matrix[$row->kode_mk]['cpl'][$row->kode_cpl]['cpmks'][] = $row->kode_cpmk;
                }

                $matrix[$row->kode_mk]['cpl'][$row->kode_cpl]['cpmk_details'][$row->kode_cpmk] = [
                    'nama_prodi' => $row->nama_prodi,
                    'deskripsi_cpmk' => $row->deskripsi_cpmk,
                ];
            }
        }

        $dataKosong = empty($matrix) && $kode_prodi;

        return view('admin.pemetaancplcpmkmk.pemetaanmkcplcpmk', compact(
            'matrix',
            'prodis',
            'kode_prodi',
            'semuaCpl',
            'semuaMk',
            'prodi',
            'id_tahun',
            'tahun_tersedia',
            'dataKosong'
        ));
    }
}
