<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Tampilkan halaman laporan MK
    public function laporanMK(Request $request)
    {
        $laporan = null;
        $grafik = null;

        // Jika user sudah klik generate laporan
        if ($request->filled(['prodi', 'tahun_ajaran', 'matkul'])) {
            // --- Dummy data (nanti bisa diganti query ke DB) ---
            $laporan = [
                (object)[ 'mahasiswa' => 'Budi Santoso', 'cpmk' => 'CPMK 1', 'cpl' => 'CPL A', 'status' => 'Tercapai' ],
                (object)[ 'mahasiswa' => 'Siti Aminah', 'cpmk' => 'CPMK 2', 'cpl' => 'CPL B', 'status' => 'Belum' ],
                (object)[ 'mahasiswa' => 'Joko Purnomo', 'cpmk' => 'CPMK 1', 'cpl' => 'CPL A', 'status' => 'Tercapai' ],
            ];

            // Data untuk grafik
            $grafik = [
                'labels' => ['CPL A', 'CPL B'],
                'data'   => [2, 1] // contoh capaian: 2 tercapai, 1 belum
            ];
        }

        return view('kaprodi.laporan_mk', compact('laporan', 'grafik'));
    }

    // Export laporan (dummy)
    public function exportMK($format, Request $request)
    {
        if ($format === 'pdf') {
            // TODO: generate PDF pakai dompdf atau snappy
            return response("📄 Export PDF belum diimplementasi", 200);
        }

        if ($format === 'csv') {
            // TODO: generate CSV
            return response("📊 Export CSV belum diimplementasi", 200);
        }

        return redirect()->back()->with('error', 'Format tidak dikenali');
    }
}
