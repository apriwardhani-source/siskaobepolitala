<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\SawSession;
use App\Models\SawNilaiMahasiswa;
use App\Models\SawRanking;
use App\Models\MataKuliah;
use App\Models\Tahun;
use App\Services\SawCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class RankingMahasiswaController extends Controller
{
    protected $sawService;

    public function __construct(SawCalculationService $sawService)
    {
        $this->sawService = $sawService;
    }

    /**
     * Halaman utama - daftar session & form pilih kriteria
     */
    public function index()
    {
        $user = Auth::user();
        $kode_prodi = $user->kode_prodi;

        $sessions = SawSession::where('kode_prodi', $kode_prodi)
            ->with(['tahun', 'uploader'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $tahun_tersedia = Tahun::orderBy('tahun', 'desc')->get();
        
        // Get mata kuliah untuk prodi ini
        $mataKuliahs = MataKuliah::where('kode_prodi', $kode_prodi)
            ->orderBy('semester_mk', 'asc')
            ->orderBy('nama_mk', 'asc')
            ->get();

        return view('kaprodi.ranking.index', compact('sessions', 'tahun_tersedia', 'mataKuliahs'));
    }

    /**
     * Hitung ranking dari data database
     */
    public function hitungRanking(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'id_tahun' => 'required|exists:tahun,id_tahun',
                'mata_kuliah' => 'required|array|min:2'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
        
        // Debug request
        Log::info('Request received', [
            'mata_kuliah_raw' => $request->mata_kuliah,
            'mata_kuliah_type' => gettype($request->mata_kuliah)
        ]);
        
        // Validasi manual untuk mata_kuliah
        if (!is_array($request->mata_kuliah)) {
            return back()->withErrors(['error' => 'Mata kuliah harus berupa array'])->withInput();
        }
        
        // Check for nested arrays
        foreach ($request->mata_kuliah as $mk) {
            if (is_array($mk)) {
                Log::error('Nested array detected in mata_kuliah', ['mk' => $mk]);
                return back()->withErrors(['error' => 'Format mata kuliah tidak valid (nested array detected)'])->withInput();
            }
        }

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $kode_prodi = $user->kode_prodi;
            $id_tahun = $request->id_tahun;
            
            // Ensure kodeMKs is array and clean
            $kodeMKs = is_array($request->mata_kuliah) ? $request->mata_kuliah : [$request->mata_kuliah];
            $kodeMKs = array_filter($kodeMKs); // Remove empty values
            $kodeMKs = array_values($kodeMKs); // Re-index array

            Log::info('SAW Input Debug', [
                'kode_prodi' => $kode_prodi,
                'id_tahun' => $id_tahun,
                'kodeMKs' => $kodeMKs,
                'kodeMKs_type' => gettype($kodeMKs)
            ]);

            // 1. Validasi mata kuliah milik prodi ini
            $mataKuliahs = MataKuliah::whereIn('kode_mk', $kodeMKs)
                ->where('kode_prodi', $kode_prodi)
                ->get();

            if ($mataKuliahs->count() !== count($kodeMKs)) {
                throw new \Exception('Beberapa mata kuliah tidak valid atau bukan milik prodi Anda');
            }

            // 2. Ambil mahasiswa dari prodi dan tahun yang dipilih
            $mahasiswas = \App\Models\Mahasiswa::where('kode_prodi', $kode_prodi)
                ->where('id_tahun_kurikulum', $id_tahun)
                ->where('status', 'aktif')
                ->get();

            if ($mahasiswas->isEmpty()) {
                throw new \Exception('Tidak ada mahasiswa aktif untuk tahun kurikulum yang dipilih');
            }

            // 3. Buat session baru
            $session = SawSession::create([
                'kode_prodi' => $kode_prodi,
                'id_tahun' => $id_tahun,
                'judul' => $request->judul,
                'uploaded_by' => $user->id,
                'total_mahasiswa' => $mahasiswas->count(),
                'status' => 'active'
            ]);

            // 4. Ambil nilai mahasiswa dari database untuk MK yang dipilih
            $nilaiData = [];
            $mahasiswaWithValues = 0;

            foreach ($mahasiswas as $mhs) {
                $hasValues = false;

                foreach ($kodeMKs as $kode_mk) {
                    // Skip if kode_mk is array or empty
                    if (is_array($kode_mk) || empty($kode_mk)) {
                        Log::warning('Invalid kode_mk detected', ['kode_mk' => $kode_mk]);
                        continue;
                    }

                    // Ambil nilai dari table nilai_mahasiswa
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

            // 5. Bulk insert data nilai (dengan chunk untuk avoid memory issues)
            if (!empty($nilaiData)) {
                // Insert dalam chunks untuk performa lebih baik
                $chunks = array_chunk($nilaiData, 500);
                foreach ($chunks as $chunk) {
                    SawNilaiMahasiswa::insert($chunk);
                }
            }

            // 6. Hitung ranking SAW
            $result = $this->sawService->calculateRanking($session->id_session);

            if (!$result['success']) {
                throw new \Exception('Gagal menghitung ranking: ' . $result['error']);
            }

            DB::commit();
            
            $totalMahasiswa = $mahasiswas->count();
            $totalKriteria = is_array($kodeMKs) ? count($kodeMKs) : 0;

            return redirect()
                ->route('kaprodi.ranking.hasil', $session->id_session)
                ->with('success', "Ranking berhasil dihitung! Total {$totalMahasiswa} mahasiswa, {$totalKriteria} mata kuliah sebagai kriteria.");

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('SAW Ranking Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withErrors(['error' => 'Error: ' . $e->getMessage() . ' (Line: ' . $e->getLine() . ')'])
                ->withInput();
        }
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

        // Get kriteria yang digunakan (kode_mk yang unique)
        $kodeMKs = SawNilaiMahasiswa::where('id_session', $id_session)
            ->select('kode_mk')
            ->distinct()
            ->pluck('kode_mk')
            ->filter()
            ->toArray();

        // Get mata kuliah objects
        $kriteria = MataKuliah::whereIn('kode_mk', $kodeMKs)->get();

        return view('kaprodi.ranking.hasil', compact('session', 'rankings', 'kriteria'));
    }

    /**
     * Detail perhitungan per mahasiswa
     */
    public function detail($id_session, $nim)
    {
        $user = Auth::user();
        
        $session = SawSession::where('id_session', $id_session)
            ->where('kode_prodi', $user->kode_prodi)
            ->firstOrFail();

        $detail = $this->sawService->getDetailMahasiswa($id_session, $nim);

        if (!$detail) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        return view('kaprodi.ranking.detail', compact('session', 'detail'));
    }

    /**
     * Delete session
     */
    public function destroy($id_session)
    {
        $user = Auth::user();
        
        $session = SawSession::where('id_session', $id_session)
            ->where('kode_prodi', $user->kode_prodi)
            ->firstOrFail();

        $session->delete();

        return redirect()
            ->route('kaprodi.ranking.index')
            ->with('success', 'Session berhasil dihapus');
    }

    /**
     * Export ke Excel
     */
    public function exportExcel($id_session)
    {
        $user = Auth::user();
        
        $session = SawSession::where('id_session', $id_session)
            ->where('kode_prodi', $user->kode_prodi)
            ->with(['tahun', 'prodi'])
            ->firstOrFail();

        $rankings = SawRanking::where('id_session', $id_session)
            ->orderBy('ranking', 'asc')
            ->get();

        // Export menggunakan Laravel Excel (simplified)
        $filename = 'Ranking_SAW_' . $session->judul . '_' . date('Y-m-d') . '.xlsx';

        return Excel::download(new \App\Exports\SawRankingExport($rankings, $session), $filename);
    }
}
