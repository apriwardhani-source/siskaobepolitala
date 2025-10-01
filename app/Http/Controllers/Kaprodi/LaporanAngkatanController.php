<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;   // Export PDF
use League\Csv\Writer;           // Export CSV
use Illuminate\Support\Facades\Response;

class LaporanAngkatanController extends Controller
{
    /**
     * Tampilkan halaman laporan angkatan
     */
    public function index(Request $request)
    {
        $laporan = null;
        $grafik  = null;

        // Jika filter dipilih
        if ($request->filled(['prodi', 'tahun_ajaran', 'angkatan'])) {
            // 🔹 Dummy data (nanti diganti query DB)
            $laporan = [
                'jumlah_mhs'      => 120,
                'rata_cpl'        => 78.5,
                'persen_tercapai' => 82,
                'persen_belum'    => 18
            ];

            $grafik = [
                'labels' => ['CPL A', 'CPL B', 'CPL C'],
                'data'   => [80, 70, 65]
            ];
        }

        return view('kaprodi.laporan_angkatan', compact('laporan', 'grafik'));
    }

    /**
     * Ekspor laporan ke PDF atau CSV
     */
    public function export(Request $request, $format)
    {
        // 🔹 Dummy data (nanti ganti query DB sesuai filter)
        $laporan = [
            ['Jumlah Mahasiswa', 120],
            ['Rata-rata CPL', 78.5],
            ['% Tercapai', '82%'],
            ['% Belum Tercapai', '18%'],
        ];

        // Ekspor PDF
        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.laporan_angkatan_pdf', compact('laporan'));
            return $pdf->download('laporan_angkatan.pdf');
        }

        // Ekspor CSV
        if ($format === 'csv') {
            $csv = Writer::createFromString('');
            $csv->insertAll($laporan);

            return Response::make($csv->toString(), 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="laporan_angkatan.csv"',
            ]);
        }

        return back()->with('error', 'Format ekspor tidak valid.');
    }
}
