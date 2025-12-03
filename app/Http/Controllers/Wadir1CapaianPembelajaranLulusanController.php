<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CapaianProfilLulusan;
use App\Models\ProfilLulusan;
use Illuminate\Support\Facades\DB;

class Wadir1CapaianPembelajaranLulusanController extends Controller
{
    public function index(Request $request)
    {
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');
        $prodis = DB::table('prodis')->get();

        if (!$kode_prodi) {
            // Ambil tahun-tahun yang tersedia dari tabel tahun
            $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
            return view("wadir1.capaianpembelajaranlulusan.index", compact("prodis", "kode_prodi", "id_tahun", "tahun_tersedia"));
        }

        // Gunakan kolom langsung pada tabel CPL (karena skema sudah punya kode_prodi & id_tahun)
        $query = DB::table('capaian_profil_lulusans as cpl')
            ->leftJoin('prodis', 'cpl.kode_prodi', '=', 'prodis.kode_prodi')
            ->leftJoin('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->select(
                'cpl.id_cpl',
                'cpl.deskripsi_cpl',
                'cpl.kode_cpl',
                'cpl.status_cpl',
                'prodis.nama_prodi',
                'tahun.tahun as tahun'
            )
            ->when($kode_prodi, fn($q) => $q->where('cpl.kode_prodi', $kode_prodi))
            ->when($id_tahun, fn($q) => $q->where('cpl.id_tahun', $id_tahun))
            ->orderBy('cpl.kode_cpl', 'asc');

        $capaianprofillulusans = $query->get();

        // Ambil tahun-tahun yang tersedia dari tabel tahun
        $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();

        $dataKosong = $capaianprofillulusans->isEmpty() && $kode_prodi;

        return view("wadir1.capaianpembelajaranlulusan.index", compact("capaianprofillulusans", "prodis", "kode_prodi", "id_tahun", "tahun_tersedia", "dataKosong"));
    }


    public function detail(CapaianProfilLulusan $id_cpl)
    {
        // Skema baru: ambil Profil Lulusan berdasarkan prodi & tahun CPL
        $profilLulusans = ProfilLulusan::where('kode_prodi', $id_cpl->kode_prodi)
            ->where('id_tahun', $id_cpl->id_tahun)
            ->orderBy('kode_pl')
            ->get();

        return view('wadir1.capaianpembelajaranlulusan.detail', [
            'id_cpl' => $id_cpl,
            'selectedProfilLulusans' => [],
            'profilLulusans' => $profilLulusans
        ]);
    }
    public function peta_pemenuhan_cpl(Request $request)
    {
        $kode_prodi = $request->get('kode_prodi');
        $id_tahun = $request->get('id_tahun');
        $prodis = DB::table('prodis')->get();
        if (!$kode_prodi) {
            $tahun_tersedia = \App\Models\Tahun::orderBy('tahun', 'desc')->get();
            return view("wadir1.pemenuhancpl.index", compact("prodis", "kode_prodi", "id_tahun", "tahun_tersedia"));
        }

        $query = DB::table('capaian_profil_lulusans as cpl')
            ->leftJoin('cpl_mk as cmk', 'cpl.id_cpl', '=', 'cmk.id_cpl')
            ->leftJoin('mata_kuliahs as mk', 'cmk.kode_mk', '=', 'mk.kode_mk')
            ->leftJoin('tahun', 'cpl.id_tahun', '=', 'tahun.id_tahun')
            ->leftJoin('prodis as ps', 'cpl.kode_prodi', '=', 'ps.kode_prodi')
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'mk.semester_mk', 'mk.kode_mk', 'mk.nama_mk', 'ps.kode_prodi', 'tahun.tahun', 'ps.nama_prodi')
            ->when($kode_prodi, fn($q) => $q->where('cpl.kode_prodi', $kode_prodi))
            ->when($id_tahun, fn($q) => $q->where('cpl.id_tahun', $id_tahun))
            ->distinct();

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

        return view('wadir1.pemenuhancpl.index', compact('petaCPL', 'prodis', 'kode_prodi', 'id_tahun', 'tahun_tersedia', 'dataKosong'));
    }
}
