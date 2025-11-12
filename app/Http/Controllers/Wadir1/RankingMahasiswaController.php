<?php

namespace App\Http\Controllers\Wadir1;

use App\Http\Controllers\Controller;
use App\Models\SawSession;
use App\Models\SawNilaiMahasiswa;
use App\Models\SawRanking;
use App\Models\MataKuliah;
use App\Models\Prodi;
use App\Services\SawCalculationService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RankingMahasiswaController extends Controller
{
    protected $sawService;

    public function __construct(SawCalculationService $sawService)
    {
        $this->sawService = $sawService;
    }

    /**
     * Tampilkan daftar session ranking (READ-ONLY)
     */
    public function index(Request $request)
    {
        $query = SawSession::with(['tahun', 'prodi', 'uploader']);

        if ($request->has('kode_prodi') && $request->kode_prodi) {
            $query->where('kode_prodi', $request->kode_prodi);
        }

        $sessions = $query->orderBy('created_at', 'desc')->paginate(10);
        $prodis = Prodi::all();

        return view('wadir1.ranking.index', compact('sessions', 'prodis'));
    }

    /**
     * Tampilkan hasil ranking
     */
    public function hasil($id_session)
    {
        $session = SawSession::where('id_session', $id_session)
            ->with(['tahun', 'prodi'])
            ->firstOrFail();

        $rankings = SawRanking::where('id_session', $id_session)
            ->orderBy('ranking', 'asc')
            ->paginate(20);

        $kodeMKs = SawNilaiMahasiswa::where('id_session', $id_session)
            ->select('kode_mk')
            ->distinct()
            ->pluck('kode_mk')
            ->filter()
            ->toArray();

        $kriteria = MataKuliah::whereIn('kode_mk', $kodeMKs)->get();

        return view('wadir1.ranking.hasil', compact('session', 'rankings', 'kriteria'));
    }

    /**
     * Detail perhitungan mahasiswa
     */
    public function detail($id_session, $nim)
    {
        $session = SawSession::where('id_session', $id_session)
            ->with(['tahun', 'prodi'])
            ->firstOrFail();

        $detail = $this->sawService->getDetailMahasiswa($id_session, $nim);

        if (!$detail) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        return view('wadir1.ranking.detail', compact('session', 'detail'));
    }

    /**
     * Export ke Excel
     */
    public function exportExcel($id_session)
    {
        $session = SawSession::findOrFail($id_session);
        $rankings = SawRanking::where('id_session', $id_session)
            ->orderBy('ranking', 'asc')
            ->get();

        return Excel::download(
            new \App\Exports\SawRankingExport($rankings, $session),
            'ranking_mahasiswa_' . $session->prodi->kode_prodi . '_' . date('Y-m-d') . '.xlsx'
        );
    }
}
