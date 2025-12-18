<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\NilaiMahasiswa;
use App\Models\SkorCplMahasiswa;
use App\Models\CapaianProfilLulusan;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardAnalyticsController extends Controller
{
    /**
     * Get dashboard statistics for Admin/Wadir1/Kaprodi
     */
    public function getStatistics(Request $request)
    {
        $user = Auth::user();
        $kodeProdi = $request->get('kode_prodi') ?? $user->kode_prodi;
        
        $stats = [
            'totalMahasiswa' => $this->getTotalMahasiswa($kodeProdi),
            'totalMataKuliah' => $this->getTotalMataKuliah($kodeProdi),
            'totalCPL' => $this->getTotalCPL($kodeProdi),
            'rataRataNilai' => $this->getRataRataNilai($kodeProdi),
            'distribusiNilai' => $this->getDistribusiNilai($kodeProdi),
            'pencapaianCPL' => $this->getPencapaianCPL($kodeProdi),
            'trendSemester' => $this->getTrendSemester($kodeProdi),
            'topMataKuliah' => $this->getTopMataKuliah($kodeProdi),
            'bottomMataKuliah' => $this->getBottomMataKuliah($kodeProdi),
        ];
        
        return response()->json($stats);
    }
    
    /**
     * Total mahasiswa aktif
     */
    private function getTotalMahasiswa($kodeProdi)
    {
        $query = Mahasiswa::query();
        
        if ($kodeProdi) {
            $query->where('kode_prodi', $kodeProdi);
        }
        
        return $query->count();
    }
    
    /**
     * Total mata kuliah
     */
    private function getTotalMataKuliah($kodeProdi)
    {
        $query = MataKuliah::query();
        
        if ($kodeProdi) {
            $query->where('kode_prodi', $kodeProdi);
        }
        
        return $query->count();
    }
    
    /**
     * Total CPL
     */
    private function getTotalCPL($kodeProdi)
    {
        $query = CapaianProfilLulusan::query();
        
        if ($kodeProdi) {
            $query->where('kode_prodi', $kodeProdi);
        }
        
        return $query->count();
    }
    
    /**
     * Rata-rata nilai keseluruhan
     */
    private function getRataRataNilai($kodeProdi)
    {
        $query = NilaiMahasiswa::query();
        
        if ($kodeProdi) {
            $query->whereHas('mahasiswa', function($q) use ($kodeProdi) {
                $q->where('kode_prodi', $kodeProdi);
            });
        }
        
        return round($query->avg('nilai_angka') ?? 0, 2);
    }
    
    /**
     * Distribusi nilai (untuk chart pie/bar)
     */
    private function getDistribusiNilai($kodeProdi)
    {
        $query = NilaiMahasiswa::query();
        
        if ($kodeProdi) {
            $query->whereHas('mahasiswa', function($q) use ($kodeProdi) {
                $q->where('kode_prodi', $kodeProdi);
            });
        }
        
        $nilaiData = $query->get();
        
        $distribusi = [
            'A' => 0,
            'A-' => 0,
            'B+' => 0,
            'B' => 0,
            'B-' => 0,
            'C+' => 0,
            'C' => 0,
            'D' => 0,
            'E' => 0,
        ];
        
        foreach ($nilaiData as $nilai) {
            $grade = $this->getGrade($nilai->nilai_angka);
            if (isset($distribusi[$grade])) {
                $distribusi[$grade]++;
            }
        }
        
        return [
            'labels' => array_keys($distribusi),
            'data' => array_values($distribusi),
        ];
    }
    
    /**
     * Pencapaian CPL per mahasiswa (untuk chart radar)
     */
    private function getPencapaianCPL($kodeProdi)
    {
        $cplList = CapaianProfilLulusan::where('kode_prodi', $kodeProdi)
            ->orderBy('kode_cpl')
            ->get();
            
        $labels = [];
        $data = [];
        
        foreach ($cplList as $cpl) {
            $avgSkor = SkorCplMahasiswa::where('id_cpl', $cpl->id_cpl)
                ->avg('skor_cpl');
                
            $labels[] = $cpl->kode_cpl;
            $data[] = round($avgSkor ?? 0, 2);
        }
        
        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
    
    /**
     * Trend nilai per semester (untuk chart line)
     */
    private function getTrendSemester($kodeProdi)
    {
        $query = NilaiMahasiswa::select(
                DB::raw('mata_kuliahs.semester'),
                DB::raw('AVG(nilai_mahasiswa.nilai_angka) as avg_nilai')
            )
            ->join('mata_kuliahs', 'nilai_mahasiswa.kode_mk', '=', 'mata_kuliahs.kode_mk');
            
        if ($kodeProdi) {
            $query->whereHas('mahasiswa', function($q) use ($kodeProdi) {
                $q->where('kode_prodi', $kodeProdi);
            });
        }
        
        $trend = $query->groupBy('mata_kuliahs.semester')
            ->orderBy('mata_kuliahs.semester')
            ->get();
            
        return [
            'labels' => $trend->pluck('semester')->toArray(),
            'data' => $trend->pluck('avg_nilai')->map(function($val) {
                return round($val, 2);
            })->toArray(),
        ];
    }
    
    /**
     * Top 5 mata kuliah dengan nilai tertinggi
     */
    private function getTopMataKuliah($kodeProdi)
    {
        $query = NilaiMahasiswa::select(
                'mata_kuliahs.nama_mk',
                DB::raw('AVG(nilai_mahasiswa.nilai_angka) as avg_nilai')
            )
            ->join('mata_kuliahs', 'nilai_mahasiswa.kode_mk', '=', 'mata_kuliahs.kode_mk');
            
        if ($kodeProdi) {
            $query->where('mata_kuliahs.kode_prodi', $kodeProdi);
        }
        
        $top = $query->groupBy('mata_kuliahs.nama_mk', 'mata_kuliahs.kode_mk')
            ->orderBy('avg_nilai', 'desc')
            ->limit(5)
            ->get();
            
        return [
            'labels' => $top->pluck('nama_mk')->toArray(),
            'data' => $top->pluck('avg_nilai')->map(function($val) {
                return round($val, 2);
            })->toArray(),
        ];
    }
    
    /**
     * Bottom 5 mata kuliah dengan nilai terendah (perlu improvement)
     */
    private function getBottomMataKuliah($kodeProdi)
    {
        $query = NilaiMahasiswa::select(
                'mata_kuliahs.nama_mk',
                DB::raw('AVG(nilai_mahasiswa.nilai_angka) as avg_nilai')
            )
            ->join('mata_kuliahs', 'nilai_mahasiswa.kode_mk', '=', 'mata_kuliahs.kode_mk');
            
        if ($kodeProdi) {
            $query->where('mata_kuliahs.kode_prodi', $kodeProdi);
        }
        
        $bottom = $query->groupBy('mata_kuliahs.nama_mk', 'mata_kuliahs.kode_mk')
            ->orderBy('avg_nilai', 'asc')
            ->limit(5)
            ->get();
            
        return [
            'labels' => $bottom->pluck('nama_mk')->toArray(),
            'data' => $bottom->pluck('avg_nilai')->map(function($val) {
                return round($val, 2);
            })->toArray(),
        ];
    }
    
    /**
     * Helper: Convert nilai to grade
     */
    private function getGrade($nilai)
    {
        if ($nilai >= 85) return 'A';
        if ($nilai >= 80) return 'A-';
        if ($nilai >= 75) return 'B+';
        if ($nilai >= 70) return 'B';
        if ($nilai >= 65) return 'B-';
        if ($nilai >= 60) return 'C+';
        if ($nilai >= 55) return 'C';
        if ($nilai >= 50) return 'D';
        return 'E';
    }
}
