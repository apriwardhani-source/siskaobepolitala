<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bobot;
use App\Models\CapaianProfilLulusan;
use Illuminate\Support\Facades\DB;

class Wadir1BobotController extends Controller
{
    public function index(Request $request)
    {
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');

        // Data untuk dropdown
        $prodis = DB::table('prodis')->get();
        $tahun_tersedia = DB::table('tahun')->orderByDesc('tahun')->get();

        // Jika belum pilih prodi
        if (!$kode_prodi) {
            return view('wadir1.bobot.index', [
                'bobots' => collect(),
                'kode_prodi' => '',
                'id_tahun' => $id_tahun,
                'prodis' => $prodis,
                'tahun_tersedia' => $tahun_tersedia,
            ]);
        }

        // Query dengan filter prodi dan tahun langsung pada CPL (skema baru)
        $bobots = Bobot::with(['capaianProfilLulusan', 'mataKuliah'])
            ->whereHas('capaianProfilLulusan', function ($q) use ($kode_prodi, $id_tahun) {
                $q->where('kode_prodi', $kode_prodi);
                if ($id_tahun) {
                    $q->where('id_tahun', $id_tahun);
                }
            })
            ->orderBy('id_cpl')
            ->get();

        return view('wadir1.bobot.index', compact(
            'bobots',
            'kode_prodi',
            'id_tahun',
            'prodis',
            'tahun_tersedia'
        ));
    }

    public function detail(string $id_cpl)
    {
        // Ambil CPL utama
        $cpl = CapaianProfilLulusan::findOrFail($id_cpl);

        // Ambil semua mata kuliah yang terpetakan ke CPL ini dari tabel cpl_mk
        $mk_terkait = DB::table('cpl_mk')
            ->join('mata_kuliahs', 'cpl_mk.kode_mk', '=', 'mata_kuliahs.kode_mk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->where('cpl_mk.id_cpl', $id_cpl)
            ->select('mata_kuliahs.kode_mk', 'mata_kuliahs.nama_mk', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->get();

        // Ambil data bobot untuk CPL ini
        $bobots = Bobot::where('id_cpl', $id_cpl)->get();

        // Array kode_mk => bobot
        $existingBobots = $bobots->pluck('bobot', 'kode_mk')->toArray();
        $totalBobot = array_sum($existingBobots);

        // Informasi CPL untuk header
        $first = $mk_terkait->first();
        $kode_cpl = $first->kode_cpl ?? $cpl->kode_cpl;
        $deskripsi_cpl = $first->deskripsi_cpl ?? $cpl->deskripsi_cpl;

        return view('wadir1.bobot.detail', [
            'id_cpl'        => $id_cpl,
            'kode_cpl'      => $kode_cpl,
            'deskripsi_cpl' => $deskripsi_cpl,
            'mataKuliahs'   => $mk_terkait,
            'existingBobots'=> $existingBobots,
            'totalBobot'    => $totalBobot,
        ]);
    }
}
