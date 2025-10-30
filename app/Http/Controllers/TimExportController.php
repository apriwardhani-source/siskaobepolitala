<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PemetaanExport;

class TimExportController extends Controller
{
    public function export(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(403, 'Akses ditolak.');
        }

        // Allow wadir1 to access without kode_prodi check
        $kodeProdi = $user->role === 'wadir1' ? null : $user->kode_prodi;
        
        if ($user->role !== 'wadir1' && !$kodeProdi) {
            abort(403, 'Akses ditolak. Kode prodi tidak ditemukan.');
        }

        $idTahun = $request->get('id_tahun');
        
        $fileName = 'Pemetaan_CPL_CPMK_MK_' . date('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new PemetaanExport($idTahun, $kodeProdi), $fileName);
    }
}
