<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CapaianProfilLulusan;
use App\Models\ProfilLulusan;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Imports\CplImport;
use Maatwebsite\Excel\Facades\Excel;

class AdminCapaianProfilLulusanController extends Controller
{
    public function index(Request $request)
    {
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');
        $prodis = DB::table('prodis')->get();

        if (!$kode_prodi) {
            $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
            return view("admin.capaianprofillulusan.index", compact("prodis", "kode_prodi", "id_tahun", "tahun_tersedia"));
        }

        // Query dengan struktur baru: CPL langsung punya kode_prodi dan id_tahun
        $query = DB::table('capaian_profil_lulusans as cpl')
            ->leftJoin('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->leftJoin('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl', 'cpl.status_cpl', 'prodis.nama_prodi', 'tahun.tahun')
            ->orderBy('cpl.kode_cpl', 'asc');

        if ($kode_prodi) {
            $query->where('cpl.kode_prodi', $kode_prodi);
        }

        if ($id_tahun) {
            $query->where('cpl.id_tahun', $id_tahun);
        }

        $capaianprofillulusans = $query->get();
        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
        $dataKosong = $capaianprofillulusans->isEmpty() && $kode_prodi;

        return view("admin.capaianprofillulusan.index", compact("capaianprofillulusans", "prodis", "kode_prodi", "id_tahun", "tahun_tersedia", "dataKosong"));
    }

    public function create()
    {
        abort(403);
    }

    public function store(Request $request)
    {
        abort(403);
    }


    public function edit($id_cpl)
    {
        abort(403);
    }

    public function update(Request $request, $id_cpl)
    {
        abort(403);
    }

    public function detail($id_cpl)
    {
        $capaianprofillulusan = DB::table('capaian_profil_lulusans as cpl')
            ->leftJoin('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->leftJoin('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->where('cpl.id_cpl', $id_cpl)
            ->select('cpl.*', 'prodis.nama_prodi', 'tahun.tahun')
            ->first();

        return view('admin.capaianprofillulusan.detail', compact('capaianprofillulusan'));
    }

    public function destroy(CapaianProfilLulusan $id_cpl)
    {
        abort(403);
    }

    public function import()
    {
        abort(403);
    }

    public function importStore(Request $request)
    {
        abort(403);
    }

    public function downloadTemplate()
    {
        abort(403);
    }

    public function peta_pemenuhan_cpl(Request $request)
    {
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');
        $prodis = DB::table('prodis')->get();
        if (!$kode_prodi) {
            $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
            return view("admin.pemenuhancpl.index", compact("prodis", "kode_prodi", "id_tahun", "tahun_tersedia"));
        }

        // Query struktur baru: CPL langsung punya kode_prodi dan id_tahun
        $query = DB::table('capaian_profil_lulusans as cpl')
            ->join('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->join('prodis as ps', 'cpl.kode_prodi', '=', 'ps.kode_prodi')
            ->leftJoin('cpl_mk as cmk', 'cpl.id_cpl', '=', 'cmk.id_cpl')
            ->leftJoin('mata_kuliahs as mk', 'cmk.kode_mk', '=', 'mk.kode_mk')
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'mk.semester_mk', 'mk.kode_mk', 'mk.nama_mk', 'ps.kode_prodi', 'tahun.tahun', 'ps.nama_prodi')
            ->distinct();

        if ($kode_prodi) {
            $query->where('cpl.kode_prodi', $kode_prodi);
        }

        if ($id_tahun) {
            $query->where('cpl.id_tahun', $id_tahun);
        }

        $data = $query
            ->orderBy('cpl.kode_cpl', 'asc')
            ->orderBy('mk.semester_mk', 'asc')
            ->get();

        $petaCPL = [];

        foreach ($data as $row) {
            $semester = 'Semester ' . $row->semester_mk;
            $namamk = $row->nama_mk;

            $petaCPL[$row->id_cpl]['label'] = $row->kode_cpl; // yang ditampilkan
            $petaCPL[$row->id_cpl]['semester'][$semester][] = $namamk; // pengelompokan tetap pakai id
        }

        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        $dataKosong = $data->isEmpty() && $kode_prodi;

        return view('admin.pemenuhancpl.index', compact('petaCPL', 'prodis', 'kode_prodi', 'id_tahun', 'tahun_tersedia', 'dataKosong'));
    }
}
