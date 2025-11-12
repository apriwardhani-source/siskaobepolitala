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
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'kode_prodi' => 'required|exists:prodis,kode_prodi',
                'id_tahun' => 'required|exists:tahun,id_tahun',
                'mata_kuliah' => 'required|array|min:2'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
        
        if (!is_array($request->mata_kuliah)) {
            return back()->withErrors(['error' => 'Mata kuliah harus berupa array'])->withInput();
        }
        
        foreach ($request->mata_kuliah as $mk) {
            if (is_array($mk)) {
                return back()->withErrors(['error' => 'Format mata kuliah tidak valid'])->withInput();
            }
        }

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $kode_prodi = $request->kode_prodi;
            $id_tahun = $request->id_tahun;
            
            $kodeMKs = is_array($request->mata_kuliah) ? $request->mata_kuliah : [$request->mata_kuliah];
            $kodeMKs = array_filter($kodeMKs);
            $kodeMKs = array_values($kodeMKs);

            // Validasi mata kuliah
            $mataKuliahs = MataKuliah::whereIn('kode_mk', $kodeMKs)
                ->where('kode_prodi', $kode_prodi)
                ->get();

            if ($mataKuliahs->count() !== count($kodeMKs)) {
                $invalidMKs = array_diff($kodeMKs, $mataKuliahs->pluck('kode_mk')->toArray());
                $prodi = Prodi::where('kode_prodi', $kode_prodi)->first();
                throw new \Exception('Beberapa mata kuliah tidak valid untuk prodi ' . ($prodi ? $prodi->nama_prodi : $kode_prodi) . '. Pastikan mata kuliah yang dipilih sesuai dengan prodi yang dipilih.');
            }

            // Ambil mahasiswa
            $mahasiswas = \App\Models\Mahasiswa::where('kode_prodi', $kode_prodi)
                ->where('id_tahun_kurikulum', $id_tahun)
                ->where('status', 'aktif')
                ->get();

            if ($mahasiswas->isEmpty()) {
                throw new \Exception('Tidak ada mahasiswa aktif untuk tahun kurikulum yang dipilih');
            }

            // Buat session
            $session = SawSession::create([
                'kode_prodi' => $kode_prodi,
                'id_tahun' => $id_tahun,
                'judul' => $request->judul,
                'uploaded_by' => $user->id,
                'total_mahasiswa' => $mahasiswas->count(),
                'status' => 'active'
            ]);

            // Ambil nilai mahasiswa
            $nilaiData = [];
            $mahasiswaWithValues = 0;

            foreach ($mahasiswas as $mhs) {
                $hasValues = false;

                foreach ($kodeMKs as $kode_mk) {
                    if (is_array($kode_mk) || empty($kode_mk)) {
                        continue;
                    }

                    $nilai = DB::table('nilai_mahasiswa')
                        ->where('nim', $mhs->nim)
                        ->where('kode_mk', $kode_mk)
                        ->where('id_tahun', $id_tahun)
                        ->whereNotNull('nilai_akhir')
                        ->first();

                    $nilaiAkhir = $nilai ? floatval($nilai->nilai_akhir) : 0;

                    if ($nilaiAkhir > 0) {
                        $hasValues = true;
                    }

                    $nilaiData[] = [
                        'id_session' => intval($session->id_session),
                        'nim' => strval($mhs->nim),
                        'nama_mahasiswa' => strval($mhs->nama_mahasiswa),
                        'kode_mk' => strval($kode_mk),
                        'nilai' => round($nilaiAkhir, 2),
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }

                if ($hasValues) {
                    $mahasiswaWithValues++;
                }
            }

            if (empty($nilaiData)) {
                throw new \Exception('Tidak ada data nilai untuk mahasiswa yang dipilih');
            }

            // Bulk insert
            if (!empty($nilaiData)) {
                $chunks = array_chunk($nilaiData, 500);
                foreach ($chunks as $chunk) {
                    SawNilaiMahasiswa::insert($chunk);
                }
            }

            // Hitung ranking
            $result = $this->sawService->calculateRanking($session->id_session);

            if (!$result['success']) {
                throw new \Exception('Gagal menghitung ranking: ' . $result['error']);
            }

            DB::commit();
            
            $totalMahasiswa = $mahasiswas->count();
            $totalKriteria = is_array($kodeMKs) ? count($kodeMKs) : 0;

            return redirect()
                ->route('admin.ranking.hasil', $session->id_session)
                ->with('success', "Ranking berhasil dihitung! Total {$totalMahasiswa} mahasiswa, {$totalKriteria} mata kuliah sebagai kriteria.");

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('SAW Ranking Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return back()
                ->withErrors(['error' => 'Error: ' . $e->getMessage()])
                ->withInput();
        }
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
        try {
            $session = SawSession::findOrFail($id_session);
            $session->delete();

            return redirect()
                ->route('admin.ranking.index')
                ->with('success', 'Session ranking berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus session: ' . $e->getMessage()]);
        }
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
