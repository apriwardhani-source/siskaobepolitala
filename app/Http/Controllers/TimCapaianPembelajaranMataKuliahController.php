<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CapaianPembelajaranMataKuliah;
use App\Models\MataKuliah;
use App\Models\CapaianProfilLulusan;

class TimCapaianPembelajaranMataKuliahController extends Controller
{
    public function index()
{
    $user = Auth::user();

    if (!$user || !$user->kode_prodi) {
        abort(403);
    }

    $kodeProdi = $user->kode_prodi;
    $id_tahun = request()->get('id_tahun');
    $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

    $query = DB::table('capaian_pembelajaran_mata_kuliahs as cpmk')
        ->leftJoin('cpl_cpmk', 'cpmk.id_cpmk', '=', 'cpl_cpmk.id_cpmk')
        ->leftJoin('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
        ->leftJoin('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
        ->leftJoin('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
        ->leftJoin('prodis', 'pl.kode_prodi', '=', 'prodis.kode_prodi')
        ->where('prodis.kode_prodi', $kodeProdi)
        ->select('cpmk.id_cpmk', 'cpmk.kode_cpmk', 'cpmk.deskripsi_cpmk', 'prodis.nama_prodi')
        ->groupBy('cpmk.id_cpmk', 'cpmk.kode_cpmk', 'cpmk.deskripsi_cpmk', 'prodis.nama_prodi')
        ->orderBy('cpmk.kode_cpmk', 'asc');

    if ($id_tahun) {
        $query->where('pl.id_tahun', $id_tahun);
    }

    // ✅ ubah variabel jadi cpmks
    $cpmks = $query->get();

    return view("tim.capaianpembelajaranmatakuliah.index", compact("cpmks", "id_tahun", "tahun_tersedia"));
}


    public function create()
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;

        $cpls = DB::table('capaian_profil_lulusans as cpl')
            ->join('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->join('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->where('pl.kode_prodi', $kodeProdi)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->distinct()
            ->get();

        $mks = DB::table('mata_kuliahs as mk')
            ->join('cpl_mk', 'mk.kode_mk', '=', 'cpl_mk.kode_mk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->join('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->join('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->where('pl.kode_prodi', $kodeProdi)
            ->select('mk.kode_mk', 'mk.nama_mk')
            ->distinct()
            ->get();

        return view('tim.capaianpembelajaranmatakuliah.create', compact('cpls', 'mks'));
    }

    public function getMKByCPL(Request $request)
    {
        $id_cpl = $request->id_cpl;

        $mks = DB::table('cpl_mk')
            ->join('mata_kuliahs as mk', 'cpl_mk.kode_mk', '=', 'mk.kode_mk')
            ->where('cpl_mk.id_cpl', $id_cpl)
            ->select('mk.kode_mk', 'mk.nama_mk')
            ->get();

        return response()->json($mks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_cpmk' => 'required|string',
            'deskripsi_cpmk' => 'required|string',
            'id_cpl' => 'required|array',
            'kode_mk' => 'required|array',
        ]);

        $cpmk = CapaianPembelajaranMataKuliah::create([
            'kode_cpmk' => $request->kode_cpmk,
            'deskripsi_cpmk' => $request->deskripsi_cpmk,
        ]);

        foreach ($request->id_cpl as $id_cpl) {
            DB::table('cpl_cpmk')->insert([
                'id_cpmk' => $cpmk->id_cpmk,
                'id_cpl' => $id_cpl,
            ]);
        }

        foreach ($request->kode_mk as $kode_mk) {
            DB::table('cpmk_mk')->insert([
                'id_cpmk' => $cpmk->id_cpmk,
                'kode_mk' => $kode_mk,
            ]);
        }

        return redirect()->route('tim.capaianpembelajaranmatakuliah.index')->with('sukses', 'CPMK berhasil ditambahkan.');
    }

    public function edit($id_cpmk)
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;
        $cpmk = CapaianPembelajaranMataKuliah::findOrFail($id_cpmk);

        $cpls = DB::table('capaian_profil_lulusans as cpl')
            ->join('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->join('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->where('pl.kode_prodi', $kodeProdi)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->distinct()
            ->get();

        $mks = DB::table('mata_kuliahs as mk')
            ->join('cpl_mk', 'mk.kode_mk', '=', 'cpl_mk.kode_mk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->join('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->join('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->where('pl.kode_prodi', $kodeProdi)
            ->select('mk.kode_mk', 'mk.nama_mk')
            ->distinct()
            ->get();

        $selectedCPLs = DB::table('cpl_cpmk')->where('id_cpmk', $id_cpmk)->pluck('id_cpl')->toArray();
        $selectedMKs = DB::table('cpmk_mk')->where('id_cpmk', $id_cpmk)->pluck('kode_mk')->toArray();

        return view('tim.capaianpembelajaranmatakuliah.edit', compact('cpmk', 'cpls', 'mks', 'selectedCPLs', 'selectedMKs'));
    }

    public function update(Request $request, $id_cpmk)
    {
        $request->validate([
            'kode_cpmk' => 'required|string',
            'deskripsi_cpmk' => 'required|string',
            'id_cpl' => 'required|array',
            'kode_mk' => 'required|array',
        ]);

        $cpmk = CapaianPembelajaranMataKuliah::findOrFail($id_cpmk);
        $cpmk->update([
            'kode_cpmk' => $request->kode_cpmk,
            'deskripsi_cpmk' => $request->deskripsi_cpmk,
        ]);

        DB::table('cpl_cpmk')->where('id_cpmk', $id_cpmk)->delete();
        foreach ($request->id_cpl as $id_cpl) {
            DB::table('cpl_cpmk')->insert([
                'id_cpmk' => $id_cpmk,
                'id_cpl' => $id_cpl,
            ]);
        }

        DB::table('cpmk_mk')->where('id_cpmk', $id_cpmk)->delete();
        foreach ($request->kode_mk as $kode_mk) {
            DB::table('cpmk_mk')->insert([
                'id_cpmk' => $id_cpmk,
                'kode_mk' => $kode_mk,
            ]);
        }

        return redirect()->route('tim.capaianpembelajaranmatakuliah.index')->with('sukses', 'CPMK berhasil diperbarui.');
    }

    public function detail($id_cpmk)
    {
        $kodeProdi = Auth::user()->kode_prodi;

        $akses = DB::table('cpl_cpmk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
            ->join('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->join('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->join('prodis', 'pl.kode_prodi', '=', 'prodis.kode_prodi')
            ->where('cpl_cpmk.id_cpmk', $id_cpmk)
            ->where('prodis.kode_prodi', $kodeProdi)
            ->exists();

        if (!$akses) {
            abort(403, 'Akses ditolak');
        }

        $cpmk = CapaianPembelajaranMataKuliah::findOrFail($id_cpmk);

        $cpls = DB::table('cpl_cpmk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
            ->where('cpl_cpmk.id_cpmk', $id_cpmk)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->get();

        $mks = DB::table('cpmk_mk')
            ->join('mata_kuliahs as mk', 'cpmk_mk.kode_mk', '=', 'mk.kode_mk')
            ->where('cpmk_mk.id_cpmk', $id_cpmk)
            ->select('mk.kode_mk', 'mk.nama_mk')
            ->get();

        return view('tim.capaianpembelajaranmatakuliah.detail', compact('cpmk', 'cpls', 'mks'));
    }

    public function destroy($id_cpmk)
    {
        $cpmk = CapaianPembelajaranMataKuliah::findOrFail($id_cpmk);
        $cpmk->delete();

        return redirect()->route('tim.capaianpembelajaranmatakuliah.index')->with('sukses', 'CPMK berhasil dihapus.');
    }
}
