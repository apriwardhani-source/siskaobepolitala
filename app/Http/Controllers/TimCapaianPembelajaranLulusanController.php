<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilLulusan;
use App\Models\CapaianProfilLulusan;

class TimCapaianPembelajaranLulusanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->kode_prodi) {
            abort(404);
        }

        $kodeProdi = $user->kode_prodi;

        $capaianpembelajaranlulusans = DB::table('capaian_profil_lulusans')
            ->leftJoin('prodis', 'capaian_profil_lulusans.kode_prodi', '=', 'prodis.kode_prodi')
            ->select(
                'capaian_profil_lulusans.id_cpl',
                'capaian_profil_lulusans.deskripsi_cpl',
                'capaian_profil_lulusans.kode_cpl',
                'prodis.nama_prodi'
            )
            ->where('capaian_profil_lulusans.kode_prodi', $kodeProdi)
            ->orderBy('capaian_profil_lulusans.kode_cpl', 'asc')
            ->get();

        return view("tim.capaianpembelajaranlulusan.index", compact("capaianpembelajaranlulusans"));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;
        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        return view('tim.capaianpembelajaranlulusan.create', compact('tahun_tersedia'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'kode_cpl' => 'required',
            'deskripsi_cpl' => 'required',
        ]);

        $cpl = CapaianProfilLulusan::create([
            'kode_cpl' => $request->kode_cpl,
            'deskripsi_cpl' => $request->deskripsi_cpl,
            'kode_prodi' => $user->kode_prodi,
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
        $request->validate([
            'kode_cpl' => 'required',
            'deskripsi_cpl' => 'required',
            'id_pl' => 'required|array',
        ]);

        $id_cpl->update([
            'kode_cpl' => $request->kode_cpl,
            'deskripsi_cpl' => $request->deskripsi_cpl,
            'status_cpl' => $request->status_cpl ?? 'active',
        ]);

        DB::table('cpl_pl')->where('id_cpl', $id_cpl->id_cpl)->delete();

        if ($request->has('id_pl')) {
            foreach ($request->id_pl as $id_pl) {
                DB::table('cpl_pl')->insert([
                    'id_cpl' => $id_cpl->id_cpl,
                    'id_pl' => $id_pl,
                ]);
            }
        }

        return redirect()->route('tim.capaianpembelajaranlulusan.index')->with('sukses', 'Capaian Pembelajaran Lulusan berhasil diperbarui.');
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
