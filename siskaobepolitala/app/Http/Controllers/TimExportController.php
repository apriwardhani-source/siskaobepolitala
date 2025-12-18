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

        // Determine kode_prodi based on role
        $kodeProdi = null;
        
        if (in_array($user->role, ['admin', 'wadir1'])) {
            // Admin and wadir1 can export for any prodi via query parameter
            $kodeProdi = $request->get('kode_prodi');
        } else {
            // Tim, kaprodi, and other roles use their assigned prodi
            $kodeProdi = $user->kode_prodi;
            
            if (!$kodeProdi) {
                abort(403, 'Akses ditolak. Kode prodi tidak ditemukan.');
            }
        }

        $idTahun = $request->get('id_tahun');
        
        $fileName = 'Pemetaan_CPL_CPMK_MK_' . date('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new PemetaanExport($idTahun, $kodeProdi), $fileName);
    }
}
