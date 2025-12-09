<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\CapaianProfilLulusan;
use App\Models\BahanKajian;

class AdminMataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');
        $prodis = DB::table('prodis')->get();

        if (!$kode_prodi) {
            $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
            return view("admin.matakuliah.index", compact("prodis", "kode_prodi", "id_tahun", "tahun_tersedia"));
        }

        $query = DB::table('mata_kuliahs as mk')
            ->select(
                'mk.kode_mk',
                'mk.nama_mk',
                'mk.jenis_mk',
                'mk.sks_mk',
                'mk.semester_mk',
                'mk.kompetensi_mk',
                'prodis.nama_prodi',
                'tahun.tahun'
            )
            ->leftJoin('cpl_mk', 'mk.kode_mk', '=', 'cpl_mk.kode_mk')
            ->leftJoin('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->leftJoin('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->leftJoin('prodis', 'mk.kode_prodi', '=', 'prodis.kode_prodi')
            ->groupBy('mk.kode_mk', 'mk.nama_mk', 'mk.jenis_mk', 'mk.sks_mk', 'mk.semester_mk', 'mk.kompetensi_mk', 'prodis.nama_prodi', 'tahun.tahun');

        if ($kode_prodi) {
            $query->where('mk.kode_prodi', $kode_prodi);
        }

        if ($id_tahun) {
            $query->where('cpl.id_tahun', $id_tahun);
        }

        $mata_kuliahs = $query->get();

        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        $dataKosong = $mata_kuliahs->isEmpty() && $kode_prodi;

        return view("admin.matakuliah.index", compact("mata_kuliahs", 'kode_prodi', 'prodis', 'id_tahun', 'tahun_tersedia', 'dataKosong'));
    }

    // Method ini sudah tidak dipakai karena BK (Bahan Kajian) sudah dihapus
    // CPL sekarang dipilih langsung saat create/edit Mata Kuliah

    public function create()
    {
        abort(403);
    }

    public function store(Request $request)
    {
        abort(403);
    }

    public function edit(MataKuliah $matakuliah)
    {
        abort(403);
    }

    public function update(Request $request, MataKuliah $matakuliah)
    {
        abort(403);
    }

    public function detail(MataKuliah $matakuliah)
    {
        $selectedCplIds = DB::table('cpl_mk')
            ->where('kode_mk', $matakuliah->kode_mk)
            ->pluck('id_cpl')
            ->toArray();

        $capaianprofillulusans = CapaianProfilLulusan::whereIn('id_cpl', $selectedCplIds)->get();

        return view('admin.matakuliah.detail', [
            'matakuliah' => $matakuliah, 
            'selectedCplIds' => $selectedCplIds, 
            'capaianprofillulusans' => $capaianprofillulusans
        ]);
    }

    public function destroy(MataKuliah $matakuliah)
    {
        abort(403);
    }

    public function organisasi_mk(Request $request)
    {
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');
        $prodis = DB::table('prodis')->get();

        if (!$kode_prodi) {
            $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
            return view("admin.matakuliah.organisasimk", compact("prodis", "kode_prodi", "id_tahun", "tahun_tersedia"));
        }

        $query = DB::table('mata_kuliahs as mk')
            ->select(
                'mk.kode_mk',
                'mk.nama_mk',
                'mk.jenis_mk',
                'mk.sks_mk',
                'mk.semester_mk',
                'mk.kompetensi_mk',
                'prodis.nama_prodi',
                'prodis.kode_prodi',
                'tahun.tahun',
            )
            ->leftJoin('cpl_mk', 'mk.kode_mk', '=', 'cpl_mk.kode_mk')
            ->leftJoin('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->leftJoin('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->leftJoin('prodis', 'mk.kode_prodi', '=', 'prodis.kode_prodi')
            ->groupBy(
                'mk.kode_mk',
                'mk.nama_mk',
                'mk.sks_mk',
                'mk.semester_mk',
                'mk.kompetensi_mk',
                'prodis.nama_prodi',
                'prodis.kode_prodi',
                'tahun.tahun'
            );

        if ($kode_prodi) {
            $query->where('mk.kode_prodi', $kode_prodi);
        }

        if ($id_tahun) {
            $query->where('cpl.id_tahun', $id_tahun);
        }

        $matakuliah = $query->get();

        $organisasiMK = $matakuliah->groupBy('semester_mk')->map(function ($items, $semester_mk) {
            return [
                'semester_mk' => $semester_mk,
                'sks_mk' => $items->sum('sks_mk'),
                'jumlah_mk' => $items->count(),
                'nama_mk' => $items->pluck('nama_mk')->toArray(),
                'mata_kuliah' => $items,
            ];
        });

        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        $dataKosong = $matakuliah->isEmpty() && $kode_prodi;

        return view('admin.matakuliah.organisasimk', compact('organisasiMK', 'prodis', 'kode_prodi', 'id_tahun', 'tahun_tersedia', 'dataKosong'));
    }
}
