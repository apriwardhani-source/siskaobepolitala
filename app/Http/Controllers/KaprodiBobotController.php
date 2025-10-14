<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Bobot;

class KaprodiBobotController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->kode_prodi) {
            abort(404);
        }

        $kodeProdi = $user->kode_prodi;
        $id_tahun = $request->get('id_tahun');

        $tahun_tersedia = DB::table('tahun')->orderBy('tahun', 'desc')->get();

        $query = DB::table('bobots')
            ->join('capaian_profil_lulusans as cpl', 'bobots.id_cpl', '=', 'cpl.id_cpl')
            ->join('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->join('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->join('prodis', 'pl.kode_prodi', '=', 'prodis.kode_prodi')
            ->where('prodis.kode_prodi', $kodeProdi)
            ->select(
                'bobots.id_bobot',
                'bobots.id_cpl',
                'bobots.kode_mk',
                'bobots.bobot',
                'cpl.kode_cpl',
                'cpl.deskripsi_cpl',
                'pl.id_tahun',
                'prodis.nama_prodi'
            );

        if ($id_tahun) {
            $query->where('pl.id_tahun', $id_tahun);
        }

        $bobots = $query->orderBy('bobots.id_cpl')->get();

        return view('kaprodi.bobot.index', compact('bobots', 'id_tahun', 'tahun_tersedia'));
    }

    public function detail(string $id_cpl)
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) abort(404);

        $kodeProdi = $user->kode_prodi;

        $mk_terkait = DB::table('cpl_mk')
            ->join('mata_kuliahs', 'cpl_mk.kode_mk', '=', 'mata_kuliahs.kode_mk')
            ->join('cpl_pl', 'cpl_mk.id_cpl', '=', 'cpl_pl.id_cpl')
            ->join('profil_lulusans', 'cpl_pl.id_pl', '=', 'profil_lulusans.id_pl')
            ->join('prodis', 'profil_lulusans.kode_prodi', '=', 'prodis.kode_prodi')
            ->where('prodis.kode_prodi', $kodeProdi)
            ->where('cpl_mk.id_cpl', $id_cpl)
            ->select('mata_kuliahs.kode_mk', 'mata_kuliahs.nama_mk')
            ->get();

        $bobots = Bobot::where('id_cpl', $id_cpl)->get();
        $existingBobots = $bobots->pluck('bobot', 'kode_mk')->toArray();

        return view('kaprodi.bobot.detail', [
            'id_cpl' => $id_cpl,
            'mataKuliahs' => $mk_terkait,
            'existingBobots' => $existingBobots
        ]);
    }
}
