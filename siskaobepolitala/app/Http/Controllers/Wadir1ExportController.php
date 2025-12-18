<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CplExport;
use App\Exports\MataKuliahExport;
use App\Exports\CpmkExport;
use App\Exports\PemetaanExport;
use App\Exports\SubCpmkExport;
use App\Exports\BobotExport;
use App\Exports\MahasiswaHasilObeExport;

class Wadir1ExportController extends Controller
{
    public function exportCpl(Request $request)
    {
        return Excel::download(
            new CplExport($request->get('id_tahun'), $request->get('kode_prodi')),
            'CPL_'.date('Y-m-d_His').'.xlsx'
        );
    }

    public function exportMk(Request $request)
    {
        return Excel::download(
            new MataKuliahExport($request->get('id_tahun'), $request->get('kode_prodi')),
            'MataKuliah_'.date('Y-m-d_His').'.xlsx'
        );
    }

    public function exportCpmk(Request $request)
    {
        return Excel::download(
            new CpmkExport($request->get('id_tahun'), $request->get('kode_prodi')),
            'CPMK_'.date('Y-m-d_His').'.xlsx'
        );
    }

    public function exportPemetaan(Request $request)
    {
        return Excel::download(
            new PemetaanExport($request->get('id_tahun'), $request->get('kode_prodi')),
            'Pemetaan_CPL_CPMK_MK_'.date('Y-m-d_His').'.xlsx'
        );
    }

    public function exportSubCpmk(Request $request)
    {
        return Excel::download(
            new SubCpmkExport($request->get('id_tahun'), $request->get('kode_prodi')),
            'SubCPMK_'.date('Y-m-d_His').'.xlsx'
        );
    }

    public function exportBobot(Request $request)
    {
        return Excel::download(
            new BobotExport($request->get('id_tahun'), $request->get('kode_prodi')),
            'Bobot_CPL_MK_'.date('Y-m-d_His').'.xlsx'
        );
    }

    public function exportHasilObe(Request $request)
    {
        return Excel::download(
            new MahasiswaHasilObeExport($request->get('tahun_angkatan'), $request->get('kode_prodi')),
            'Mahasiswa_'.date('Y-m-d_His').'.xlsx'
        );
    }
}

