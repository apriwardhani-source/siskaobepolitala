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
            // Schema baru: gunakan kode_prodi dan id_tahun dari CPL
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

        return view('kaprodi.bobot.index', compact('bobots', 'id_tahun', 'tahun_tersedia'));
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

        return view('kaprodi.bobot.detail', [
            'mk'         => $mk,
            'cpls'       => $cpls,
            'totalBobot' => $totalBobot,
        ]);
    }
}
