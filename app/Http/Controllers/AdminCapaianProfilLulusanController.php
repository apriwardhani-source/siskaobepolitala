<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CapaianProfilLulusan;
use App\Models\ProfilLulusan;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Imports\CplImport;
use Maatwebsite\Excel\Facades\Excel;

class AdminCapaianProfilLulusanController extends Controller
{
    public function index(Request $request)
    {
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');
        $prodis = DB::table('prodis')->get();

        if (!$kode_prodi) {
            $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
            return view("admin.capaianprofillulusan.index", compact("prodis", "kode_prodi", "id_tahun", "tahun_tersedia"));
        }

        // Query dengan struktur baru: CPL langsung punya kode_prodi dan id_tahun
        $query = DB::table('capaian_profil_lulusans as cpl')
            ->leftJoin('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->leftJoin('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl', 'cpl.status_cpl', 'prodis.nama_prodi', 'tahun.tahun')
            ->orderBy('cpl.kode_cpl', 'asc');

        if ($kode_prodi) {
            $query->where('cpl.kode_prodi', $kode_prodi);
        }

        if ($id_tahun) {
            $query->where('cpl.id_tahun', $id_tahun);
        }

        $capaianprofillulusans = $query->get();
        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
        $dataKosong = $capaianprofillulusans->isEmpty() && $kode_prodi;

        return view("admin.capaianprofillulusan.index", compact("capaianprofillulusans", "prodis", "kode_prodi", "id_tahun", "tahun_tersedia", "dataKosong"));
    }

    public function create()
    {
        // Struktur baru: Tidak perlu PL lagi, langsung pilih prodi dan tahun
        $prodis = DB::table('prodis')->orderBy('nama_prodi')->get();
        $tahuns = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
        return view("admin.capaianprofillulusan.create", compact('prodis', 'tahuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_cpl' => 'required|string|max:10|unique:capaian_profil_lulusans,kode_cpl',
            'deskripsi_cpl' => 'required',
            'status_cpl' => 'required|in:Kompetensi Utama Bidang,Kompetensi Tambahan',
            'kode_prodi' => 'required|exists:prodis,kode_prodi',
            'id_tahun' => 'required|exists:tahun,id_tahun'
        ]);

        // Struktur baru: CPL langsung simpan dengan kode_prodi dan id_tahun
        CapaianProfilLulusan::create($request->only(['kode_cpl', 'deskripsi_cpl', 'status_cpl', 'kode_prodi', 'id_tahun']));

        return redirect()->route('admin.capaianprofillulusan.index')->with('success', 'Capaian Profil Lulusan berhasil ditambahkan.');
    }


    public function edit($id_cpl)
    {
        $capaianprofillulusan = CapaianProfilLulusan::findOrFail($id_cpl);
        $prodis = DB::table('prodis')->orderBy('nama_prodi')->get();
        $tahuns = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
        
        return view('admin.capaianprofillulusan.edit', compact('capaianprofillulusan', 'prodis', 'tahuns'));
    }

    public function update(Request $request, $id_cpl)
    {
        $request->validate([
            'kode_cpl' => [
                'required',
                'string',
                'max:10',
                Rule::unique('capaian_profil_lulusans', 'kode_cpl')->ignore($id_cpl, 'id_cpl'),
            ],
            'deskripsi_cpl' => 'required',
            'status_cpl' => 'required|in:Kompetensi Utama Bidang,Kompetensi Tambahan',
            'kode_prodi' => 'required|exists:prodis,kode_prodi',
            'id_tahun' => 'required|exists:tahun,id_tahun'
        ]);

        $capaianprofillulusan = CapaianProfilLulusan::findOrFail($id_cpl);
        $capaianprofillulusan->update($request->only(['kode_cpl', 'deskripsi_cpl', 'status_cpl', 'kode_prodi', 'id_tahun']));

        return redirect()->route('admin.capaianprofillulusan.index')->with('success', 'Capaian Profil Lulusan berhasil diperbarui.');
    }

    public function detail($id_cpl)
    {
        $capaianprofillulusan = DB::table('capaian_profil_lulusans as cpl')
            ->leftJoin('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->leftJoin('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->where('cpl.id_cpl', $id_cpl)
            ->select('cpl.*', 'prodis.nama_prodi', 'tahun.tahun')
            ->first();

        return view('admin.capaianprofillulusan.detail', compact('capaianprofillulusan'));
    }

    public function destroy(CapaianProfilLulusan $id_cpl)
    {
        $id_cpl->delete();
        return redirect()->route('admin.capaianprofillulusan.index')->with('sukses', 'Capaian Profil Lulusan Ini Berhasil Di Hapus');
    }

    public function import()
    {
        return view('admin.capaianprofillulusan.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            Excel::import(new CplImport, $request->file('file'));
            return redirect()->route('admin.capaianprofillulusan.index')->with('success', 'Data CPL berhasil diimport dari Excel');
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

    public function peta_pemenuhan_cpl(Request $request)
    {
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');
        $prodis = DB::table('prodis')->get();
        if (!$kode_prodi) {
            $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
            return view("admin.pemenuhancpl.index", compact("prodis", "kode_prodi", "id_tahun", "tahun_tersedia"));
        }

        // Query struktur baru: CPL langsung punya kode_prodi dan id_tahun
        $query = DB::table('capaian_profil_lulusans as cpl')
            ->join('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->join('prodis as ps', 'cpl.kode_prodi', '=', 'ps.kode_prodi')
            ->leftJoin('cpl_mk as cmk', 'cpl.id_cpl', '=', 'cmk.id_cpl')
            ->leftJoin('mata_kuliahs as mk', 'cmk.kode_mk', '=', 'mk.kode_mk')
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'mk.semester_mk', 'mk.kode_mk', 'mk.nama_mk', 'ps.kode_prodi', 'tahun.tahun', 'ps.nama_prodi')
            ->distinct();

        if ($kode_prodi) {
            $query->where('cpl.kode_prodi', $kode_prodi);
        }

        if ($id_tahun) {
            $query->where('cpl.id_tahun', $id_tahun);
        }

        $data = $query
            ->orderBy('cpl.kode_cpl', 'asc')
            ->orderBy('mk.semester_mk', 'asc')
            ->get();

        $petaCPL = [];

        foreach ($data as $row) {
            $semester = 'Semester ' . $row->semester_mk;
            $namamk = $row->nama_mk;

            $petaCPL[$row->id_cpl]['label'] = $row->kode_cpl; // yang ditampilkan
            $petaCPL[$row->id_cpl]['semester'][$semester][] = $namamk; // pengelompokan tetap pakai id
        }

        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        $dataKosong = $data->isEmpty() && $kode_prodi;

        return view('admin.pemenuhancpl.index', compact('petaCPL', 'prodis', 'kode_prodi', 'id_tahun', 'tahun_tersedia', 'dataKosong'));
    }
}
