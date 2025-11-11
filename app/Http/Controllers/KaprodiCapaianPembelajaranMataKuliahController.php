<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CapaianPembelajaranMataKuliah;

class KaprodiCapaianPembelajaranMataKuliahController extends Controller
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
            // Schema baru: CPL sudah menyimpan kode_prodi dan id_tahun
            ->leftJoin('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->where('cpl.kode_prodi', $kodeProdi)
            ->select('cpmk.id_cpmk', 'cpmk.kode_cpmk', 'cpmk.deskripsi_cpmk', 'prodis.nama_prodi')
            ->groupBy('cpmk.id_cpmk', 'cpmk.kode_cpmk', 'cpmk.deskripsi_cpmk', 'prodis.nama_prodi')
            ->orderBy('cpmk.kode_cpmk', 'asc');

        // Tambahkan filter tahun jika ada
        if ($id_tahun) {
            // Filter berdasarkan tahun dari CPL (bukan lagi dari PL)
            $query->where('cpl.id_tahun', $id_tahun);
        }

        $capaianpembelajaranmatakuliahs = $query->get();

        return view("kaprodi.capaianpembelajaranmatakuliah.index", compact("capaianpembelajaranmatakuliahs", "id_tahun", "tahun_tersedia"));
    }

    public function detail($id_cpmk)
    {
        $kodeProdi = Auth::user()->kode_prodi;

        $akses = DB::table('cpl_cpmk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
            // Validasi akses langsung via kode_prodi di CPL sesuai schema baru
            ->where('cpl_cpmk.id_cpmk', $id_cpmk)
            ->where('cpl.kode_prodi', $kodeProdi)
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

        return view('kaprodi.capaianpembelajaranmatakuliah.detail', compact('cpmk', 'cpls', 'mks'));
    }
}
