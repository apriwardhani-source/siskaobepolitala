<?php

namespace App\Services;

use App\Models\SawNilaiMahasiswa;
use App\Models\SawRanking;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SawCalculationService
{
    /**
     * Hitung ranking menggunakan metode SAW
     * 
     * @param int $id_session
     * @return array
     */
    public function calculateRanking($id_session)
    {
        try {
            // 1. Ambil semua data nilai mahasiswa untuk session ini
            $nilaiData = SawNilaiMahasiswa::where('id_session', $id_session)
                ->with('mataKuliah')
                ->get();

            if ($nilaiData->isEmpty()) {
                throw new \Exception('Tidak ada data nilai untuk session ini');
            }

            // 2. Group data per mahasiswa
            $mahasiswas = $nilaiData->groupBy('nim');
            
            // 3. Ambil semua mata kuliah yang digunakan
            $kodeMKs = $nilaiData->pluck('kode_mk')->unique();
            $mataKuliahs = MataKuliah::whereIn('kode_mk', $kodeMKs)->get()->keyBy('kode_mk');

            // 4. Hitung bobot per mata kuliah berdasarkan kompetensi
            $bobotPerMK = [];
            $totalBobot = 0;
            
            foreach ($mataKuliahs as $mk) {
                $bobot = ($mk->kompetensi_mk == 'utama') ? 2 : 1;
                $bobotPerMK[$mk->kode_mk] = $bobot;
                $totalBobot += $bobot;
            }

            // 5. Hitung nilai maksimum per mata kuliah (untuk normalisasi benefit)
            $maxNilaiPerMK = [];
            foreach ($kodeMKs as $kode_mk) {
                $maxNilaiPerMK[$kode_mk] = $nilaiData->where('kode_mk', $kode_mk)->max('nilai');
            }

            // 6. Normalisasi & Hitung Skor SAW per mahasiswa
            $hasilSAW = [];
            
            foreach ($mahasiswas as $nim => $nilaiMhs) {
                $namaMahasiswa = $nilaiMhs->first()->nama_mahasiswa;
                $totalSkor = 0;
                $detailPerhitungan = [];

                foreach ($nilaiMhs as $nilai) {
                    $kode_mk = $nilai->kode_mk;
                    $nilaiAsli = $nilai->nilai;
                    
                    // Normalisasi (Benefit: nilai/max)
                    $nilaiNormalized = $maxNilaiPerMK[$kode_mk] > 0 
                        ? $nilaiAsli / $maxNilaiPerMK[$kode_mk] 
                        : 0;
                    
                    // Bobot ternormalisasi
                    $bobotNormalized = $bobotPerMK[$kode_mk] / $totalBobot;
                    
                    // Skor weighted
                    $skorKriteria = $nilaiNormalized * $bobotNormalized;
                    $totalSkor += $skorKriteria;

                    // Simpan detail untuk breakdown
                    $detailPerhitungan[$kode_mk] = [
                        'nama_mk' => $mataKuliahs[$kode_mk]->nama_mk,
                        'kompetensi' => $mataKuliahs[$kode_mk]->kompetensi_mk,
                        'nilai_asli' => round($nilaiAsli, 2),
                        'nilai_max' => round($maxNilaiPerMK[$kode_mk], 2),
                        'normalized' => round($nilaiNormalized, 6),
                        'bobot_raw' => $bobotPerMK[$kode_mk],
                        'bobot_normalized' => round($bobotNormalized, 6),
                        'skor_kriteria' => round($skorKriteria, 6)
                    ];
                }

                $hasilSAW[$nim] = [
                    'nim' => $nim,
                    'nama_mahasiswa' => $namaMahasiswa,
                    'total_skor' => $totalSkor,
                    'detail_perhitungan' => $detailPerhitungan
                ];
            }

            // 7. Sorting berdasarkan total skor (DESC)
            uasort($hasilSAW, function($a, $b) {
                return $b['total_skor'] <=> $a['total_skor'];
            });

            // 8. Assign ranking
            $ranking = 1;
            foreach ($hasilSAW as $nim => &$data) {
                $data['ranking'] = $ranking++;
            }
            unset($data); // Break reference to avoid issues

            // Debug: Log hasil SAW sebelum insert
            Log::info("SAW Results before insert", [
                'session' => $id_session,
                'total_mahasiswa' => count($hasilSAW),
                'nims' => array_keys($hasilSAW)
            ]);

            // 9. Hapus ranking lama & simpan hasil baru ke database
            $deletedCount = DB::table('saw_rankings')->where('id_session', $id_session)->delete();
            Log::info("Deleted old rankings", ['session' => $id_session, 'deleted' => $deletedCount]);
            
            // Prepare data untuk bulk insert
            $rankingsToInsert = [];
            $processedNIMs = []; // Track processed NIMs to prevent duplicates
            
            foreach ($hasilSAW as $nim => $data) {
                // Skip if already processed (safeguard)
                if (in_array($data['nim'], $processedNIMs)) {
                    Log::warning("Duplicate NIM detected, skipping", ['nim' => $data['nim']]);
                    continue;
                }
                
                $rankingsToInsert[] = [
                    'id_session' => $id_session,
                    'nim' => $data['nim'],
                    'nama_mahasiswa' => $data['nama_mahasiswa'],
                    'total_skor' => $data['total_skor'],
                    'ranking' => $data['ranking'],
                    'detail_perhitungan' => json_encode($data['detail_perhitungan']),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                
                $processedNIMs[] = $data['nim'];
            }
            
            // Bulk insert untuk performa lebih baik dan avoid duplikasi
            if (!empty($rankingsToInsert)) {
                $insertedCount = DB::table('saw_rankings')->insert($rankingsToInsert);
                Log::info("Inserted new rankings", [
                    'session' => $id_session, 
                    'total' => count($rankingsToInsert),
                    'inserted' => $insertedCount
                ]);
            }

            Log::info("SAW Calculation completed for session {$id_session}", [
                'total_mahasiswa' => count($hasilSAW),
                'total_kriteria' => count($kodeMKs),
                'total_bobot' => $totalBobot
            ]);

            return [
                'success' => true,
                'data' => $hasilSAW,
                'meta' => [
                    'total_mahasiswa' => count($hasilSAW),
                    'total_kriteria' => count($kodeMKs),
                    'total_bobot' => $totalBobot,
                    'bobot_per_mk' => $bobotPerMK
                ]
            ];

        } catch (\Exception $e) {
            Log::error("SAW Calculation Error: " . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get detail perhitungan untuk satu mahasiswa
     */
    public function getDetailMahasiswa($id_session, $nim)
    {
        $ranking = SawRanking::where('id_session', $id_session)
            ->where('nim', $nim)
            ->first();

        if (!$ranking) {
            return null;
        }

        // Handle detail_perhitungan bisa berupa string JSON atau sudah array
        $detail = $ranking->detail_perhitungan;
        if (is_string($detail)) {
            $detail = json_decode($detail, true);
        }

        return [
            'nim' => $ranking->nim,
            'nama' => $ranking->nama_mahasiswa,
            'ranking' => $ranking->ranking,
            'total_skor' => $ranking->total_skor,
            'detail' => $detail
        ];
    }
}
