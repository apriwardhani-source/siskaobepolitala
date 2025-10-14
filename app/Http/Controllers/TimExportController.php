<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimExportController extends Controller
{
    public function export(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || !$user->kode_prodi) {
            abort(403, 'Akses ditolak.');
        }

        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan.');
    }
}
