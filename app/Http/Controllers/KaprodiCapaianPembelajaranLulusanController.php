<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilLulusan;
use App\Models\CapaianProfilLulusan;

class KaprodiCapaianPembelajaranLulusanController extends Controller
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

        $query = DB::table('capaian_profil_lulusans')
            ->leftJoin('cpl_pl', 'capaian_profil_lulusans.id_cpl', '=', 'cpl_pl.id_cpl')
            ->leftJoin('profil_lulusans', 'cpl_pl.id_pl', '=', 'profil_lulusans.id_pl')
            ->leftJoin('prodis', 'profil_lulusans.kode_prodi', '=', 'prodis.kode_prodi')
            ->select(
                'capaian_profil_lulusans.id_cpl',
                'capaian_profil_lulusans.deskripsi_cpl',
                'capaian_profil_lulusans.kode_cpl',
                'capaian_profil_lulusans.status_cpl',
                'prodis.nama_prodi'
            )
            ->where('profil_lulusans.kode_prodi', $kodeProdi)
            ->groupBy(
                'capaian_profil_lulusans.id_cpl',
                'capaian_profil_lulusans.deskripsi_cpl',
                'capaian_profil_lulusans.kode_cpl',
                'capaian_profil_lulusans.status_cpl',
                'prodis.nama_prodi'
            )
            ->orderBy('capaian_profil_lulusans.kode_cpl', 'asc');

        if ($id_tahun) {
            $query->where('profil_lulusans.id_tahun', $id_tahun);
        }

        $capaianpembelajaranlulusans = $query->get();

        return view("kaprodi.capaianpembelajaranlulusan.index", compact("capaianpembelajaranlulusans", "id_tahun", "tahun_tersedia"));
    }

    public function detail(CapaianProfilLulusan $id_cpl)
    {
        $kodeProdi = Auth::user()->kode_prodi;

        $selectedProfilLulusans = DB::table('cpl_pl')
            ->where('id_cpl', $id_cpl->id_cpl)
            ->pluck('id_pl')
            ->toArray();

        $capaianpembelajaranlulusan = DB::table('capaian_profil_lulusans as cpl')
            ->leftJoin('cpl_pl', 'cpl.id_cpl', '=', 'cpl_pl.id_cpl')
            ->leftJoin('profil_lulusans as pl', 'cpl_pl.id_pl', '=', 'pl.id_pl')
            ->where('cpl.id_cpl', $id_cpl->id_cpl)
            ->where('pl.kode_prodi', $kodeProdi)
            ->first();
        if (!$capaianpembelajaranlulusan) {
            abort(403, 'akses ditolak');
        }
        $profilLulusans = ProfilLulusan::whereIn('id_pl', $selectedProfilLulusans)->get();

        return view('kaprodi.capaianpembelajaranlulusan.detail', compact('id_cpl', 'selectedProfilLulusans', 'profilLulusans'));
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

        // Tambahkan filter tahun jika ada
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
            $petaCPL[$row->id_cpl]['deskripsi_cpl'] = $row->deskripsi_cpl; // yang ditampilkan
            $petaCPL[$row->id_cpl]['prodi'] = $row->nama_prodi; // yang ditampilkan
            $petaCPL[$row->id_cpl]['semester'][$semester][] = $namamk; // pengelompokan tetap pakai id
        }

        return view('kaprodi.pemenuhancpl.index', compact('petaCPL', 'id_tahun', 'tahun_tersedia'));
    }
}
