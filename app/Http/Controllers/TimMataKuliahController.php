<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\CapaianProfilLulusan;
use App\Models\BahanKajian;
use App\Imports\MataKuliahImport;
use Maatwebsite\Excel\Facades\Excel;

class TimMataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;
        $id_tahun = $request->get('id_tahun');
        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        // Query untuk mata kuliah per prodi
        $mata_kuliahs = DB::table('mata_kuliahs as mk')
            ->leftJoin('prodis', 'mk.kode_prodi', '=', 'prodis.kode_prodi')
            ->select(
                'mk.kode_mk',
                'mk.nama_mk',
                'mk.jenis_mk',
                'mk.sks_mk',
                'mk.semester_mk',
                'mk.kompetensi_mk',
                'prodis.nama_prodi'
            )
            ->where('mk.kode_prodi', $kodeProdi)
            ->orderBy('mk.kode_mk', 'asc')
            ->get();

        $dataKosong = $mata_kuliahs->isEmpty();

        // Nama prodi untuk tampilan filter / ringkasan
        $prodi = DB::table('prodis')->where('kode_prodi', $kodeProdi)->first();
        $prodiName = $prodi->nama_prodi ?? '-';

        return view(
            'tim.matakuliah.index',
            compact('mata_kuliahs', 'id_tahun', 'tahun_tersedia', 'dataKosong', 'prodiName')
        );
    }

    public function getCplByBk(Request $request)
    {
        $id_bks = $request->id_bks ?? [];

        $cpls = DB::table('cpl_bk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_bk.id_cpl', '=', 'cpl.id_cpl')
            ->whereIn('cpl_bk.id_bk', $id_bks)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->distinct()
            ->orderBy('cpl.kode_cpl')
            ->get();

        return response()->json($cpls);
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;

        $capaianProfilLulusans = DB::table('capaian_profil_lulusans as cpl')
            ->where('cpl.kode_prodi', $kodeProdi)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->distinct()
            ->orderBy('cpl.kode_cpl', 'asc')
            ->get();

        // Get daftar dosen untuk prodi ini
        $dosens = DB::table('users')
            ->where('role', 'dosen')
            ->where('kode_prodi', $kodeProdi)
            ->where('status', 'approved')
            ->select('id', 'name', 'nip')
            ->orderBy('name')
            ->get();

        // Get tahun kurikulum
        $tahuns = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        // TEMPORARY: Test plain form tanpa Alpine
        if (request()->has('test')) {
            return view("tim.matakuliah.test-create", compact("capaianProfilLulusans"));
        }

        return view("tim.matakuliah.create", compact("capaianProfilLulusans", "dosens", "tahuns"));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || !$user->kode_prodi) {
            abort(403, 'User tidak memiliki prodi');
        }

        $request->validate([
            'kode_mk' => 'required|string|max:20|unique:mata_kuliahs,kode_mk',
            'nama_mk' => 'required|string|max:100',
            'sks_mk' => 'required|integer',
            'semester_mk' => 'required|integer|in:1,2,3,4,5,6,7,8',
            'kompetensi_mk' => 'required|string|in:pendukung,utama',
            'id_cpls' => 'required|array|min:1',
            'id_cpls.*' => 'exists:capaian_profil_lulusans,id_cpl',
            'dosen_ids' => 'nullable|array',
            'dosen_ids.*' => 'exists:users,id',
            'id_tahun' => 'required|exists:tahun,id_tahun',
        ]);

        $mk = MataKuliah::create(array_merge(
            $request->only(['kode_mk', 'nama_mk', 'sks_mk', 'semester_mk', 'kompetensi_mk']),
            ['kode_prodi' => $user->kode_prodi]
        ));

        // Simpan relasi CPL-MK
        if ($request->has('id_cpls') && is_array($request->id_cpls) && count($request->id_cpls) > 0) {
            foreach ($request->id_cpls as $id_cpl) {
                DB::table('cpl_mk')->insert([
                    'kode_mk' => $mk->kode_mk,
                    'id_cpl' => $id_cpl
                ]);
            }
        }

        // Simpan relasi Dosen-MK
        if ($request->has('dosen_ids') && is_array($request->dosen_ids) && count($request->dosen_ids) > 0) {
            foreach ($request->dosen_ids as $dosen_id) {
                DB::table('dosen_mata_kuliah')->insert([
                    'user_id' => $dosen_id,
                    'kode_mk' => $mk->kode_mk,
                    'id_tahun' => $request->id_tahun,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('tim.matakuliah.index')->with('success', 'Mata kuliah berhasil ditambahkan!');
    }

    public function edit(MataKuliah $matakuliah)
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;

        $capaianprofillulusans = DB::table('capaian_profil_lulusans as cpl')
            ->where('cpl.kode_prodi', $kodeProdi)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->distinct()
            ->orderBy('cpl.kode_cpl', 'asc')
            ->get();

        $selectedCplIds = DB::table('cpl_mk')
            ->where('cpl_mk.kode_mk', $matakuliah->kode_mk)
            ->pluck('id_cpl')
            ->toArray();

        // Get daftar dosen untuk prodi ini
        $dosens = DB::table('users')
            ->where('role', 'dosen')
            ->where('kode_prodi', $kodeProdi)
            ->where('status', 'approved')
            ->select('id', 'name', 'nip')
            ->orderBy('name')
            ->get();

        // Get dosen yang sudah ter-assign ke MK ini
        $selectedDosens = DB::table('dosen_mata_kuliah')
            ->where('kode_mk', $matakuliah->kode_mk)
            ->pluck('user_id')
            ->toArray();

        // Get tahun kurikulum
        $tahuns = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        // Get tahun yang sedang digunakan (ambil dari relasi dosen pertama jika ada)
        $currentTahun = DB::table('dosen_mata_kuliah')
            ->where('kode_mk', $matakuliah->kode_mk)
            ->value('id_tahun');

        return view('tim.matakuliah.edit', compact('matakuliah', 'capaianprofillulusans', 'selectedCplIds', 'dosens', 'selectedDosens', 'tahuns', 'currentTahun'));
    }

    public function update(Request $request, MataKuliah $matakuliah)
    {
        $request->validate([
            'kode_mk' => [
                'required',
                'string',
                'max:20',
                Rule::unique('mata_kuliahs', 'kode_mk')->ignore($matakuliah->kode_mk, 'kode_mk'),
            ],
            'nama_mk' => 'required|string|max:100',
            'sks_mk' => 'required|integer',
            'semester_mk' => 'required|integer|in:1,2,3,4,5,6,7,8',
            'kompetensi_mk' => 'required|string|in:pendukung,utama',
            'id_cpls' => 'required|array|min:1',
            'id_cpls.*' => 'exists:capaian_profil_lulusans,id_cpl',
            'dosen_ids' => 'nullable|array',
            'dosen_ids.*' => 'exists:users,id',
            'id_tahun' => 'required|exists:tahun,id_tahun',
        ]);

        $old_kode_mk = $matakuliah->kode_mk;
        $matakuliah->update(array_merge(
            $request->only(['kode_mk', 'nama_mk', 'sks_mk', 'semester_mk', 'kompetensi_mk']),
            ['kode_prodi' => Auth::user()->kode_prodi]
        ));
        $new_kode_mk = $matakuliah->kode_mk;

        // Hapus relasi CPL-MK yang lama
        DB::table('cpl_mk')->where('kode_mk', $old_kode_mk)->delete();

        // Simpan relasi CPL-MK yang baru
        if ($request->has('id_cpls') && is_array($request->id_cpls) && count($request->id_cpls) > 0) {
            foreach ($request->id_cpls as $id_cpl) {
                DB::table('cpl_mk')->insert([
                    'kode_mk' => $new_kode_mk,
                    'id_cpl' => $id_cpl
                ]);
            }
        }

        // Hapus relasi Dosen-MK yang lama
        DB::table('dosen_mata_kuliah')->where('kode_mk', $old_kode_mk)->delete();

        // Simpan relasi Dosen-MK yang baru
        if ($request->has('dosen_ids') && is_array($request->dosen_ids) && count($request->dosen_ids) > 0) {
            foreach ($request->dosen_ids as $dosen_id) {
                DB::table('dosen_mata_kuliah')->insert([
                    'user_id' => $dosen_id,
                    'kode_mk' => $new_kode_mk,
                    'id_tahun' => $request->id_tahun,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        if ($old_kode_mk !== $new_kode_mk) {
            DB::table('cpmk_mk')->where('kode_mk', $old_kode_mk)->update(['kode_mk' => $new_kode_mk]);
        }

        // Update relasi CPL-CPMK berdasarkan CPL yang dipilih
        $relatedCpmks = DB::table('cpmk_mk')->where('kode_mk', $new_kode_mk)->pluck('id_cpmk')->unique();
        DB::table('cpl_cpmk')->whereIn('id_cpmk', $relatedCpmks)->delete();

        $insertedData = [];
        foreach ($relatedCpmks as $id_cpmk) {
            foreach ($request->id_cpls as $id_cpl) {
                $insertedData[] = [
                    'id_cpmk' => $id_cpmk,
                    'id_cpl' => $id_cpl,
                ];
            }
        }

        if (!empty($insertedData)) {
            DB::table('cpl_cpmk')->insert($insertedData);
        }

        return redirect()->route('tim.matakuliah.index')->with('success', 'Matakuliah berhasil diperbarui.');
    }

    public function detail(MataKuliah $matakuliah)
    {
        $kodeProdi = Auth::user()->kode_prodi;

        $selectedCplIds = DB::table('cpl_mk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->where('cpl_mk.kode_mk', $matakuliah->kode_mk)
            ->where('cpl.kode_prodi', $kodeProdi)
            ->pluck('cpl_mk.id_cpl')
            ->toArray();

        if (empty($selectedCplIds)) {
            abort(403, 'Akses ditolak');
        }

        $capaianprofillulusans = CapaianProfilLulusan::whereIn('id_cpl', $selectedCplIds)->get();
        
        // Alias untuk view compatibility
        $selectedCPL = $selectedCplIds;
        $cplList = $capaianprofillulusans;

        $selectedBksIds = DB::table('bk_mk')
            ->where('kode_mk', $matakuliah->kode_mk)
            ->pluck('id_bk')
            ->toArray();

        $bahanKajians = BahanKajian::whereIn('id_bk', $selectedBksIds)->get();
        $selectedBK = $selectedBksIds;
        $bkList = $bahanKajians;

        return view('tim.matakuliah.detail', compact('matakuliah', 'selectedCplIds', 'selectedBksIds', 'capaianprofillulusans', 'bahanKajians', 'selectedCPL', 'cplList', 'selectedBK', 'bkList'));
    }

    public function destroy(MataKuliah $matakuliah)
    {
        $matakuliah->delete();
        return redirect()->route('tim.matakuliah.index')->with('sukses', 'matakuliah berhasil dihapus');
    }

    public function organisasi_mk(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;
        $id_tahun = $request->get('id_tahun');
        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        $query = DB::table('mata_kuliahs as mk')
            ->select(
                'mk.kode_mk',
                'mk.nama_mk',
                'mk.jenis_mk',
                'mk.sks_mk',
                'mk.semester_mk',
                'mk.kompetensi_mk',
                'prodis.nama_prodi',
                'prodis.kode_prodi'
            )
            ->leftJoin('prodis', 'mk.kode_prodi', '=', 'prodis.kode_prodi')
            ->where('mk.kode_prodi', $kodeProdi);

        if ($id_tahun) {
            $query->leftJoin('cpl_mk', 'mk.kode_mk', '=', 'cpl_mk.kode_mk')
                  ->leftJoin('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
                  ->where('cpl.id_tahun', $id_tahun);
        }

        $query->groupBy(
            'mk.kode_mk',
            'mk.nama_mk',
            'mk.jenis_mk',
            'mk.sks_mk',
            'mk.semester_mk',
            'mk.kompetensi_mk',
            'prodis.nama_prodi',
            'prodis.kode_prodi'
        );

        $matakuliah = $query->get();

        $organisasiMK = $matakuliah->groupBy('semester_mk')->map(function ($items, $semester_mk) {
            return [
                'semester_mk' => $semester_mk,
                'sks_mk' => $items->sum('sks_mk'),
                'jumlah_mk' => $items->count(),
                'nama_mk' => $items->pluck('nama_mk')->toArray(),
                'mata_kuliah' => $items,
            ];
        });

        $prodi = DB::table('prodis')->where('kode_prodi', $kodeProdi)->first();
        $prodiName = $prodi->nama_prodi ?? '-';

        return view(
            'tim.matakuliah.organisasimk',
            compact('organisasiMK', 'kodeProdi', 'id_tahun', 'tahun_tersedia', 'prodiName')
        );
    }

    public function importMataKuliah(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new MataKuliahImport(), $request->file('file'));

            return redirect()->route('tim.matakuliah.index')
                ->with('success', 'Data mata kuliah berhasil diimport!');
                
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            return redirect()->route('tim.matakuliah.index')
                ->with('error', 'Gagal import: ' . implode(' | ', array_slice($errorMessages, 0, 3)));
                
        } catch (\Exception $e) {
            return redirect()->route('tim.matakuliah.index')
                ->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function downloadTemplateMataKuliah()
    {
        $filename = 'template_import_matakuliah.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['kode_mk', 'nama_mk', 'sks_mk', 'semester_mk', 'kompetensi_mk', 'jenis_mk', 'kode_cpl'];
        $sampleData = [
            ['MK001', 'Pemrograman Web', '3', '3', 'utama', 'Wajib', 'CPL01,CPL02'],
            ['MK002', 'Basis Data', '4', '4', 'utama', 'Wajib', 'CPL03'],
            ['MK003', 'PKL (Praktik Kerja Lapangan)', '20', '7', 'utama', 'Wajib', 'CPL01'],
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
