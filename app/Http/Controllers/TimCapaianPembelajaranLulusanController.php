<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilLulusan;
use App\Models\CapaianProfilLulusan;
use App\Imports\CplImport;
use Maatwebsite\Excel\Facades\Excel;

class TimCapaianPembelajaranLulusanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->kode_prodi) {
            abort(404);
        }

        $kodeProdi = $user->kode_prodi;
        $id_tahun = $request->get('id_tahun');

        // Tahun kurikulum yang tersedia (untuk dropdown)
        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        // Query CPL hanya untuk prodi login, opsional filter tahun
        $query = DB::table('capaian_profil_lulusans as cpl')
            ->leftJoin('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->select(
                'cpl.id_cpl',
                'cpl.deskripsi_cpl',
                'cpl.kode_cpl',
                'cpl.id_tahun',
                'prodis.nama_prodi'
            )
            ->where('cpl.kode_prodi', $kodeProdi);

        if ($id_tahun) {
            $query->where('cpl.id_tahun', $id_tahun);
        }

        $capaianpembelajaranlulusans = $query
            ->orderBy('cpl.kode_cpl', 'asc')
            ->get();

        // Nama prodi untuk header/filter
        $prodiName = $capaianpembelajaranlulusans->first()->nama_prodi
            ?? optional($user->prodi)->nama_prodi
            ?? '-';

        return view("tim.capaianpembelajaranlulusan.index", compact(
            "capaianpembelajaranlulusans",
            "tahun_tersedia",
            "id_tahun",
            "prodiName"
        ));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
        $id_tahun = $request->get('id_tahun');
        $selectedYear = collect($tahun_tersedia)->firstWhere('id_tahun', $id_tahun);

        return view('tim.capaianpembelajaranlulusan.create', compact('tahun_tersedia', 'selectedYear', 'id_tahun'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'kode_cpl' => 'required',
            'deskripsi_cpl' => 'required',
            'id_tahun' => 'required|exists:tahun,id_tahun',
        ]);

        $cpl = CapaianProfilLulusan::create([
            'kode_cpl' => $request->kode_cpl,
            'deskripsi_cpl' => $request->deskripsi_cpl,
            'kode_prodi' => $user->kode_prodi,
            'id_tahun' => $request->id_tahun,
        ]);

        return redirect()->route('tim.capaianpembelajaranlulusan.index')->with('sukses', 'Capaian Pembelajaran Lulusan berhasil ditambahkan.');
    }

    public function edit(CapaianProfilLulusan $id_cpl)
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        // Check access: hanya bisa edit CPL dari prodi sendiri
        if ($id_cpl->kode_prodi !== $user->kode_prodi) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit CPL ini.');
        }

        return view('tim.capaianpembelajaranlulusan.edit', compact('id_cpl'));
    }

    public function update(Request $request, CapaianProfilLulusan $id_cpl)
    {
        // Struktur baru tidak lagi memakai relasi CPL-PL di tabel cpl_pl.
        // Admin prodi hanya mengubah kode, deskripsi, dan status CPL.
        $request->validate([
            'kode_cpl'      => 'required',
            'deskripsi_cpl' => 'required',
            'status_cpl'    => 'nullable|in:Kompetensi Utama Bidang,Kompetensi Tambahan',
        ]);

        $id_cpl->update([
            'kode_cpl'      => $request->kode_cpl,
            'deskripsi_cpl' => $request->deskripsi_cpl,
            'status_cpl'    => $request->status_cpl,
        ]);

        return redirect()
            ->route('tim.capaianpembelajaranlulusan.index')
            ->with('sukses', 'Capaian Pembelajaran Lulusan berhasil diperbarui.');
    }

    public function detail(CapaianProfilLulusan $id_cpl)
    {
        $kodeProdi = Auth::user()->kode_prodi;

        // Check access: hanya bisa lihat CPL dari prodi sendiri
        if ($id_cpl->kode_prodi !== $kodeProdi) {
            abort(403, 'Akses ditolak');
        }

        return view('tim.capaianpembelajaranlulusan.detail', compact('id_cpl'));
    }

    public function destroy(CapaianProfilLulusan $id_cpl)
    {
        $id_cpl->delete();
        return redirect()->route('tim.capaianpembelajaranlulusan.index')->with('sukses', 'Capaian Pembelajaran lulusan berhasil dihapus.');
    }

    public function import()
    {
        return view('tim.capaianpembelajaranlulusan.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            Excel::import(new CplImport, $request->file('file'));
            return redirect()->route('tim.capaianpembelajaranlulusan.index')->with('sukses', 'Data CPL berhasil diimport dari Excel');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return redirect()->back()->with('error', 'Import gagal. Silakan cek format Excel Anda.')->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage())->withInput();
        }
    }

    public function downloadTemplate()
    {
        $filename = 'template_import_cpl.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['kode_cpl', 'deskripsi_cpl'];
        $sampleData = [
            ['CPL-01', 'Mampu menerapkan pemikiran logis, kritis, inovatif dalam konteks pengembangan atau implementasi ilmu pengetahuan dan teknologi'],
            ['CPL-02', 'Mampu menunjukkan kinerja mandiri, bermutu dan terukur'],
            ['CPL-03', 'Mampu mengkaji implikasi pengembangan atau implementasi ilmu pengetahuan dan teknologi'],
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

    public function pemenuhan_cpl()
    {
        $user = Auth::user();

        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;
        $id_tahun = request()->get('id_tahun');
        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        $query = DB::table('capaian_profil_lulusans as cpl')
            ->join('cpl_pl as cplpl', 'cpl.id_cpl', '=', 'cplpl.id_cpl')
            ->join('profil_lulusans as pl', 'cplpl.id_pl', '=', 'pl.id_pl')
            ->join('prodis as ps', 'pl.kode_prodi', '=', 'ps.kode_prodi')
            ->leftJoin('cpl_mk as cmk', 'cpl.id_cpl', '=', 'cmk.id_cpl')
            ->leftJoin('mata_kuliahs as mk', 'cmk.kode_mk', '=', 'mk.kode_mk')
            ->where('ps.kode_prodi', $kodeProdi)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'deskripsi_cpl', 'ps.nama_prodi', 'mk.semester_mk', 'mk.kode_mk', 'mk.nama_mk', 'ps.kode_prodi')
            ->distinct();

        if ($id_tahun) {
            $query->where('pl.id_tahun', $id_tahun);
        }

        $data = $query
            ->orderBy('cpl.kode_cpl', 'asc')
            ->orderBy('mk.semester_mk', 'asc')
            ->get();

        $petaCPL = [];

        foreach ($data as $row) {
            $semester = 'Semester ' . $row->semester_mk;
            $namamk = $row->nama_mk;

            $petaCPL[$row->id_cpl]['label'] = $row->kode_cpl;
            $petaCPL[$row->id_cpl]['deskripsi_cpl'] = $row->deskripsi_cpl;
            $petaCPL[$row->id_cpl]['prodi'] = $row->nama_prodi;
            $petaCPL[$row->id_cpl]['semester'][$semester][] = $namamk;
        }

        return view('tim.pemenuhancpl.index', compact('petaCPL', 'id_tahun', 'tahun_tersedia'));
    }
}
