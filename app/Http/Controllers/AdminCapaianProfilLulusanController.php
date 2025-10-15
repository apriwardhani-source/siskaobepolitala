<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CapaianProfilLulusan;
use App\Models\ProfilLulusan;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

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

        $profilLulusans = DB::table('profil_lulusans')
            ->join('prodis', 'profil_lulusans.kode_prodi', '=', 'prodis.kode_prodi')
            ->join('tahun', 'profil_lulusans.id_tahun', '=', 'tahun.id_tahun')
            ->select('profil_lulusans.id_pl', 'profil_lulusans.kode_pl', 'profil_lulusans.deskripsi_pl', 'prodis.nama_prodi', 'tahun.tahun')
            ->orderBy('prodis.nama_prodi')
            ->get();
            
        $selectedProfilLulusans = DB::table('cpl_pl')
            ->where('id_cpl', $id_cpl)
            ->pluck('id_pl')
            ->toArray();
        return view('admin.capaianprofillulusan.edit', compact('capaianprofillulusan', 'profilLulusans', 'selectedProfilLulusans'));
    }

    public function update(Request $request, $id_cpl)
    {
        request()->validate([
            'kode_cpl' => 'required|string|max:10',
            'deskripsi_cpl' => 'required',
            'status_cpl' => 'required|in:Kompetensi Utama Bidang,Kompetensi Tambahan'
        ]);

        $capaianprofillulusan = CapaianProfilLulusan::findOrFail($id_cpl);

        $capaianprofillulusan->update($request->all());

        DB::table('cpl_pl')->where('id_cpl', $id_cpl)->delete();

        DB::table('cpl_pl')->insert([
            'id_cpl' => $capaianprofillulusan->id_cpl,
            'id_pl' => $request->id_pls
        ]);

        return redirect()->route('admin.capaianprofillulusan.index')->with('success', 'Capaian Profil lulusan berhasil diperbaharui.');
    }

    public function detail(CapaianProfilLulusan $id_cpl)
    {
        $selectedPlIds = DB::table('cpl_pl')
            ->where('id_cpl', $id_cpl->id_cpl)
            ->pluck('id_pl')
            ->toArray();

        $profilLulusans = ProfilLulusan::whereIn('id_pl', $selectedPlIds)->get();

        return view('admin.capaianprofillulusan.detail', [
            'id_cpl' => $id_cpl,
            'selectedProfilLulusans' => $selectedPlIds,
            'profilLulusans' => $profilLulusans
        ]);
    }

    public function destroy(CapaianProfilLulusan $id_cpl)
    {
        $id_cpl->delete();
        return redirect()->route('admin.capaianprofillulusan.index')->with('sukses', 'Capaian Profil Lulusan Ini Berhasil Di Hapus');
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

        $query = DB::table('capaian_profil_lulusans as cpl')
            ->join('cpl_pl as cplpl', 'cpl.id_cpl', '=', 'cplpl.id_cpl')
            ->join('profil_lulusans as pl', 'cplpl.id_pl', '=', 'pl.id_pl')
            ->Join('tahun', 'pl.id_tahun', '=', 'tahun.id_tahun')
            ->join('prodis as ps', 'pl.kode_prodi', '=', 'ps.kode_prodi')
            ->leftJoin('cpl_mk as cmk', 'cpl.id_cpl', '=', 'cmk.id_cpl')
            ->leftJoin('mata_kuliahs as mk', 'cmk.kode_mk', '=', 'mk.kode_mk')
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'mk.semester_mk', 'mk.kode_mk', 'mk.nama_mk', 'ps.kode_prodi', 'tahun.tahun', 'ps.nama_prodi')
            ->distinct();

        if ($kode_prodi) {
            $query->where('ps.kode_prodi', $kode_prodi);
        }

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

            $petaCPL[$row->id_cpl]['label'] = $row->kode_cpl; // yang ditampilkan
            $petaCPL[$row->id_cpl]['semester'][$semester][] = $namamk; // pengelompokan tetap pakai id
        }

        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        $dataKosong = $data->isEmpty() && $kode_prodi;

        return view('admin.pemenuhancpl.index', compact('petaCPL', 'prodis', 'kode_prodi', 'id_tahun', 'tahun_tersedia', 'dataKosong'));
    }
}
