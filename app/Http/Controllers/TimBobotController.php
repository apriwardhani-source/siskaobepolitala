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
            ->join('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->where('cpl.kode_prodi', $kodeProdi)
            ->select(
                'bobots.id_bobot',
                'bobots.id_cpl',
                'bobots.kode_mk',
                'bobots.bobot',
                'cpl.kode_cpl',
                'cpl.deskripsi_cpl',
                'cpl.id_tahun',
                'prodis.nama_prodi'
            );

        if ($id_tahun) {
            $query->where('cpl.id_tahun', $id_tahun);
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

        $capaianProfilLulusans = DB::table('capaian_profil_lulusans as cpl')
            ->where('cpl.kode_prodi', $kodeProdi)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->distinct()
            ->get();

        return view('tim.bobot.create', compact('capaianProfilLulusans'));
    }

    public function getmkbycpl(Request $request)
    {
        // Support both single id_cpl and array id_cpls
        $id_cpls = $request->id_cpls ?? [$request->id_cpl];
        
        if (empty($id_cpls) || !is_array($id_cpls)) {
            return response()->json([]);
        }

        $id_cpl = $id_cpls[0]; // Get first CPL for bobot (bobot is per CPL)

        // Get MK yang terkait dengan CPL dan belum punya bobot
        $mks = DB::table('cpl_mk')
            ->join('mata_kuliahs as mk', 'cpl_mk.kode_mk', '=', 'mk.kode_mk')
            ->leftJoin('bobots', function($join) use ($id_cpl) {
                $join->on('mk.kode_mk', '=', 'bobots.kode_mk')
                     ->where('bobots.id_cpl', '=', $id_cpl);
            })
            ->where('cpl_mk.id_cpl', $id_cpl)
            ->whereNull('bobots.id_bobot') // Only MK that don't have bobot yet
            ->select('mk.kode_mk', 'mk.nama_mk')
            ->distinct()
            ->get();

        return response()->json($mks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cpl' => 'required',
            'bobot' => 'required|array',
            'bobot.*' => 'required|numeric|min:0|max:100',
        ]);

        // Validate total bobot must be 100
        $totalBobot = array_sum($request->bobot);
        if ($totalBobot != 100) {
            return back()->withErrors(['bobot' => "Total bobot harus 100%. Saat ini: {$totalBobot}%"])->withInput();
        }

        foreach ($request->bobot as $kode_mk => $bobotValue) {
            Bobot::create([
                'id_cpl' => $request->id_cpl,
                'kode_mk' => $kode_mk,
                'bobot' => $bobotValue,
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
        $id_cpl = $bobot->id_cpl;

        $mataKuliahs = DB::table('cpl_mk')
            ->join('mata_kuliahs as mk', 'cpl_mk.kode_mk', '=', 'mk.kode_mk')
            ->where('cpl_mk.id_cpl', $id_cpl)
            ->select('mk.kode_mk', 'mk.nama_mk')
            ->get();

        // Get existing bobots for this CPL
        $existingBobots = DB::table('bobots')
            ->where('id_cpl', $id_cpl)
            ->pluck('bobot', 'kode_mk')
            ->toArray();

        return view('tim.bobot.edit', compact('id_cpl', 'mataKuliahs', 'existingBobots'));
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
            ->join('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->where('mata_kuliahs.kode_prodi', $kodeProdi)
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
