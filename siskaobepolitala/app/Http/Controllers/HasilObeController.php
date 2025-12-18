<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Tahun;
use App\Models\NilaiMahasiswa;
use App\Models\SkorCplMahasiswa;
use App\Models\CapaianProfilLulusan;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilObeController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->tahun;
        
        $mahasiswas = collect();
        $tahun_options = Tahun::all();
        
        if ($tahun) {
            $mahasiswas = Mahasiswa::where('id_tahun_angkatan', $tahun)
                ->with(['prodi', 'tahunAngkatan'])
                ->get();
        }
        
        return view('akademik.hasil_obe.index', compact('mahasiswas', 'tahun_options', 'tahun'));
    }
    
    public function detail($nim, Request $request)
    {
        $tahun = $request->tahun;
        
        $mahasiswa = Mahasiswa::with(['prodi', 'tahunAngkatan'])->findOrFail($nim);
        
        // Ambil semua mata kuliah yang diambil oleh mahasiswa ini berdasarkan tahun
        $mata_kuliahs = MataKuliah::join('nilai_mahasiswa', 'mata_kuliahs.kode_mk', '=', 'nilai_mahasiswa.kode_mk')
            ->where('nilai_mahasiswa.nim', $nim)
            ->where('nilai_mahasiswa.id_tahun', $tahun)
            ->select('mata_kuliahs.*')
            ->distinct()
            ->get();
        
        // Untuk setiap mata kuliah, ambil nilai-nilai yang terkait
        foreach ($mata_kuliahs as $mk) {
            $mk->nilai_detail = NilaiMahasiswa::where('nim', $nim)
                ->where('kode_mk', $mk->kode_mk)
                ->where('id_tahun', $tahun)
                ->with(['teknikPenilaian', 'cpl', 'cpmk'])
                ->get();
        }
        
        $tahun_options = Tahun::all();
        
        return view('akademik.hasil_obe.detail', compact('mahasiswa', 'mata_kuliahs', 'tahun_options', 'tahun'));
    }
    
    public function rumusanMatkul(Request $request)
    {
        $tahun = $request->tahun;
        $kode_mk = $request->kode_mk;
        
        // Ambil semua teknik penilaian untuk mata kuliah ini di tahun tertentu
        $teknik_penilaians = \App\Models\TeknikPenilaian::where('kode_mk', $kode_mk)
            ->where('id_tahun', $tahun)
            ->with(['cpl', 'cpmk'])
            ->get();
        
        // Ambil data nilai untuk semua mahasiswa di mata kuliah ini dan tahun ini
        $nilai_mahasiswas = NilaiMahasiswa::where('kode_mk', $kode_mk)
            ->where('id_tahun', $tahun)
            ->with(['mahasiswa', 'teknikPenilaian', 'cpl', 'cpmk'])
            ->get();
        
        $tahun_options = Tahun::all();
        $mata_kuliahs = MataKuliah::all();
        
        return view('akademik.rumusan.mata_kuliah', compact('nilai_mahasiswas', 'teknik_penilaians', 'tahun_options', 'mata_kuliahs', 'tahun', 'kode_mk'));
    }
    
    public function rumusanCpl(Request $request)
    {
        $tahun = $request->tahun;
        
        // Ambil semua CPL
        $cpls = CapaianProfilLulusan::all();
        
        // Hitung rata-rata skor untuk setiap CPL dari semua mahasiswa di tahun tersebut
        $cpl_scores = [];
        foreach ($cpls as $cpl) {
            $avg_score = SkorCplMahasiswa::where('id_cpl', $cpl->id_cpl)
                ->where('id_tahun', $tahun)
                ->avg('skor');
            
            $cpl_scores[$cpl->id_cpl] = $avg_score ? round($avg_score, 2) : 0;
        }
        
        $tahun_options = Tahun::all();
        
        return view('akademik.rumusan.cpl', compact('cpls', 'cpl_scores', 'tahun_options', 'tahun'));
    }
    
    public function calculateCplScores($tahun)
    {
        // Ambil semua mahasiswa di tahun angkatan tertentu
        $mahasiswas = Mahasiswa::where('id_tahun_angkatan', $tahun)->get();
        
        foreach ($mahasiswas as $mahasiswa) {
            // Ambil semua nilai mahasiswa ini untuk tahun tertentu
            $nilai_mahasiswas = NilaiMahasiswa::where('nim', $mahasiswa->nim)
                ->where('id_tahun', $tahun)
                ->get();
            
            // Kelompokkan berdasarkan CPL
            $cpl_scores = [];
            foreach ($nilai_mahasiswas as $nilai) {
                if ($nilai->id_cpl) {
                    if (!isset($cpl_scores[$nilai->id_cpl])) {
                        $cpl_scores[$nilai->id_cpl] = [
                            'total_score' => 0,
                            'count' => 0
                        ];
                    }
                    
                    $cpl_scores[$nilai->id_cpl]['total_score'] += $nilai->nilai;
                    $cpl_scores[$nilai->id_cpl]['count']++;
                }
            }
            
            // Hitung rata-rata dan simpan ke skor_cpl_mahasiswa
            foreach ($cpl_scores as $id_cpl => $data) {
                $avg_score = $data['total_score'] / $data['count'];
                
                \App\Models\SkorCplMahasiswa::updateOrCreate(
                    [
                        'nim' => $mahasiswa->nim,
                        'id_cpl' => $id_cpl,
                        'id_tahun' => $tahun,
                    ],
                    [
                        'skor' => $avg_score,
                    ]
                );
            }
        }
        
        return redirect()->back()->with('success', 'Perhitungan skor CPL selesai');
    }
}