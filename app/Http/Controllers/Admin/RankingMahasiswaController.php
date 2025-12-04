<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SawSession;
use App\Models\SawNilaiMahasiswa;
use App\Models\SawRanking;
use App\Models\MataKuliah;
use App\Models\Tahun;
use App\Models\Prodi;
use App\Services\SawCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class RankingMahasiswaController extends Controller
{
    protected $sawService;

    public function __construct(SawCalculationService $sawService)
    {
        $this->sawService = $sawService;
    }

    /**
     * Tampilkan daftar session ranking
     */
    public function index(Request $request)
    {
        $query = SawSession::with(['tahun', 'prodi', 'uploader']);

        // Filter by prodi if selected
        if ($request->has('kode_prodi') && $request->kode_prodi) {
            $query->where('kode_prodi', $request->kode_prodi);
        }

        $sessions = $query->orderBy('created_at', 'desc')->paginate(10);
        $prodis = Prodi::all();
        $tahuns = Tahun::all();
        
        // Load all mata kuliah (akan difilter via JavaScript nanti)
        $mataKuliahs = MataKuliah::orderBy('semester_mk')->orderBy('kode_mk')->get();

        return view('admin.ranking.index', compact('sessions', 'prodis', 'tahuns', 'mataKuliahs'));
    }

    /**
     * Proses hitung ranking (sama seperti Kaprodi tapi bisa pilih prodi)
     */
    public function hitungRanking(Request $request)
    {
        abort(403);
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

        return view('admin.ranking.hasil', compact('session', 'rankings', 'kriteria'));
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

        return view('admin.ranking.detail', compact('session', 'detail'));
    }

    /**
     * Hapus session ranking
     */
    public function destroy($id_session)
    {
        abort(403);
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
