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
                'mk.sks_mk',
                'mk.semester_mk',
                'mk.kompetensi_mk',
                'prodis.nama_prodi'
            )
            ->where('mk.kode_prodi', $kodeProdi)
            ->orderBy('mk.kode_mk', 'asc')
            ->get();

        return view("tim.matakuliah.index", compact("mata_kuliahs", "id_tahun", "tahun_tersedia"));
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

        return view("tim.matakuliah.create", compact("capaianProfilLulusans"));
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

        return view('tim.matakuliah.edit', compact('matakuliah', 'capaianprofillulusans', 'selectedCplIds'));
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
            ->join('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->join('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->where('cpl_mk.kode_mk', $matakuliah->kode_mk)
            ->where('pl.kode_prodi', $kodeProdi)
            ->pluck('cpl_mk.id_cpl')
            ->toArray();

        if (empty($selectedCplIds)) {
            abort(403, 'Akses ditolak');
        }

        $capaianprofillulusans = CapaianProfilLulusan::whereIn('id_cpl', $selectedCplIds)->get();

        $selectedBksIds = DB::table('bk_mk')
            ->where('kode_mk', $matakuliah->kode_mk)
            ->pluck('id_bk')
            ->toArray();

        $bahanKajians = BahanKajian::whereIn('id_bk', $selectedBksIds)->get();

        return view('tim.matakuliah.detail', compact('matakuliah', 'selectedCplIds', 'selectedBksIds', 'capaianprofillulusans', 'bahanKajians'));
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
            ->leftJoin('cpl_mk', 'mk.kode_mk', '=', 'cpl_mk.kode_mk')
            ->leftJoin('capaian_profil_lulusans as cpl', 'cpl_mk.id_cpl', '=', 'cpl.id_cpl')
            ->leftJoin('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->leftJoin('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->leftJoin('prodis', 'pl.kode_prodi', '=', 'prodis.kode_prodi')
            ->where('pl.kode_prodi', $kodeProdi);

        if ($id_tahun) {
            $query->where('pl.id_tahun', $id_tahun);
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

        return view('tim.matakuliah.organisasimk', compact('organisasiMK', 'kodeProdi', 'id_tahun', 'tahun_tersedia'));
    }
}
