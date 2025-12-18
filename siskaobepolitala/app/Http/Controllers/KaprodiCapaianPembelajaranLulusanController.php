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
        $prodis = \App\Models\Prodi::where('kode_prodi', $kodeProdi)->get();

        // Query baru tanpa cpl_pl (karena sudah di-drop)
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
            ->where('cpl.kode_prodi', $kodeProdi)
            ->orderBy('cpl.kode_cpl', 'asc');

        if ($id_tahun) {
            $query->where('cpl.id_tahun', $id_tahun);
        }

        $capaianpembelajaranlulusans = $query->get();
        
        // Untuk compatibility dengan view yang menggunakan $kode_prodi
        $kode_prodi = $kodeProdi;

        return view("kaprodi.capaianpembelajaranlulusan.index", compact("capaianpembelajaranlulusans", "id_tahun", "tahun_tersedia", "kode_prodi", "prodis"));
    }

    public function detail(CapaianProfilLulusan $id_cpl)
    {
        $kodeProdi = Auth::user()->kode_prodi;

        // Cek akses - CPL harus milik prodi user
        if ($id_cpl->kode_prodi !== $kodeProdi) {
            abort(403, 'Akses ditolak');
        }

        // Ambil profil lulusan berdasarkan kode_prodi dan tahun
        $profilLulusans = ProfilLulusan::where('kode_prodi', $kodeProdi)
            ->where('id_tahun', $id_cpl->id_tahun)
            ->get();

        // Untuk saat ini PL terkait hanya ditampilkan jika ada data relasi di masa depan,
        // inisialisasi sebagai array kosong agar view tetap aman.
        $selectedProfilLulusans = [];

        return view('kaprodi.capaianpembelajaranlulusan.detail', compact(
            'id_cpl',
            'profilLulusans',
            'selectedProfilLulusans'
        ));
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

        // Query baru tanpa cpl_pl
        $query = DB::table('capaian_profil_lulusans as cpl')
            ->join('prodis as ps', 'cpl.kode_prodi', '=', 'ps.kode_prodi')
            ->leftJoin('cpl_mk as cmk', 'cpl.id_cpl', '=', 'cmk.id_cpl')
            ->leftJoin('mata_kuliahs as mk', 'cmk.kode_mk', '=', 'mk.kode_mk')
            ->where('cpl.kode_prodi', $kodeProdi)
            ->select('cpl.id_cpl', 'cpl.kode_cpl', 'cpl.deskripsi_cpl', 'ps.nama_prodi', 'mk.semester_mk', 'mk.kode_mk', 'mk.nama_mk')
            ->distinct();

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

            $petaCPL[$row->id_cpl]['label'] = $row->kode_cpl;
            $petaCPL[$row->id_cpl]['deskripsi_cpl'] = $row->deskripsi_cpl;
            $petaCPL[$row->id_cpl]['prodi'] = $row->nama_prodi;
            $petaCPL[$row->id_cpl]['semester'][$semester][] = $namamk;
        }

        return view('kaprodi.pemenuhancpl.index', compact('petaCPL', 'id_tahun', 'tahun_tersedia'));
    }
}
