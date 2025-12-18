<?php

namespace App\Http\Controllers;

use App\Models\NilaiMahasiswa;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TeknikPenilaian;
use App\Models\CapaianProfilLulusan;
use App\Models\CapaianPembelajaranMataKuliah;
use App\Models\Tahun;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianDosenController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->tahun;
        $kode_mk = $request->kode_mk;
        $nim = $request->nim;
        
        $query = NilaiMahasiswa::query();
        
        if ($tahun) {
            $query->where('id_tahun', $tahun);
        }
        
        if ($kode_mk) {
            $query->where('kode_mk', $kode_mk);
        }
        
        if ($nim) {
            $query->where('nim', $nim);
        }
        
        $nilais = $query->with(['mahasiswa', 'mataKuliah', 'teknikPenilaian', 'cpl', 'cpmk', 'tahun'])->get();
        $tahun_options = Tahun::all();
        $mata_kuliahs = MataKuliah::all();
        $mahasiswas = Mahasiswa::all();
        
        return view('dosen.penilaian.index', compact('nilais', 'tahun_options', 'mata_kuliahs', 'mahasiswas', 'tahun', 'kode_mk', 'nim'));
    }

    public function create($kode_mk = null)
    {
        $tahun = Tahun::all();
        $mahasiswa = Mahasiswa::all();
        $mata_kuliah = $kode_mk ? MataKuliah::where('kode_mk', $kode_mk)->first() : null;
        $teknik_penilaian = TeknikPenilaian::where('kode_mk', $kode_mk)->get();
        $cpls = CapaianProfilLulusan::all();
        $cpmks = CapaianPembelajaranMataKuliah::all();
        
        return view('dosen.penilaian.create', compact('tahun', 'mahasiswa', 'mata_kuliah', 'teknik_penilaian', 'cpls', 'cpmks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'kode_mk' => 'required',
            'id_teknik' => 'required',
            'nilai' => 'required|numeric|min:0|max:100',
            'id_tahun' => 'required',
        ]);

        // Create nilai
        $nilai = NilaiMahasiswa::create(array_merge(
            $request->all(),
            ['user_id' => Auth::id()]
        ));

        // Load relationships untuk notifikasi
        $nilai->load(['mahasiswa', 'mataKuliah', 'teknikPenilaian', 'tahun']);

        // Kirim notifikasi WhatsApp konfirmasi ke dosen
        \Log::info('🔔 NOTIFIKASI: Mulai kirim WhatsApp ke dosen');
        
        try {
            $dosen = Auth::user();
            
            // DEBUG: Log dosen info
            \Log::info('🔔 NOTIFIKASI: Data dosen', [
                'id' => $dosen->id,
                'name' => $dosen->name,
                'email' => $dosen->email,
                'nohp' => $dosen->nohp,
                'nohp_cleaned' => preg_replace('/[^\d]/', '', $dosen->nohp ?? '')
            ]);
            
            $whatsappService = new WhatsAppService();
            $result = $whatsappService->sendNilaiNotification([
                'dosen_name' => $dosen->name,
                'dosen_phone' => $dosen->nohp, // Nomor WhatsApp dosen
                'mata_kuliah' => $nilai->mataKuliah->nama_mk ?? 'N/A',
                'kode_mk' => $nilai->kode_mk,
                'mahasiswa_name' => $nilai->mahasiswa->nama ?? 'N/A',
                'nim' => $nilai->nim,
                'teknik_penilaian' => $nilai->teknikPenilaian->nama_teknik ?? 'N/A',
                'nilai' => $nilai->nilai,
                'tahun' => $nilai->tahun->tahun ?? 'N/A',
            ]);
            
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

        return redirect()->route('dosen.penilaian.index')->with('success', 'Nilai berhasil ditambahkan dan notifikasi terkirim');
    }

    public function edit($id)
    {
        $nilai = NilaiMahasiswa::findOrFail($id);
        $tahun = Tahun::all();
        $mahasiswa = Mahasiswa::all();
        $mata_kuliah = MataKuliah::all();
        $teknik_penilaian = TeknikPenilaian::where('kode_mk', $nilai->kode_mk)->get();
        $cpls = CapaianProfilLulusan::all();
        $cpmks = CapaianPembelajaranMataKuliah::all();
        
        return view('dosen.penilaian.edit', compact('nilai', 'tahun', 'mahasiswa', 'mata_kuliah', 'teknik_penilaian', 'cpls', 'cpmks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nim' => 'required',
            'kode_mk' => 'required',
            'id_teknik' => 'required',
            'nilai' => 'required|numeric|min:0|max:100',
            'id_tahun' => 'required',
        ]);

        $nilai = NilaiMahasiswa::findOrFail($id);
        $nilai->update($request->all());

        return redirect()->route('dosen.penilaian.index')->with('success', 'Nilai berhasil diperbarui');
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'kode_mk' => 'required',
            'teknik_penilaian' => 'required|array',
            'teknik_penilaian.*' => 'exists:teknik_penilaian,id_teknik',
            'nilai.*' => 'required|numeric|min:0|max:100',
        ]);

        $nilai_data = $request->nilai;
        $teknik_penilaian_ids = $request->teknik_penilaian;
        $tahun = $request->tahun;
        $kode_mk = $request->kode_mk;
        $nim = $request->nim;

        $nilaiList = [];

        foreach ($teknik_penilaian_ids as $index => $teknik_id) {
            if (isset($nilai_data[$teknik_id]) && $nilai_data[$teknik_id] !== null) {
                NilaiMahasiswa::updateOrCreate(
                    [
                        'nim' => $nim,
                        'kode_mk' => $kode_mk,
                        'id_teknik' => $teknik_id,
                        'id_tahun' => $tahun,
                    ],
                    [
                        'nilai' => $nilai_data[$teknik_id],
                        'user_id' => Auth::id(),
                    ]
                );

                // Collect untuk notifikasi
                $teknik = TeknikPenilaian::find($teknik_id);
                $nilaiList[] = [
                    'teknik' => $teknik->nama_teknik ?? "Teknik #{$teknik_id}",
                    'nilai' => $nilai_data[$teknik_id]
                ];
            }
        }

        // Kirim notifikasi WhatsApp konfirmasi bulk ke dosen
        if (!empty($nilaiList)) {
            \Log::info('🔔 NOTIFIKASI BULK: Mulai kirim WhatsApp ke dosen');
            
            try {
                $dosen = Auth::user();
                $mahasiswa = Mahasiswa::where('nim', $nim)->first();
                $mataKuliah = MataKuliah::where('kode_mk', $kode_mk)->first();
                $tahunData = Tahun::find($tahun);

                // DEBUG: Log dosen info
                \Log::info('🔔 NOTIFIKASI BULK: Data dosen', [
                    'id' => $dosen->id,
                    'name' => $dosen->name,
                    'email' => $dosen->email,
                    'nohp' => $dosen->nohp,
                    'nilai_count' => count($nilaiList)
                ]);

                $whatsappService = new WhatsAppService();
                $result = $whatsappService->sendBulkNilaiNotification([
                    'dosen_name' => $dosen->name,
                    'dosen_phone' => $dosen->nohp, // Nomor WhatsApp dosen
                    'mata_kuliah' => $mataKuliah->nama_mk ?? 'N/A',
                    'kode_mk' => $kode_mk,
                    'mahasiswa_name' => $mahasiswa->nama ?? 'N/A',
                    'nim' => $nim,
                    'tahun' => $tahunData->tahun ?? 'N/A',
                    'nilai_list' => $nilaiList,
                ]);
                
                // DEBUG: Log result
                \Log::info('🔔 NOTIFIKASI BULK: WhatsApp result', ['result' => $result]);
                
            } catch (\Exception $e) {
                // Log error dengan detail lengkap
                \Log::error('🔔 NOTIFIKASI BULK: WhatsApp notification failed', [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        return redirect()->route('dosen.penilaian.index', ['kode_mk' => $kode_mk, 'tahun' => $tahun])->with('success', 'Nilai berhasil ditambahkan dan notifikasi terkirim');
    }

    /**
     * Import nilai dari file Excel
     */
    public function importNilai(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
            'kode_mk' => 'required|exists:mata_kuliahs,kode_mk',
            'id_tahun' => 'required|exists:tahun,id_tahun',
        ]);

        try {
            $import = new \App\Imports\NilaiMahasiswaImport(
                $request->kode_mk,
                $request->id_tahun
            );
            
            \Maatwebsite\Excel\Facades\Excel::import($import, $request->file('file'));

            $successCount = $import->getSuccessCount();
            $errorCount = $import->getErrorCount();

            if ($errorCount > 0) {
                return redirect()->route('dosen.penilaian.index', [
                    'kode_mk' => $request->kode_mk,
                    'tahun' => $request->id_tahun
                ])->with('warning', "Import selesai: {$successCount} berhasil, {$errorCount} gagal (data tidak lengkap)");
            }

            return redirect()->route('dosen.penilaian.index', [
                'kode_mk' => $request->kode_mk,
                'tahun' => $request->id_tahun
            ])->with('success', "Berhasil import {$successCount} data nilai!");

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            return redirect()->route('dosen.penilaian.index')
                ->with('error', 'Gagal import: ' . implode(' | ', array_slice($errorMessages, 0, 3)));

        } catch (\Exception $e) {
            \Log::error('Import Nilai Error', ['error' => $e->getMessage()]);
            return redirect()->route('dosen.penilaian.index')
                ->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Download template import nilai
     */
    public function downloadTemplate(Request $request)
    {
        $kode_mk = $request->kode_mk;
        
        $filename = 'template_import_nilai.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        // Ambil teknik penilaian untuk mata kuliah ini
        $teknikPenilaians = [];
        if ($kode_mk) {
            $teknikPenilaians = TeknikPenilaian::where('kode_mk', $kode_mk)->get();
        }

        // Ambil daftar mahasiswa
        $mahasiswas = Mahasiswa::orderBy('nim')->take(5)->get();

        $callback = function() use ($teknikPenilaians, $mahasiswas, $kode_mk) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM untuk Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            $columns = ['nim', 'nama_mahasiswa', 'id_teknik', 'nama_teknik', 'nilai'];
            fputcsv($file, $columns);
            
            // Sample data
            foreach ($mahasiswas as $mhs) {
                foreach ($teknikPenilaians as $teknik) {
                    fputcsv($file, [
                        $mhs->nim,
                        $mhs->nama,
                        $teknik->id_teknik,
                        $teknik->nama_teknik,
                        rand(60, 100) // Contoh nilai random
                    ]);
                }
            }

            // Jika tidak ada data, berikan contoh generic
            if ($mahasiswas->isEmpty() || $teknikPenilaians->isEmpty()) {
                fputcsv($file, ['1234567890', 'Nama Mahasiswa', '1', 'Quiz 1', '85']);
                fputcsv($file, ['1234567890', 'Nama Mahasiswa', '2', 'UTS', '80']);
                fputcsv($file, ['1234567890', 'Nama Mahasiswa', '3', 'UAS', '90']);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}