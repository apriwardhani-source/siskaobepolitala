<?php

namespace App\Http\Controllers;

use App\Models\CapaianProfilLulusan;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use App\Models\Bobot;
use Illuminate\Support\Facades\DB;

class AdminBobotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bobots = DB::table('bobots')
            ->join('capaian_profil_lulusans as cpl', 'bobots.id_cpl', '=', 'cpl.id_cpl')
            ->join('mata_kuliahs as mk', 'bobots.kode_mk', '=', 'mk.kode_mk')
            ->select(
                'bobots.id_bobot',
                'bobots.id_cpl',
                'bobots.kode_mk',
                'bobots.bobot',
                'cpl.kode_cpl',
                'cpl.deskripsi_cpl',
                'mk.nama_mk'
            )
            ->orderBy('bobots.kode_mk')
            ->orderBy('bobots.id_cpl')
            ->get();

        return view('admin.bobot.index', compact('bobots'));
    }

    public function getcplbymk(Request $request)
    {
        $kode_mk = $request->kode_mk ?? null;

        if (!$kode_mk) return response()->json([]);

        // Ambil id CPL yang sudah diberi bobot untuk MK ini
        $existingCPL = DB::table('bobots')
            ->where('kode_mk', $kode_mk)
            ->pluck('id_cpl');

        // Ambil CPL dari relasi MK yang belum diberi bobot
        $cpls = DB::table('cpl_mk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->where('cpl_mk.kode_mk', $kode_mk)
            ->whereNotIn('cpl_mk.id_cpl', $existingCPL)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->distinct()
            ->orderBy('cpl.kode_cpl')
            ->get();

        return response()->json($cpls);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $capaianProfilLulusans = CapaianProfilLulusan::all();
        $mataKuliahs = MataKuliah::all();

        return view('admin.bobot.create', compact('capaianProfilLulusans', 'mataKuliahs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_mk' => 'required|exists:mata_kuliahs,kode_mk',
            'id_cpl' => 'required|array|min:1',
            'id_cpl.*' => 'exists:capaian_profil_lulusans,id_cpl',
            'bobot' => 'required|array',
            'bobot.*' => 'integer|min:0|max:100',
        ]);

        // Validasi total bobot harus 100
        $totalBobot = array_sum($request->bobot);
        if ($totalBobot != 100) {
            return redirect()->back()->withErrors(['msg' => 'Total bobot harus 100%.'])->withInput();
        }

        foreach ($request->id_cpl as $id_cpl) {
            // Cek apakah bobot untuk kode_mk dan id_cpl ini sudah ada
            $existing = Bobot::where('kode_mk', $request->kode_mk)
                ->where('id_cpl', $id_cpl)
                ->exists();

            if ($existing) {
                return redirect()->back()->withErrors(['msg' => 'Bobot untuk MK dan CPL tersebut sudah ada.'])->withInput();
            }

            Bobot::create([
                'kode_mk' => $request->kode_mk,
                'id_cpl' => $id_cpl,
                'bobot' => $request->bobot[$id_cpl] ?? 0,
            ]);
        }

        return redirect()->route('admin.bobot.index')->with('success', 'Bobot berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id_cpl)
    {
        $mk_terkait = DB::table('cpl_mk')
            ->join('mata_kuliahs', 'cpl_mk.kode_mk', '=', 'mata_kuliahs.kode_mk')
            ->join('capaian_profil_lulusans', 'cpl_mk.id_cpl', '=', 'capaian_profil_lulusans.id_cpl')
            ->where('cpl_mk.id_cpl', $id_cpl)
            ->select('mata_kuliahs.kode_mk', 'mata_kuliahs.nama_mk', 'capaian_profil_lulusans.kode_cpl', 'capaian_profil_lulusans.deskripsi_cpl')
            ->get();

        $bobots = Bobot::where('id_cpl', $id_cpl)->get();
        $existingBobots = $bobots->pluck('bobot', 'kode_mk')->toArray();
        $kode_cpl = $mk_terkait->first()->kode_cpl ?? '-';
        $deskripsi_cpl = $mk_terkait->first()->deskripsi_cpl ?? '-';

        return view('admin.bobot.detail', [
            'id_cpl' => $id_cpl,
            'kode_cpl' => $kode_cpl,
            'deskripsi_cpl' => $deskripsi_cpl,
            'mataKuliahs' => $mk_terkait,
            'existingBobots' => $existingBobots
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_cpl)
    {
        $mk_terkait = DB::table('cpl_mk')
            ->join('mata_kuliahs', 'cpl_mk.kode_mk', '=', 'mata_kuliahs.kode_mk')
            ->where('cpl_mk.id_cpl', $id_cpl)
            ->select('mata_kuliahs.kode_mk', 'mata_kuliahs.nama_mk')
            ->get();

        $bobots = Bobot::where('id_cpl', $id_cpl)->get();
        $existingBobots = $bobots->pluck('bobot', 'kode_mk')->toArray();

        return view('admin.bobot.edit', [
            'id_cpl' => $id_cpl,
            'mataKuliahs' => $mk_terkait,
            'existingBobots' => $existingBobots
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_cpl)
    {
        $request->validate([
            'kode_mk' => 'required|array',
            'kode_mk.*' => 'exists:mata_kuliahs,kode_mk',
            'bobot' => 'required|array',
            'bobot.*' => 'integer|min:0|max:100',
        ]);

        foreach ($request->kode_mk as $kode_mk) {
            DB::table('bobots')->updateOrInsert(
                ['id_cpl' => $id_cpl, 'kode_mk' => $kode_mk],
                ['bobot' => $request->bobot[$kode_mk] ?? 0]
            );
        }

        return redirect()->route('admin.bobot.index')->with('success', 'Bobot berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_cpl)
    {
        Bobot::where('id_cpl', $id_cpl)->delete();

        return redirect()->route('admin.bobot.index')->with('success', 'Semua bobot untuk CPL ini berhasil dihapus.');
    }
}
