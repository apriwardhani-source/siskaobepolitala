<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Prodi;
use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use App\Models\Tahun;
use App\Models\NilaiMahasiswa;
use App\Services\WhatsAppService;

class DosenController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->kode_prodi) {
            abort(403, 'Akses ditolak.');
        }

        $kodeProdi = $user->kode_prodi;

        // Parameter filter progress (mengikuti KaprodiDashboardController)
        $tahun_progress = $request->get('tahun_progress');
        $id_tahun = $request->get('id_tahun');
        $availableYears = Tahun::orderBy('tahun', 'desc')->get();

        // Jika tidak ada filter, gunakan tahun kurikulum terbaru sebagai default
        if (!$tahun_progress && $availableYears->isNotEmpty()) {
            $tahun_progress = $availableYears->first()->id_tahun;
        }

        // Informasi prodi dosen
        $prodi = Prodi::where('kode_prodi', $kodeProdi)->first();
        if (!$prodi) {
            abort(403, 'Program studi tidak ditemukan.');
        }

        // Hitung statistik kurikulum OBE (reuse rumus Kaprodi)
        $stats = null;
        if ($tahun_progress) {
            $cpl_count = DB::table('capaian_profil_lulusans')
                ->where('kode_prodi', $kodeProdi)
                ->where('id_tahun', $tahun_progress)
                ->count();

            $sks_mk = DB::table('mata_kuliahs')
                ->where('kode_prodi', $kodeProdi)
                ->sum('sks_mk');

            $mk_count = DB::table('mata_kuliahs')
                ->where('kode_prodi', $kodeProdi)
                ->count();

            $cpmk_count = DB::table('cpl_cpmk')
                ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
                ->where('cpl.kode_prodi', $kodeProdi)
                ->where('cpl.id_tahun', $tahun_progress)
                ->distinct()
                ->count('cpl_cpmk.id_cpmk');

            $subcpmk_count = DB::table('sub_cpmks')
                ->join('capaian_pembelajaran_mata_kuliahs as cpmk', 'sub_cpmks.id_cpmk', '=', 'cpmk.id_cpmk')
                ->join('cpl_cpmk', 'cpmk.id_cpmk', '=', 'cpl_cpmk.id_cpmk')
                ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
                ->where('cpl.kode_prodi', $kodeProdi)
                ->where('cpl.id_tahun', $tahun_progress)
                ->distinct()
                ->count('sub_cpmks.id_sub_cpmk');

            $target = [
                'cpl' => 9,
                'sks_mk' => 144,
                'mk' => 48,
                'cpmk' => 20,
                'subcpmk' => 40,
            ];

            $progress = [
                'cpl' => min(100, $cpl_count > 0 ? round(($cpl_count / $target['cpl']) * 100) : 0),
                'sks_mk' => min(100, $sks_mk > 0 ? round(($sks_mk / $target['sks_mk']) * 100) : 0),
                'mk' => min(100, $mk_count > 0 ? round(($mk_count / $target['mk']) * 100) : 0),
                'cpmk' => min(100, $cpmk_count > 0 ? round(($cpmk_count / $target['cpmk']) * 100) : 0),
                'subcpmk' => min(100, $subcpmk_count > 0 ? round(($subcpmk_count / $target['subcpmk']) * 100) : 0),
            ];

            $avg_progress = round(array_sum($progress) / count($progress));

            if ($cpl_count > 0 || $sks_mk > 0 || $cpmk_count > 0 || $subcpmk_count > 0) {
                $stats = [
                    'cpl_count' => $cpl_count,
                    'sks_mk' => $sks_mk,
                    'mk_count' => $mk_count,
                    'cpmk_count' => $cpmk_count,
                    'subcpmk_count' => $subcpmk_count,
                    'progress_cpl' => $progress['cpl'],
                    'progress_sks_mk' => $progress['sks_mk'],
                    'progress_mk' => $progress['mk'],
                    'progress_cpmk' => $progress['cpmk'],
                    'progress_subcpmk' => $progress['subcpmk'],
                    'avg_progress' => $avg_progress,
                    'target' => $target,
                ];
            }
        }

        // Get mata kuliah yang diampu oleh dosen ini
        $mataKuliahs = $user->mataKuliahDiajar()
            ->with(['prodi', 'dosen'])
            ->get();

        // Statistik
        $totalMK = $mataKuliahs->count();
        $totalMahasiswa = Mahasiswa::where('kode_prodi', $user->kode_prodi)
            ->where('status', 'aktif')
            ->count();

        return view('dosen.dashboard', compact(
            'prodi',
            'stats',
            'id_tahun',
            'availableYears',
            'tahun_progress',
            'mataKuliahs',
            'totalMK',
            'totalMahasiswa'
        ));
    }

    public function penilaian(Request $request)
    {
        $user = Auth::user();

        // Get mata kuliah yang diampu
        $mataKuliahs = $user->mataKuliahDiajar()
            ->with(['prodi'])
            ->get();

        // Get tahun kurikulum
        $tahunKurikulums = Tahun::all();

        // Jika form sudah disubmit (ada filter)
        $mahasiswas = null;
        $selectedMK = null;
        $selectedTahun = $request->id_tahun;

        // Selalu pilih MK jika ada kode_mk (misal datang dari tombol "Input Nilai" detail)
        if ($request->filled('kode_mk')) {
            $selectedMK = MataKuliah::where('kode_mk', $request->kode_mk)->first();
        }

        // Data mahasiswa hanya diload jika MK dan Tahun sudah dipilih
        if ($selectedMK && $request->filled('id_tahun')) {
            // Get mahasiswa berdasarkan prodi dan tahun kurikulum
            $mahasiswas = Mahasiswa::where('kode_prodi', $user->kode_prodi)
                ->where('id_tahun_kurikulum', $request->id_tahun)
                ->where('status', 'aktif')
                ->with(['tahunKurikulum'])
                ->orderBy('nim')
                ->get();

            // Get nilai yang sudah ada
            foreach ($mahasiswas as $mhs) {
                $nilai = NilaiMahasiswa::where('nim', $mhs->nim)
                    ->where('kode_mk', $request->kode_mk)
                    ->where('id_tahun', $request->id_tahun)
                    ->first();
                $mhs->nilai_akhir = $nilai ? $nilai->nilai_akhir : null;
            }
        }

        return view('dosen.penilaian.index', compact('mataKuliahs', 'tahunKurikulums', 'mahasiswas', 'selectedMK', 'selectedTahun'));
    }

    public function penilaianDetail(string $kode_mk)
    {
        $user = Auth::user();

        if (!$user || !$user->kode_prodi) {
            abort(403, 'Akses ditolak.');
        }

        // Pastikan mata kuliah yang diakses benar-benar diajar oleh dosen ini
        $mataKuliah = MataKuliah::with(['prodi'])
            ->where('kode_mk', $kode_mk)
            ->where('kode_prodi', $user->kode_prodi)
            ->firstOrFail();

        // Ambil daftar tahun kurikulum dosen ini mengampu MK ini (jika ada)
        $tahunKurikulums = \DB::table('dosen_mata_kuliah as dm')
            ->join('tahun', 'dm.id_tahun', '=', 'tahun.id_tahun')
            ->where('dm.kode_mk', $kode_mk)
            ->where('dm.user_id', $user->id)
            ->select('tahun.id_tahun', 'tahun.tahun', 'tahun.nama_kurikulum')
            ->orderByDesc('tahun.tahun')
            ->get();

        // Dosen pengampu mata kuliah (semua dosen yang mengampu MK ini)
        $dosenPengampu = \DB::table('dosen_mata_kuliah as dm')
            ->join('users', 'dm.user_id', '=', 'users.id')
            ->where('dm.kode_mk', $kode_mk)
            ->select('users.name', 'users.nip')
            ->orderBy('users.name')
            ->get();

        return view('dosen.penilaian.detail', [
            'mataKuliah' => $mataKuliah,
            'tahunKurikulums' => $tahunKurikulums,
            'dosenPengampu' => $dosenPengampu,
        ]);
    }

    public function storeNilai(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'kode_mk' => 'required|exists:mata_kuliahs,kode_mk',
            'id_tahun' => 'required|exists:tahun,id_tahun',
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ]);

        $updated = 0;
        $created = 0;

        foreach ($request->nilai as $nim => $nilai_akhir) {
            if ($nilai_akhir === null || $nilai_akhir === '') {
                continue;
            }

            // Cek apakah mahasiswa ada dan aktif
            $mahasiswa = Mahasiswa::where('nim', $nim)
                ->where('kode_prodi', $user->kode_prodi)
                ->where('status', 'aktif')
                ->first();

            if (!$mahasiswa) {
                continue;
            }

            // Ambil CPMK dan CPL pertama yang terkait dengan MK ini
            $cpmk = \DB::table('cpmk_mk')
                ->where('kode_mk', $request->kode_mk)
                ->first();

            $id_cpmk = $cpmk ? $cpmk->id_cpmk : null;
            $id_cpl = null;

            if ($id_cpmk) {
                $cpl = \DB::table('cpl_cpmk')
                    ->where('id_cpmk', $id_cpmk)
                    ->first();
                $id_cpl = $cpl ? $cpl->id_cpl : null;
            }

            // Update or create nilai
            $nilaiMhs = NilaiMahasiswa::updateOrCreate(
                [
                    'nim' => $nim,
                    'kode_mk' => $request->kode_mk,
                    'id_tahun' => $request->id_tahun,
                ],
                [
                    'nilai_akhir' => $nilai_akhir,
                    'user_id' => $user->id, // dosen yang input
                    'id_cpmk' => $id_cpmk,  // Auto-link CPMK
                    'id_cpl' => $id_cpl,    // Auto-link CPL
                ]
            );

            if ($nilaiMhs->wasRecentlyCreated) {
                $created++;
            } else {
                $updated++;
            }
        }

        $message = "Berhasil menyimpan nilai: {$created} data baru, {$updated} data diupdate.";

        // Kirim notifikasi WhatsApp konfirmasi ke dosen
        if ($created > 0 || $updated > 0) {
            \Log::info('🔔 NOTIFIKASI: Mulai kirim WhatsApp ke dosen');

            try {
                $dosen = Auth::user();
                $mataKuliah = MataKuliah::where('kode_mk', $request->kode_mk)->first();
                $tahunData = Tahun::find($request->id_tahun);

                // DEBUG: Log dosen info
                \Log::info('🔔 NOTIFIKASI: Data dosen', [
                    'id' => $dosen->id,
                    'name' => $dosen->name,
                    'email' => $dosen->email,
                    'nohp' => $dosen->nohp,
                    'created' => $created,
                    'updated' => $updated
                ]);

                // Format pesan konfirmasi
                $totalMahasiswa = $created + $updated;
                $pesanKonfirmasi = "✅ KONFIRMASI INPUT NILAI\n\n";
                $pesanKonfirmasi .= "Halo Pak/Bu {$dosen->name},\n\n";
                $pesanKonfirmasi .= "Nilai mahasiswa berhasil disimpan ke sistem:\n\n";
                $pesanKonfirmasi .= "📚 Mata Kuliah: " . ($mataKuliah->nama_mk ?? 'N/A') . "\n";
                $pesanKonfirmasi .= "📖 Kode MK: {$request->kode_mk}\n";
                $pesanKonfirmasi .= "📅 Tahun: " . ($tahunData->tahun ?? 'N/A') . "\n\n";
                $pesanKonfirmasi .= "👥 Total Mahasiswa: {$totalMahasiswa} mahasiswa\n";
                $pesanKonfirmasi .= "   • Data baru: {$created}\n";
                $pesanKonfirmasi .= "   • Data diupdate: {$updated}\n\n";
                $pesanKonfirmasi .= "⏰ Waktu Input: " . now()->format('d M Y H:i') . "\n\n";
                $pesanKonfirmasi .= "---\n";
                $pesanKonfirmasi .= "by Nandank Ganteng";

                // Kirim via WhatsApp Service
                $whatsappService = new WhatsAppService();
                $result = $whatsappService->sendMessage($dosen->nohp, $pesanKonfirmasi);

                // DEBUG: Log result
                \Log::info('🔔 NOTIFIKASI: WhatsApp result', ['result' => $result]);
            } catch (\Exception $e) {
                // Log error dengan detail lengkap
                \Log::error('🔔 NOTIFIKASI: WhatsApp notification failed', [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        return redirect()->route('dosen.penilaian.index', [
            'kode_mk' => $request->kode_mk,
            'id_tahun' => $request->id_tahun
        ])->with('success', $message);
    }
}
