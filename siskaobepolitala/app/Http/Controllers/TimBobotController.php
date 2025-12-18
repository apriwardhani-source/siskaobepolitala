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

        $prodi = DB::table('prodis')->where('kode_prodi', $kodeProdi)->first();

        $query = DB::table('bobots')
            ->join('capaian_profil_lulusans as cpl', 'bobots.id_cpl', '=', 'cpl.id_cpl')
            ->join('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->join('mata_kuliahs as mk', 'bobots.kode_mk', '=', 'mk.kode_mk')
            ->where('cpl.kode_prodi', $kodeProdi)
            ->select(
                'bobots.id_bobot',
                'bobots.id_cpl',
                'bobots.kode_mk',
                'bobots.bobot',
                'cpl.kode_cpl',
                'cpl.deskripsi_cpl',
                'cpl.id_tahun',
                'prodis.nama_prodi',
                'mk.nama_mk'
            );

        if ($id_tahun) {
            $query->where('cpl.id_tahun', $id_tahun);
        }

        $bobots = $query->orderBy('bobots.kode_mk')->orderBy('bobots.id_cpl')->get();

        return view('tim.bobot.index', compact('bobots', 'id_tahun', 'tahun_tersedia', 'prodi'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;

        $mataKuliahs = DB::table('mata_kuliahs as mk')
            ->where('mk.kode_prodi', $kodeProdi)
            ->select('mk.kode_mk', 'mk.nama_mk')
            ->distinct()
            ->get();

        return view('tim.bobot.create', compact('mataKuliahs'));
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

        return redirect()->route('tim.bobot.index')->with('sukses', 'Bobot berhasil ditambahkan.');
    }

    public function edit(string $kode_mk)
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;

        // Pastikan MK milik prodi ini
        $mk = DB::table('mata_kuliahs')
            ->where('kode_mk', $kode_mk)
            ->where('kode_prodi', $kodeProdi)
            ->first();

        if (!$mk) {
            abort(404);
        }

        // Ambil CPL yang dipetakan ke MK ini
        $cpls = DB::table('cpl_mk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->where('cpl_mk.kode_mk', $kode_mk)
            ->where('cpl.kode_prodi', $kodeProdi)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->orderBy('cpl.kode_cpl')
            ->get();

        // Bobot existing untuk MK ini
        $existingBobots = DB::table('bobots')
            ->where('kode_mk', $kode_mk)
            ->pluck('bobot', 'id_cpl')
            ->toArray();

        $totalBobot = array_sum($existingBobots);

        return view('tim.bobot.edit', [
            'mk'            => $mk,
            'cpls'          => $cpls,
            'existingBobots'=> $existingBobots,
            'totalBobot'    => $totalBobot,
        ]);
    }

    public function update(Request $request, string $kode_mk)
    {
        // Edit dilakukan per MK: kirim array id_cpl[] dan bobot[id_cpl]
        $request->validate([
            'kode_mk'   => 'required|exists:mata_kuliahs,kode_mk',
            'id_cpl'    => 'required|array|min:1',
            'id_cpl.*'  => 'exists:capaian_profil_lulusans,id_cpl',
            'bobot'     => 'required|array',
            'bobot.*'   => 'numeric|min:0|max:100',
        ]);

        $totalBobot = array_sum($request->bobot ?? []);
        if ($totalBobot != 100) {
            return redirect()
                ->back()
                ->withErrors(['msg' => 'Total bobot harus 100%.'])
                ->withInput();
        }

        $kode_mk = $request->kode_mk;

        foreach ($request->id_cpl as $id_cpl) {
            $nilaiBobot = $request->bobot[$id_cpl] ?? 0;

            Bobot::updateOrCreate(
                ['kode_mk' => $kode_mk, 'id_cpl' => $id_cpl],
                ['bobot'   => $nilaiBobot]
            );
        }

        return redirect()->route('tim.bobot.index')->with('sukses', 'Bobot berhasil diperbarui.');
    }

    public function detail(string $kode_mk)
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(404);
        }

        $kodeProdi = $user->kode_prodi;

        // Ambil data mata kuliah yang dimaksud dan pastikan milik prodi ini
        $mk = DB::table('mata_kuliahs')
            ->where('kode_mk', $kode_mk)
            ->where('kode_prodi', $kodeProdi)
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
            ->where('cpl.kode_prodi', $kodeProdi)
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

        return view('tim.bobot.detail', [
            'mk'         => $mk,
            'cpls'       => $cpls,
            'totalBobot' => $totalBobot,
        ]);
    }

    public function destroy(string $id_bobot)
    {
        $bobot = Bobot::findOrFail($id_bobot);
        $bobot->delete();

        return redirect()->route('tim.bobot.index')->with('sukses', 'Bobot berhasil dihapus.');
    }
}
