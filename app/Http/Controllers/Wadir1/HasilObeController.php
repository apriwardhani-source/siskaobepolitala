<?php

namespace App\Http\Controllers\Wadir1;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Tahun;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

class HasilObeController extends Controller
{
    public function index(Request $request)
    {
        $tahun_angkatan = $request->tahun_angkatan;
        $kode_prodi = $request->kode_prodi;
        
        $mahasiswas = collect();
        $tahun_options = Tahun::orderBy('tahun', 'desc')->get();
        $prodi_options = Prodi::all();
        
        if ($tahun_angkatan) {
            $query = Mahasiswa::with(['prodi', 'tahunKurikulum'])
                ->whereHas('tahunKurikulum', function($q) use ($tahun_angkatan) {
                    $q->where('tahun', $tahun_angkatan);
                });
                
            if ($kode_prodi) {
                $query->where('kode_prodi', $kode_prodi);
            }
            
            $mahasiswas = $query->orderBy('nama_mahasiswa')->get();
        }
        
        return view('wadir1.hasilobe.index', compact('mahasiswas', 'tahun_options', 'prodi_options', 'tahun_angkatan', 'kode_prodi'));
    }
    
    public function detail($nim)
    {
        $mahasiswa = Mahasiswa::with(['prodi','tahunKurikulum'])->where('nim', $nim)->firstOrFail();
        
        $nilaiMahasiswa = DB::table('nilai_mahasiswa')
            ->where('nim', $nim)
            ->get()
            ->keyBy('kode_mk');
        
        $hasil_obe = DB::table('mata_kuliahs as mk')
            ->join('cpmk_mk', 'mk.kode_mk', '=', 'cpmk_mk.kode_mk')
            ->join('capaian_pembelajaran_mata_kuliahs as cpmk', 'cpmk_mk.id_cpmk', '=', 'cpmk.id_cpmk')
            ->leftJoin('cpl_cpmk', 'cpmk.id_cpmk', '=', 'cpl_cpmk.id_cpmk')
            ->leftJoin('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
            ->whereIn('mk.kode_mk', $nilaiMahasiswa->keys()->toArray())
            ->select(
                'mk.kode_mk',
                'mk.nama_mk',
                'mk.semester_mk',
                'mk.sks_mk',
                'cpl.kode_cpl',
                'cpl.deskripsi_cpl',
                'cpmk.kode_cpmk',
                'cpmk.deskripsi_cpmk'
            )
            ->orderBy('mk.semester_mk')
            ->orderBy('mk.kode_mk')
            ->orderBy('cpl.kode_cpl')
            ->orderBy('cpmk.kode_cpmk')
            ->get()
            ->map(function($item) use ($nilaiMahasiswa) {
                $nilai = $nilaiMahasiswa->get($item->kode_mk);
                $item->skor_maks = 100;
                $item->nilai_perkuliahan = $nilai ? $nilai->nilai_akhir : 0;
                return $item;
            });
        
        $grouped_data = $hasil_obe->groupBy('kode_mk')->map(function ($items) {
            return [
                'kode_mk' => $items->first()->kode_mk,
                'nama_mk' => $items->first()->nama_mk,
                'semester_mk' => $items->first()->semester_mk,
                'sks_mk' => $items->first()->sks_mk,
                'details' => $items->map(function ($item) {
                    return [
                        'kode_cpl' => $item->kode_cpl ?? '-',
                        'kode_cpmk' => $item->kode_cpmk ?? '-',
                        'skor_maks' => $item->skor_maks ?? 100,
                        'nilai_perkuliahan' => $item->nilai_perkuliahan
                    ];
                })
            ];
        });
        
        return view('wadir1.hasilobe.detail', compact('mahasiswa', 'grouped_data'));
    }

    public function exportPdf($nim)
    {
        $mahasiswa = Mahasiswa::with('prodi')->where('nim', $nim)->firstOrFail();

        $nilaiMahasiswa = DB::table('nilai_mahasiswa')
            ->where('nim', $nim)
            ->get()
            ->keyBy('kode_mk');

        $hasil_obe = DB::table('mata_kuliahs as mk')
            ->join('cpmk_mk', 'mk.kode_mk', '=', 'cpmk_mk.kode_mk')
            ->join('capaian_pembelajaran_mata_kuliahs as cpmk', 'cpmk_mk.id_cpmk', '=', 'cpmk.id_cpmk')
            ->leftJoin('cpl_cpmk', 'cpmk.id_cpmk', '=', 'cpl_cpmk.id_cpmk')
            ->leftJoin('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
            ->whereIn('mk.kode_mk', $nilaiMahasiswa->keys()->toArray())
            ->select('mk.kode_mk','mk.nama_mk','mk.semester_mk','mk.sks_mk','cpl.kode_cpl','cpmk.kode_cpmk')
            ->orderBy('mk.semester_mk')
            ->orderBy('mk.kode_mk')
            ->orderBy('cpl.kode_cpl')
            ->orderBy('cpmk.kode_cpmk')
            ->get()
            ->map(function($item) use ($nilaiMahasiswa) {
                $nilai = $nilaiMahasiswa->get($item->kode_mk);
                $item->skor_maks = 100;
                $item->nilai_perkuliahan = $nilai ? $nilai->nilai_akhir : 0;
                return $item;
            });

        $grouped_data = $hasil_obe->groupBy('kode_mk')->map(function ($items) {
            return [
                'kode_mk' => $items->first()->kode_mk,
                'nama_mk' => $items->first()->nama_mk,
                'semester_mk' => $items->first()->semester_mk,
                'sks_mk' => $items->first()->sks_mk,
                'details' => $items->map(function ($item) {
                    return [
                        'kode_cpl' => $item->kode_cpl ?? '-',
                        'kode_cpmk' => $item->kode_cpmk ?? '-',
                        'skor_maks' => $item->skor_maks ?? 100,
                        'nilai_perkuliahan' => $item->nilai_perkuliahan,
                    ];
                })
            ];
        });

        // Render HTML untuk PDF
        $html = view('wadir1.hasilobe.pdf', [
            'mahasiswa' => $mahasiswa,
            'grouped_data' => $grouped_data,
        ])->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Hasil_OBE_'.$nim.'.pdf"'
        ]);
    }
}
