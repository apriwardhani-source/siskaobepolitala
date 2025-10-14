<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BahanKajian;
use App\Models\CapaianProfilLulusan;

class TimBahanKajianController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->kode_prodi) {
            abort(404);
        }

        $kodeProdi = $user->kode_prodi;
        $id_tahun = $request->get('id_tahun');

        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
        $query = DB::table('bahan_kajians as bk')
            ->select(
                'bk.id_bk',
                'bk.nama_bk',
                'bk.kode_bk',
                'bk.deskripsi_bk',
                'bk.referensi_bk',
                'bk.status_bk',
                'bk.knowledge_area',
                'prodis.nama_prodi'
            )
            ->leftJoin('cpl_bk', 'bk.id_bk', '=', 'cpl_bk.id_bk')
            ->leftJoin('capaian_profil_lulusans as cpl', 'cpl_bk.id_cpl', '=', 'cpl.id_cpl')
            ->leftJoin('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->leftJoin('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->leftJoin('prodis', 'pl.kode_prodi', '=', 'prodis.kode_prodi')
            ->where('pl.kode_prodi', $kodeProdi)
            ->groupBy(
                'bk.id_bk',
                'bk.nama_bk',
                'bk.kode_bk',
                'bk.deskripsi_bk',
                'bk.referensi_bk',
                'bk.status_bk',
                'bk.knowledge_area',
                'prodis.nama_prodi',
            )
            ->orderBy('bk.kode_bk', 'asc');

        if ($id_tahun) {
            $query->where('pl.id_tahun', $id_tahun);
        }
        $bahankajians = $query->get();

        return view('tim.bahankajian.index', compact('bahankajians', 'id_tahun', 'tahun_tersedia'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;

        $capaianprofillulusans = DB::table('capaian_profil_lulusans as cpl')
            ->join('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->join('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->where('pl.kode_prodi', $kodeProdi)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->distinct()
            ->get();

        return view('tim.bahankajian.create', compact('capaianprofillulusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_bk' => 'required',
            'nama_bk' => 'required',
            'id_cpl' => 'required|array',
        ]);

        $bk = BahanKajian::create([
            'kode_bk' => $request->kode_bk,
            'nama_bk' => $request->nama_bk,
            'deskripsi_bk' => $request->deskripsi_bk,
            'referensi_bk' => $request->referensi_bk,
            'knowledge_area' => $request->knowledge_area,
            'status_bk' => $request->status_bk ?? 'active',
        ]);

        if ($request->has('id_cpl')) {
            foreach ($request->id_cpl as $id_cpl) {
                DB::table('cpl_bk')->insert([
                    'id_cpl' => $id_cpl,
                    'id_bk' => $bk->id_bk,
                ]);
            }
        }

        return redirect()->route('tim.bahankajian.index')->with('sukses', 'Bahan Kajian berhasil ditambahkan.');
    }

    public function edit($id_bk)
    {
        $user = Auth::user();
        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $kodeProdi = $user->kode_prodi;
        $bk = BahanKajian::findOrFail($id_bk);

        $capaianprofillulusans = DB::table('capaian_profil_lulusans as cpl')
            ->join('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->join('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->where('pl.kode_prodi', $kodeProdi)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl')
            ->distinct()
            ->get();

        $selectedCapaianProfilLulusans = DB::table('cpl_bk')->where('id_bk', $bk->id_bk)->pluck('id_cpl')->toArray();

        return view('tim.bahankajian.edit', compact('bk', 'capaianprofillulusans', 'selectedCapaianProfilLulusans'));
    }

    public function update(Request $request, $id_bk)
    {
        $request->validate([
            'kode_bk' => 'required',
            'nama_bk' => 'required',
            'id_cpl' => 'required|array',
        ]);

        $bk = BahanKajian::findOrFail($id_bk);
        $bk->update([
            'kode_bk' => $request->kode_bk,
            'nama_bk' => $request->nama_bk,
            'deskripsi_bk' => $request->deskripsi_bk,
            'referensi_bk' => $request->referensi_bk,
            'knowledge_area' => $request->knowledge_area,
            'status_bk' => $request->status_bk ?? 'active',
        ]);

        DB::table('cpl_bk')->where('id_bk', $bk->id_bk)->delete();

        if ($request->has('id_cpl')) {
            foreach ($request->id_cpl as $id_cpl) {
                DB::table('cpl_bk')->insert([
                    'id_cpl' => $id_cpl,
                    'id_bk' => $bk->id_bk,
                ]);
            }
        }

        return redirect()->route('tim.bahankajian.index')->with('sukses', 'Bahan Kajian berhasil diperbarui.');
    }

    public function detail($id_bk)
    {
        $bk = BahanKajian::findOrFail($id_bk);

        $kodeProdi = Auth::user()->kode_prodi;

        $akses = DB::table('cpl_bk')
            ->join('capaian_profil_lulusans as cpl', 'cpl_bk.id_cpl', '=', 'cpl.id_cpl')
            ->join('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->join('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->join('prodis', 'pl.kode_prodi', '=', 'prodis.kode_prodi')
            ->where('cpl_bk.id_bk', $bk->id_bk)
            ->where('prodis.kode_prodi', $kodeProdi)
            ->exists();

        if (!$akses) {
            abort(403, 'Akses ditolak');
        }

        $selectedCapaianProfilLulusans = DB::table('cpl_bk')
            ->where('id_bk', $bk->id_bk)
            ->pluck('id_cpl')
            ->toArray();

        $capaianprofillulusans = CapaianProfilLulusan::whereIn('id_cpl', $selectedCapaianProfilLulusans)->get();

        return view('tim.bahankajian.detail', compact('bk', 'capaianprofillulusans', 'selectedCapaianProfilLulusans'));
    }

    public function destroy($id_bk)
    {
        $bk = BahanKajian::findOrFail($id_bk);
        $bk->delete();

        return redirect()->route('tim.bahankajian.index')->with('sukses', 'Bahan Kajian berhasil dihapus.');
    }
}
