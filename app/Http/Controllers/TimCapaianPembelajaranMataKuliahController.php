<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CapaianPembelajaranMataKuliah;
use App\Models\MataKuliah;
use App\Models\CapaianProfilLulusan;
use App\Imports\CpmkImport;
use Maatwebsite\Excel\Facades\Excel;

class TimCapaianPembelajaranMataKuliahController extends Controller
{
    public function index()
{
    $user = Auth::user();

    if (!$user || !$user->kode_prodi) {
        abort(403);
    }

    $kodeProdi = $user->kode_prodi;
    $id_tahun = request()->get('id_tahun');
    $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

    $query = DB::table('capaian_pembelajaran_mata_kuliahs as cpmk')
        ->leftJoin('cpl_cpmk', 'cpmk.id_cpmk', '=', 'cpl_cpmk.id_cpmk')
        ->leftJoin('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
        ->leftJoin('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
        ->where('cpl.kode_prodi', $kodeProdi)
        ->select('cpmk.id_cpmk', 'cpmk.kode_cpmk', 'cpmk.deskripsi_cpmk', 'prodis.nama_prodi')
        ->groupBy('cpmk.id_cpmk', 'cpmk.kode_cpmk', 'cpmk.deskripsi_cpmk', 'prodis.nama_prodi')
        ->orderBy('cpmk.kode_cpmk', 'asc');

    if ($id_tahun) {
        $query->where('cpl.id_tahun', $id_tahun);
    }

    // ✅ ubah variabel jadi cpmks
    $cpmks = $query->get();

    return view("tim.capaianpembelajaranmatakuliah.index", compact("cpmks", "id_tahun", "tahun_tersedia"));
}


    public function create()
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;

        $cpls = DB::table('capaian_profil_lulusans as cpl')
            ->where('cpl.kode_prodi', $kodeProdi)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->distinct()
            ->get();

        $mks = DB::table('mata_kuliahs as mk')
            ->where('mk.kode_prodi', $kodeProdi)
            ->select('mk.kode_mk', 'mk.nama_mk')
            ->distinct()
            ->get();

        return view('tim.capaianpembelajaranmatakuliah.create', compact('cpls', 'mks'));
    }

    public function getMKByCPL(Request $request)
    {
        $id_cpls = $request->id_cpls;

        if (empty($id_cpls) || !is_array($id_cpls)) {
            return response()->json([]);
        }

        $mks = DB::table('cpl_mk')
            ->join('mata_kuliahs as mk', 'cpl_mk.kode_mk', '=', 'mk.kode_mk')
            ->whereIn('cpl_mk.id_cpl', $id_cpls)
            ->select('mk.kode_mk', 'mk.nama_mk')
            ->distinct()
            ->get();

        return response()->json($mks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_cpmk' => 'required|string',
            'deskripsi_cpmk' => 'required|string',
            'id_cpl' => 'required|exists:capaian_profil_lulusans,id_cpl',
            'selected_mks' => 'required|array|min:1',
            'selected_mks.*' => 'exists:mata_kuliahs,kode_mk',
        ]);

        $cpmk = CapaianPembelajaranMataKuliah::create([
            'kode_cpmk' => $request->kode_cpmk,
            'deskripsi_cpmk' => $request->deskripsi_cpmk,
        ]);

        DB::table('cpl_cpmk')->insert([
            'id_cpmk' => $cpmk->id_cpmk,
            'id_cpl' => $request->id_cpl,
        ]);

        foreach ($request->selected_mks as $kode_mk) {
            DB::table('cpmk_mk')->insert([
                'id_cpmk' => $cpmk->id_cpmk,
                'kode_mk' => $kode_mk,
            ]);
        }

        return redirect()->route('tim.capaianpembelajaranmatakuliah.index')->with('sukses', 'CPMK berhasil ditambahkan.');
    }

    public function edit($id_cpmk)
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;
        $cpmk = CapaianPembelajaranMataKuliah::findOrFail($id_cpmk);

        $cpls = DB::table('capaian_profil_lulusans as cpl')
            ->where('cpl.kode_prodi', $kodeProdi)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->distinct()
            ->get();

        $mks = DB::table('mata_kuliahs as mk')
            ->where('mk.kode_prodi', $kodeProdi)
            ->select('mk.kode_mk', 'mk.nama_mk')
            ->distinct()
            ->get();

        $selectedCpls = DB::table('cpl_cpmk')->where('id_cpmk', $id_cpmk)->pluck('id_cpl')->toArray();
        $selectedMKs = DB::table('cpmk_mk')->where('id_cpmk', $id_cpmk)->pluck('kode_mk')->toArray();

        return view('tim.capaianpembelajaranmatakuliah.edit', compact('cpmk', 'cpls', 'mks', 'selectedCpls', 'selectedMKs'));
    }

    public function update(Request $request, $id_cpmk)
    {
        $request->validate([
            'kode_cpmk' => 'required|string',
            'deskripsi_cpmk' => 'required|string',
            'id_cpl' => 'required|exists:capaian_profil_lulusans,id_cpl',
            'selected_mks' => 'required|array|min:1',
            'selected_mks.*' => 'exists:mata_kuliahs,kode_mk',
        ]);

        $cpmk = CapaianPembelajaranMataKuliah::findOrFail($id_cpmk);
        $cpmk->update([
            'kode_cpmk' => $request->kode_cpmk,
            'deskripsi_cpmk' => $request->deskripsi_cpmk,
        ]);

        DB::table('cpl_cpmk')->where('id_cpmk', $id_cpmk)->delete();
        DB::table('cpl_cpmk')->insert([
            'id_cpmk' => $id_cpmk,
            'id_cpl' => $request->id_cpl,
        ]);

        DB::table('cpmk_mk')->where('id_cpmk', $id_cpmk)->delete();
        foreach ($request->selected_mks as $kode_mk) {
            DB::table('cpmk_mk')->insert([
                'id_cpmk' => $id_cpmk,
                'kode_mk' => $kode_mk,
            ]);
        }

        return redirect()->route('tim.capaianpembelajaranmatakuliah.index')->with('sukses', 'CPMK berhasil diperbarui.');
    }

    public function detail($id_cpmk)
    {
        $kodeProdi = Auth::user()->kode_prodi;

        $akses = DB::table('cpl_cpmk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
            ->where('cpl_cpmk.id_cpmk', $id_cpmk)
            ->where('cpl.kode_prodi', $kodeProdi)
            ->exists();

        if (!$akses) {
            abort(403, 'Akses ditolak');
        }

        $cpmk = CapaianPembelajaranMataKuliah::findOrFail($id_cpmk);

        $cpls = DB::table('cpl_cpmk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_cpmk.id_cpl', '=', 'cpl.id_cpl')
            ->where('cpl_cpmk.id_cpmk', $id_cpmk)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->get();

        $mks = DB::table('cpmk_mk')
            ->join('mata_kuliahs as mk', 'cpmk_mk.kode_mk', '=', 'mk.kode_mk')
            ->where('cpmk_mk.id_cpmk', $id_cpmk)
            ->select('mk.kode_mk', 'mk.nama_mk')
            ->get();

        return view('tim.capaianpembelajaranmatakuliah.detail', compact('cpmk', 'cpls', 'mks'));
    }

    public function destroy($id_cpmk)
    {
        $cpmk = CapaianPembelajaranMataKuliah::findOrFail($id_cpmk);
        $cpmk->delete();

        return redirect()->route('tim.capaianpembelajaranmatakuliah.index')->with('sukses', 'CPMK berhasil dihapus.');
    }

    public function import()
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;

        // Get CPL untuk prodi ini
        $cpls = DB::table('capaian_profil_lulusans as cpl')
            ->where('cpl.kode_prodi', $kodeProdi)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->orderBy('cpl.kode_cpl', 'asc')
            ->get();

        return view('tim.capaianpembelajaranmatakuliah.import', compact('cpls'));
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'id_cpl' => 'required|exists:capaian_profil_lulusans,id_cpl',
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            Excel::import(new CpmkImport($request->id_cpl), $request->file('file'));
            return redirect()->route('tim.capaianpembelajaranmatakuliah.index')->with('sukses', 'Data CPMK berhasil diimport dari Excel');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            return redirect()->back()->with('error', 'Import gagal: ' . implode(' | ', array_slice($errorMessages, 0, 3)))->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage())->withInput();
        }
    }

    public function downloadTemplate()
    {
        $filename = 'template_import_cpmk.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['kode_cpmk', 'deskripsi_cpmk', 'kode_mk'];
        $sampleData = [
            ['CPMK-01', 'Mahasiswa mampu memahami konsep dasar pemrograman', 'MK01; MK27; MK31'],
            ['CPMK-02', 'Mahasiswa mampu mengimplementasikan algoritma sorting', 'MK14; MK34'],
            ['CPMK-03', 'Mahasiswa mampu menganalisis kompleksitas algoritma', 'MK03'],
        ];

        $callback = function() use ($columns, $sampleData) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM untuk Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            fputcsv($file, $columns);
            
            // Sample data
            foreach ($sampleData as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
