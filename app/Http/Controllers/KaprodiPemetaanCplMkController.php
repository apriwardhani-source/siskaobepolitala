<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CapaianProfilLulusan;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KaprodiPemetaanCplMkController extends Controller
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

        $prodi = DB::table('prodis')->where('kode_prodi', $kodeProdi)->first();

        // Query CPL seperti TIM: berdasarkan kode_prodi & id_tahun di tabel CPL langsung
        $query = CapaianProfilLulusan::where('kode_prodi', $kodeProdi);

        if ($id_tahun) {
            $query->where('id_tahun', $id_tahun);
        }

        $cpls = $query->orderBy('kode_cpl', 'asc')->get();

        // Prodi per CPL (untuk info saja)
        $query = DB::table('cpl_mk')
            ->join('capaian_profil_lulusans', 'cpl_mk.id_cpl', '=', 'capaian_profil_lulusans.id_cpl')
            ->join('prodis', 'capaian_profil_lulusans.kode_prodi', '=', 'prodis.kode_prodi')
            ->where('capaian_profil_lulusans.kode_prodi', $kodeProdi)
            ->select('cpl_mk.id_cpl', 'prodis.nama_prodi');

        if ($id_tahun) {
            $query->where('capaian_profil_lulusans.id_tahun', $id_tahun);
        }

        $prodiByCpl = $query->get()
            ->groupBy('id_cpl')
            ->map(function ($items) {
                return $items->first()->nama_prodi ?? '-';
            });

        // MK yang punya relasi CPL di prodi & tahun ini
        $query = MataKuliah::whereIn('kode_mk', function ($query) use ($kodeProdi, $id_tahun) {
            $query->select('kode_mk')
                ->from('cpl_mk')
                ->join('capaian_profil_lulusans', 'cpl_mk.id_cpl', '=', 'capaian_profil_lulusans.id_cpl')
                ->where('capaian_profil_lulusans.kode_prodi', $kodeProdi);

            if ($id_tahun) {
                $query->where('capaian_profil_lulusans.id_tahun', $id_tahun);
            }
        });
        $mks = $query->orderBy('kode_mk', 'asc')->get();

        // Relasi CPL-MK, juga tanpa tabel cpl_pl
        $query = DB::table('cpl_mk')
            ->join('capaian_profil_lulusans', 'cpl_mk.id_cpl', '=', 'capaian_profil_lulusans.id_cpl')
            ->where('capaian_profil_lulusans.kode_prodi', $kodeProdi)
            ->select('cpl_mk.*');

        if ($id_tahun) {
            $query->where('capaian_profil_lulusans.id_tahun', $id_tahun);
        }

        $relasi = $query->get()->groupBy('kode_mk');

        return view('kaprodi.pemetaancplmk.index', compact('cpls', 'mks', 'relasi', 'prodi', 'prodiByCpl', 'id_tahun', 'tahun_tersedia'));
    }
}
