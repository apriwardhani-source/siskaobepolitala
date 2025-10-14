<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Bobot;

class TimBobotController extends Controller
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

        return view('tim.bobot.index', compact('bobots', 'id_tahun', 'tahun_tersedia'));
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

        return view('tim.bobot.create', compact('cpls'));
    }

    public function getmkbycpl(Request $request)
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
            'id_cpl' => 'required',
            'bobots' => 'required|array',
            'bobots.*' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($request->bobots as $kode_mk => $bobot) {
            Bobot::create([
                'id_cpl' => $request->id_cpl,
                'kode_mk' => $kode_mk,
                'bobot' => $bobot,
            ]);
        }

        return redirect()->route('tim.bobot.index')->with('sukses', 'Bobot berhasil ditambahkan.');
    }

    public function edit(string $id_bobot)
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;
        $bobot = Bobot::findOrFail($id_bobot);

        $cpls = DB::table('capaian_profil_lulusans as cpl')
            ->join('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->join('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->where('pl.kode_prodi', $kodeProdi)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->distinct()
            ->get();

        $mks = DB::table('cpl_mk')
            ->join('mata_kuliahs as mk', 'cpl_mk.kode_mk', '=', 'mk.kode_mk')
            ->where('cpl_mk.id_cpl', $bobot->id_cpl)
            ->select('mk.kode_mk', 'mk.nama_mk')
            ->get();

        return view('tim.bobot.edit', compact('bobot', 'cpls', 'mks'));
    }

    public function update(Request $request, string $id_bobot)
    {
        $request->validate([
            'id_cpl' => 'required',
            'kode_mk' => 'required',
            'bobot' => 'required|numeric|min:0|max:100',
        ]);

        $bobot = Bobot::findOrFail($id_bobot);
        $bobot->update([
            'id_cpl' => $request->id_cpl,
            'kode_mk' => $request->kode_mk,
            'bobot' => $request->bobot,
        ]);

        return redirect()->route('tim.bobot.index')->with('sukses', 'Bobot berhasil diperbarui.');
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

        return view('tim.bobot.detail', [
            'id_cpl' => $id_cpl,
            'mataKuliahs' => $mk_terkait,
            'existingBobots' => $existingBobots
        ]);
    }

    public function destroy(string $id_bobot)
    {
        $bobot = Bobot::findOrFail($id_bobot);
        $bobot->delete();

        return redirect()->route('tim.bobot.index')->with('sukses', 'Bobot berhasil dihapus.');
    }
}
