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
    public function index(Request $request)
    {
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');

        // Data dropdown
        $prodis = DB::table('prodis')->get();
        $tahun_tersedia = DB::table('tahun')->orderByDesc('tahun')->get();

        // Jika belum pilih prodi, hanya tampilkan filter (seperti di Wadir1)
        if (!$kode_prodi) {
            return view('admin.bobot.index', [
                'bobots' => collect(),
                'kode_prodi' => '',
                'id_tahun' => $id_tahun,
                'prodis' => $prodis,
                'tahun_tersedia' => $tahun_tersedia,
            ]);
        }

        // Query mengikuti logika Wadir1: filter berdasarkan CPL (skema baru)
        $bobots = Bobot::with(['capaianProfilLulusan', 'mataKuliah'])
            ->whereHas('capaianProfilLulusan', function ($q) use ($kode_prodi, $id_tahun) {
                $q->where('kode_prodi', $kode_prodi);
                if ($id_tahun) {
                    $q->where('id_tahun', $id_tahun);
                }
            })
            ->orderBy('id_cpl')
            ->get();

        return view('admin.bobot.index', compact(
            'bobots',
            'kode_prodi',
            'id_tahun',
            'prodis',
            'tahun_tersedia'
        ));
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
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(403);
    }

    /**
     * Display the specified resource.
     * Detail per MK: tampilkan CPL yang dipetakan ke MK tersebut beserta bobotnya.
     */
    public function detail(string $kode_mk)
    {
        // Ambil data mata kuliah
        $mk = DB::table('mata_kuliahs')
            ->where('kode_mk', $kode_mk)
            ->first();

        if (!$mk) {
            abort(404);
        }

        // Ambil CPL yang dipetakan ke MK ini beserta bobotnya (jika ada)
        $cpls = DB::table('cpl_mk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->leftJoin('bobots', function ($join) use ($kode_mk) {
                $join->on('bobots.id_cpl', '=', 'cpl_mk.id_cpl')
                     ->on('bobots.kode_mk', '=', 'cpl_mk.kode_mk');
            })
            ->where('cpl_mk.kode_mk', $kode_mk)
            ->select(
                'cpl.id_cpl',
                'cpl.kode_cpl',
                'cpl.deskripsi_cpl',
                'bobots.bobot'
            )
            ->orderBy('cpl.kode_cpl')
            ->get();

        $totalBobot = $cpls->sum(function ($row) {
            return (int)($row->bobot ?? 0);
        });

        return view('admin.bobot.detail', [
            'mk'         => $mk,
            'cpls'       => $cpls,
            'totalBobot' => $totalBobot,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * Edit per MK: tampilkan CPL yang dipetakan ke MK tersebut.
     */
    public function edit(string $kode_mk)
    {
        // Ambil mata kuliah (read-only)
        $mk = DB::table('mata_kuliahs')
            ->where('kode_mk', $kode_mk)
            ->first();

        if (!$mk) {
            abort(404);
        }

        // Ambil CPL yang dipetakan ke MK ini
        $cpls = DB::table('cpl_mk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->where('cpl_mk.kode_mk', $kode_mk)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->orderBy('cpl.kode_cpl')
            ->get();

        // Bobot existing untuk MK ini
        $existingBobots = DB::table('bobots')
            ->where('kode_mk', $kode_mk)
            ->pluck('bobot', 'id_cpl')
            ->toArray();

        $totalBobot = array_sum($existingBobots);

        return view('admin.bobot.edit', [
            'mk'            => $mk,
            'cpls'          => $cpls,
            'existingBobots'=> $existingBobots,
            'totalBobot'    => $totalBobot,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * Update bobot per MK untuk semua CPL yang terpilih.
     */
    public function update(Request $request, string $kode_mk)
    {
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_cpl)
    {
        abort(403);
    }
}
