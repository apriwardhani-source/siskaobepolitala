<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\CapaianProfilLulusan;
use App\Models\BahanKajian;

class AdminMataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');
        $prodis = DB::table('prodis')->get();

        if (!$kode_prodi) {
            $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
            return view("admin.matakuliah.index", compact("prodis", "kode_prodi", "id_tahun", "tahun_tersedia"));
        }

        $query = DB::table('mata_kuliahs as mk')
            ->select(
                'mk.kode_mk',
                'mk.nama_mk',
                'mk.jenis_mk',
                'mk.sks_mk',
                'mk.semester_mk',
                'mk.kompetensi_mk',
                'prodis.nama_prodi',
                'tahun.tahun'
            )
            ->leftJoin('cpl_mk', 'mk.kode_mk', '=', 'cpl_mk.kode_mk')
            ->leftJoin('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->leftJoin('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->leftJoin('prodis', 'mk.kode_prodi', '=', 'prodis.kode_prodi')
            ->groupBy('mk.kode_mk', 'mk.nama_mk', 'mk.jenis_mk', 'mk.sks_mk', 'mk.semester_mk', 'mk.kompetensi_mk', 'prodis.nama_prodi', 'tahun.tahun');

        if ($kode_prodi) {
            $query->where('mk.kode_prodi', $kode_prodi);
        }

        if ($id_tahun) {
            $query->where('cpl.id_tahun', $id_tahun);
        }

        $mata_kuliahs = $query->get();

        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        $dataKosong = $mata_kuliahs->isEmpty() && $kode_prodi;

        return view("admin.matakuliah.index", compact("mata_kuliahs", 'kode_prodi', 'prodis', 'id_tahun', 'tahun_tersedia', 'dataKosong'));
    }

    // Method ini sudah tidak dipakai karena BK (Bahan Kajian) sudah dihapus
    // CPL sekarang dipilih langsung saat create/edit Mata Kuliah

    public function create()
    {
        $capaianProfilLulusans = CapaianProfilLulusan::orderBy('kode_cpl', 'asc')->get();
        $prodis = DB::table('prodis')->orderBy('nama_prodi')->get();
        $tahuns = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
        
        // Get daftar dosen
        $dosens = DB::table('users')
            ->where('role', 'dosen')
            ->where('status', 'approved')
            ->select('id', 'name', 'nip', 'kode_prodi')
            ->orderBy('name')
            ->get();

        return view("admin.matakuliah.create", compact("capaianProfilLulusans", "prodis", "tahuns", "dosens"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mk' => 'required|string|max:20|unique:mata_kuliahs,kode_mk',
            'nama_mk' => 'required|string|max:100',
            'jenis_mk' => 'required|string|max:100',
            'sks_mk' => 'required|integer|min:1|max:24',
            'semester_mk' => 'required|integer|in:1,2,3,4,5,6,7,8',
            'kompetensi_mk' => 'required|string|in:pendukung,utama',
            'kode_prodi' => 'required|exists:prodis,kode_prodi',
            'id_cpls' => 'array',
            'id_cpls.*' => 'exists:capaian_profil_lulusans,id_cpl'
        ]);

        $mk = MataKuliah::create($request->only(['kode_mk', 'nama_mk', 'jenis_mk', 'sks_mk', 'semester_mk', 'kompetensi_mk', 'kode_prodi']));

        // Insert CPL yang dipilih ke tabel cpl_mk (jika ada)
        if ($request->has('id_cpls') && is_array($request->id_cpls)) {
            foreach ($request->id_cpls as $id_cpl) {
                DB::table('cpl_mk')->insert([
                    'kode_mk' => $mk->kode_mk,
                    'id_cpl' => $id_cpl
                ]);
            }
        }

        return redirect()->route('admin.matakuliah.index')->with('success', 'Mata kuliah berhasil ditambahkan!');
    }

    public function edit(MataKuliah $matakuliah)
    {
        $capaianProfilLulusans = CapaianProfilLulusan::orderBy('kode_cpl', 'asc')->get();
        $prodis = DB::table('prodis')->orderBy('nama_prodi')->get();
        $tahuns = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
        
        $selectedCpls = DB::table('cpl_mk')
            ->where('cpl_mk.kode_mk', $matakuliah->kode_mk)
            ->pluck('id_cpl')
            ->toArray();
        
        // Get daftar dosen
        $dosens = DB::table('users')
            ->where('role', 'dosen')
            ->where('status', 'approved')
            ->select('id', 'name', 'nip', 'kode_prodi')
            ->orderBy('name')
            ->get();

        return view('admin.matakuliah.edit', compact('matakuliah', 'capaianProfilLulusans', 'prodis', 'tahuns', 'selectedCpls', 'dosens'));
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
            'jenis_mk' => 'required|string|max:100',
            'sks_mk' => 'required|integer|min:1|max:24',
            'semester_mk' => 'required|integer|in:1,2,3,4,5,6,7,8',
            'kompetensi_mk' => 'required|string|in:pendukung,utama',
            'kode_prodi' => 'required|exists:prodis,kode_prodi',
            'id_cpls' => 'array',
            'id_cpls.*' => 'exists:capaian_profil_lulusans,id_cpl'
        ]);

        $old_kode_mk = $matakuliah->kode_mk;

        // Update data dasar mata kuliah
        $matakuliah->update($request->only([
            'kode_mk',
            'nama_mk',
            'jenis_mk',
            'sks_mk',
            'semester_mk',
            'kompetensi_mk',
            'kode_prodi'
        ]));

        $new_kode_mk = $matakuliah->kode_mk;

        // Hapus dan isi ulang cpl_mk
        DB::table('cpl_mk')->where('kode_mk', $old_kode_mk)->delete();

        if ($request->has('id_cpls') && is_array($request->id_cpls)) {
            foreach ($request->id_cpls as $id_cpl) {
                DB::table('cpl_mk')->insert([
                    'kode_mk' => $new_kode_mk,
                    'id_cpl' => $id_cpl
                ]);
            }
        }

        // Update kode_mk di cpmk_mk jika kode MK berubah
        if ($old_kode_mk !== $new_kode_mk) {
            DB::table('cpmk_mk')->where('kode_mk', $old_kode_mk)->update([
                'kode_mk' => $new_kode_mk
            ]);
        }

        return redirect()->route('admin.matakuliah.index')->with('success', 'Mata Kuliah berhasil diperbarui.');
    }

    public function detail(MataKuliah $matakuliah)
    {
        $selectedCplIds = DB::table('cpl_mk')
            ->where('kode_mk', $matakuliah->kode_mk)
            ->pluck('id_cpl')
            ->toArray();

        $capaianprofillulusans = CapaianProfilLulusan::whereIn('id_cpl', $selectedCplIds)->get();

        return view('admin.matakuliah.detail', [
            'matakuliah' => $matakuliah, 
            'selectedCplIds' => $selectedCplIds, 
            'capaianprofillulusans' => $capaianprofillulusans
        ]);
    }

    public function destroy(MataKuliah $matakuliah)
    {
        $matakuliah->delete();
        return redirect()->route('admin.matakuliah.index')->with('sukses', 'matakuliah berhasil dihapus');
    }

    public function organisasi_mk(Request $request)
    {
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');
        $prodis = DB::table('prodis')->get();

        if (!$kode_prodi) {
            $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
            return view("admin.matakuliah.organisasimk", compact("prodis", "kode_prodi", "id_tahun", "tahun_tersedia"));
        }

        $query = DB::table('mata_kuliahs as mk')
            ->select(
                'mk.kode_mk',
                'mk.nama_mk',
                'mk.jenis_mk',
                'mk.sks_mk',
                'mk.semester_mk',
                'mk.kompetensi_mk',
                'prodis.nama_prodi',
                'prodis.kode_prodi',
                'tahun.tahun',
            )
            ->leftJoin('cpl_mk', 'mk.kode_mk', '=', 'cpl_mk.kode_mk')
            ->leftJoin('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->leftJoin('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->leftJoin('prodis', 'mk.kode_prodi', '=', 'prodis.kode_prodi')
            ->groupBy(
                'mk.kode_mk',
                'mk.nama_mk',
                'mk.sks_mk',
                'mk.semester_mk',
                'mk.kompetensi_mk',
                'prodis.nama_prodi',
                'prodis.kode_prodi',
                'tahun.tahun'
            );

        if ($kode_prodi) {
            $query->where('mk.kode_prodi', $kode_prodi);
        }

        if ($id_tahun) {
            $query->where('cpl.id_tahun', $id_tahun);
        }

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

        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        $dataKosong = $matakuliah->isEmpty() && $kode_prodi;

        return view('admin.matakuliah.organisasimk', compact('organisasiMK', 'prodis', 'kode_prodi', 'id_tahun', 'tahun_tersedia', 'dataKosong'));
    }
}
