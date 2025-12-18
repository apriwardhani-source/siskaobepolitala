<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\SawSession;
use App\Models\SawNilaiMahasiswa;
use App\Models\SawRanking;
use App\Models\MataKuliah;
use App\Services\SawCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RankingMahasiswaController extends Controller
{
    protected $sawService;

    public function __construct(SawCalculationService $sawService)
    {
        $this->sawService = $sawService;
    }

    /**
     * Tampilkan daftar session ranking (READ-ONLY untuk prodi sendiri)
     */
    public function index()
    {
        $user = Auth::user();
        
        $sessions = SawSession::where('kode_prodi', $user->kode_prodi)
            ->with(['tahun', 'prodi', 'uploader'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dosen.ranking.index', compact('sessions'));
    }

    /**
     * Tampilkan hasil ranking
     */
    public function hasil($id_session)
    {
        $user = Auth::user();
        
        $session = SawSession::where('id_session', $id_session)
            ->where('kode_prodi', $user->kode_prodi)
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

        return view('dosen.ranking.hasil', compact('session', 'rankings', 'kriteria'));
    }

    /**
     * Detail perhitungan mahasiswa
     */
    public function detail($id_session, $nim)
    {
        $user = Auth::user();
        
        $session = SawSession::where('id_session', $id_session)
            ->where('kode_prodi', $user->kode_prodi)
            ->with(['tahun', 'prodi'])
            ->firstOrFail();

        $detail = $this->sawService->getDetailMahasiswa($id_session, $nim);

        if (!$detail) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        return view('dosen.ranking.detail', compact('session', 'detail'));
    }

    /**
     * Export ke Excel
     */
    public function exportExcel($id_session)
    {
        $user = Auth::user();
        
        $session = SawSession::where('id_session', $id_session)
            ->where('kode_prodi', $user->kode_prodi)
            ->firstOrFail();
            
        $rankings = SawRanking::where('id_session', $id_session)
            ->orderBy('ranking', 'asc')
            ->get();

        return Excel::download(
            new \App\Exports\SawRankingExport($rankings, $session),
            'ranking_mahasiswa_' . $session->prodi->kode_prodi . '_' . date('Y-m-d') . '.xlsx'
        );
    }
}
