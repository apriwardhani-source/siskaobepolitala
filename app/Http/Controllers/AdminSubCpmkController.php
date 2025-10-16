<?php

namespace App\Http\Controllers;

use App\Models\CapaianPembelajaranMataKuliah;
use Illuminate\Http\Request;
use App\Models\SubCpmk;
use Illuminate\Support\Facades\DB;
use App\Models\Tahun;

class AdminSubCpmkController extends Controller
{
    public function index(Request $request)
    {
        $prodis = DB::table('prodis')->get();
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');

        $tahun_tersedia = Tahun::orderBy('tahun', 'desc')->get();

        if (empty($kode_prodi)) {
            return view('admin.subcpmk.index', [
                'kode_prodi' => '',
                'prodis' => $prodis,
                'prodi' => null,
                'subcpmks' => [],
                'id_tahun' => $id_tahun,
                'tahun_tersedia' => $tahun_tersedia,
                'dataKosong' => true,
            ]);
        }

        $query = DB::table('sub_cpmks as sub')
            ->join('capaian_pembelajaran_mata_kuliahs as cpmk', 'sub.id_cpmk', '=', 'cpmk.id_cpmk')
            ->join('cpl_cpmk', 'cpmk.id_cpmk', '=', 'cpl_cpmk.id_cpmk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
            ->join('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->join('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->join('prodis', 'pl.kode_prodi', '=', 'prodis.kode_prodi')
            ->join('tahun', 'pl.id_tahun', '=', 'tahun.id_tahun')
            ->where('pl.kode_prodi', $kode_prodi)
            ->select(
                'sub.id_sub_cpmk',
                'kode_cpmk',
                'sub.sub_cpmk',
                'sub.uraian_cpmk',
                'cpmk.deskripsi_cpmk',
                'prodis.nama_prodi',
                'tahun.tahun'
            );

        if ($id_tahun) {
            $query->where('pl.id_tahun', $id_tahun);
        }

        $subcpmks = $query->get();
        $dataKosong = $subcpmks->isEmpty();

        return view('admin.subcpmk.index', compact(
            'subcpmks',
            'prodis',
            'kode_prodi',
            'id_tahun',
            'tahun_tersedia',
            'dataKosong'
        ));
    }


    public function create()
    {
        // Ambil semua mata kuliah
        $mataKuliahs = DB::table('mata_kuliahs')->orderBy('kode_mk')->get();
        return view('admin.subcpmk.create', compact('mataKuliahs'));
    }

    public function getCpmkByMataKuliah(Request $request)
    {
        $kode_mk = $request->kode_mk;

        // Ambil CPMK yang terkait dengan mata kuliah
        $cpmks = DB::table('capaian_pembelajaran_mata_kuliahs as cpmk')
            ->join('cpmk_mk', 'cpmk.id_cpmk', '=', 'cpmk_mk.id_cpmk')
            ->where('cpmk_mk.kode_mk', $kode_mk)
            ->select('cpmk.id_cpmk', 'cpmk.kode_cpmk', 'cpmk.deskripsi_cpmk')
            ->orderBy('cpmk.kode_cpmk')
            ->get();

        return response()->json($cpmks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cpmk' => 'required|array',
            'id_cpmk.*' => 'exists:capaian_pembelajaran_mata_kuliahs,id_cpmk',
            'sub_cpmk' => 'required|string|max:10',
            'uraian_cpmk' => 'required|string|max:255'
        ]);

        // Jika multiple CPMK dipilih, buat Sub CPMK untuk setiap CPMK
        foreach ($request->id_cpmk as $cpmk_id) {
            SubCpmk::create([
                'id_cpmk' => $cpmk_id,
                'sub_cpmk' => $request->sub_cpmk,
                'uraian_cpmk' => $request->uraian_cpmk
            ]);
        }

        return redirect()->route('admin.subcpmk.index')->with('success', 'Sub CPMK berhasil dibuat untuk ' . count($request->id_cpmk) . ' CPMK');
    }

    public function edit(SubCpmk $subcpmk)
    {
        // Ambil semua mata kuliah
        $mataKuliahs = DB::table('mata_kuliahs')->orderBy('kode_mk')->get();

        // Ambil mata kuliah yang terkait dengan CPMK dari sub CPMK ini
        $selectedMataKuliah = DB::table('cpmk_mk')
            ->join('mata_kuliahs as mk', 'cpmk_mk.kode_mk', '=', 'mk.kode_mk')
            ->where('cpmk_mk.id_cpmk', $subcpmk->id_cpmk)
            ->select('mk.kode_mk', 'mk.nama_mk')
            ->first();

        // Ambil semua CPMK yang terkait dengan mata kuliah tersebut
        $cpmks = collect();
        if ($selectedMataKuliah) {
            $cpmks = DB::table('capaian_pembelajaran_mata_kuliahs as cpmk')
                ->join('cpmk_mk', 'cpmk.id_cpmk', '=', 'cpmk_mk.id_cpmk')
                ->where('cpmk_mk.kode_mk', $selectedMataKuliah->kode_mk)
                ->select('cpmk.id_cpmk', 'cpmk.kode_cpmk', 'cpmk.deskripsi_cpmk')
                ->orderBy('cpmk.kode_cpmk')
                ->get();
        }

        return view('admin.subcpmk.edit', compact('mataKuliahs', 'subcpmk', 'selectedMataKuliah', 'cpmks'));
    }

    public function update(Request $request, SubCpmk $subcpmk)
    {
        $request->validate([
            'id_cpmk' => 'required|array',
            'id_cpmk.*' => 'exists:capaian_pembelajaran_mata_kuliahs,id_cpmk',
            'sub_cpmk' => 'required|string|max:10',
            'uraian_cpmk' => 'required|string|max:255'
        ]);

        // Hapus sub CPMK yang lama dengan sub_cpmk dan uraian_cpmk yang sama
        SubCpmk::where('sub_cpmk', $subcpmk->sub_cpmk)
            ->where('uraian_cpmk', $subcpmk->uraian_cpmk)
            ->delete();

        // Buat sub CPMK baru untuk setiap CPMK yang dipilih
        foreach ($request->id_cpmk as $cpmk_id) {
            SubCpmk::create([
                'id_cpmk' => $cpmk_id,
                'sub_cpmk' => $request->sub_cpmk,
                'uraian_cpmk' => $request->uraian_cpmk
            ]);
        }

        return redirect()->route('admin.subcpmk.index')->with('success', 'Sub CPMK berhasil diperbaharui untuk ' . count($request->id_cpmk) . ' CPMK');
    }

    public function destroy(SubCpmk $subcpmk)
    {
        $subcpmk->delete();
        return redirect()->route('admin.subcpmk.index')->with('success', 'Sub CPMK berhasil dihapus');
    }

    public function detail(SubCpmk $subcpmk)
    {
        return view('admin.subcpmk.detail', compact('subcpmk'));
    }

    public function pemetaanmkcpmksubcpmk(Request $request)
    {
        $prodis = DB::table('prodis')->get();
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');

        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        if (empty($kode_prodi)) {
            return view('admin.pemetaanmkcpmksubcpmk.index', [
                'kode_prodi' => '',
                'prodis' => $prodis,
                'prodi' => null,
                'query' => [],
                'id_tahun' => $id_tahun,
                'tahun_tersedia' => $tahun_tersedia,
                'dataKosong' => false
            ]);
        }

        $prodi = $prodis->where('kode_prodi', $kode_prodi)->first();

        $query = DB::table('sub_cpmks as sub')
            ->join('capaian_pembelajaran_mata_kuliahs as cpmk', 'sub.id_cpmk', '=', 'cpmk.id_cpmk')
            ->join('cpl_cpmk', 'cpmk.id_cpmk', '=', 'cpl_cpmk.id_cpmk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
            ->join('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->join('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->join('prodis', 'pl.kode_prodi', '=', 'prodis.kode_prodi')
            ->join('mata_kuliahs as mk', 'sub.kode_mk', '=', 'mk.kode_mk') // ambil langsung dari sub_cpmk
            ->where('prodis.kode_prodi', $kode_prodi)
            ->select(
                'mk.kode_mk',
                'mk.nama_mk',
                'cpmk.kode_cpmk',
                'cpmk.deskripsi_cpmk',
                'sub.id_sub_cpmk',
                'sub.sub_cpmk',
                'sub.uraian_cpmk'
            )
            ->orderBy('mk.kode_mk')
            ->orderBy('cpmk.kode_cpmk')
            ->distinct();

        if ($id_tahun) {
            $query->where('pl.id_tahun', $id_tahun);
        }

        $query = $query->get();

        $dataKosong = $query->isEmpty();

        return view('admin.pemetaanmkcpmksubcpmk.index', compact(
            'query',
            'prodis',
            'kode_prodi',
            'prodi',
            'id_tahun',
            'tahun_tersedia',
            'dataKosong'
        ));
    }
}
