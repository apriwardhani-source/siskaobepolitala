<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilLulusan;
use Illuminate\Support\Facades\Auth;
use App\Models\Prodi;
use App\Models\Tahun;

class TimProfilLulusanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->kode_prodi) {
            abort(404);
        }

        $kodeProdi = $user->kode_prodi;
        $id_tahun = $request->get('id_tahun');

        $tahun_tersedia = \App\Models\Tahun::whereHas('profillulusans', function ($query) use ($kodeProdi) {
            $query->where('kode_prodi', $kodeProdi);
        })->orderBy('tahun', 'desc')->get();

        $query = ProfilLulusan::where('kode_prodi', $kodeProdi)->with(['prodi', 'tahun']);

        if ($id_tahun) {
            $query->where('id_tahun', $id_tahun);
        }

        $profillulusans = $query->orderBy('kode_pl', 'asc')->get();

        return view('tim.profillulusan.index', compact('profillulusans', 'id_tahun', 'tahun_tersedia'));
    }

    public function create()
    {
        $tahuns = Tahun::all();
        $user = Auth::user();

        if (!$user || !$user->kode_prodi) {
            abort(404);
        }

        return view('tim.profillulusan.create', compact('tahuns'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->kode_prodi) {
            abort(403);
        }

        $request->merge(['kode_prodi' => $user->kode_prodi]);

        $request->validate([
            'id_tahun' => 'required|exists:tahun,id_tahun',
            'kode_pl' => 'required|string',
            'kode_prodi' => 'required|string',
            'deskripsi_pl' => 'required|string',
            'profesi_pl' => 'required|string',
            'unsur_pl' => 'required|in:Pengetahuan,Keterampilan Khusus,Sikap dan Keterampilan Umum',
            'keterangan_pl' => 'required|in:Kompetensi Utama Bidang,Kompetensi Tambahan',
            'sumber_pl' => 'required|string',
        ]);

        ProfilLulusan::create($request->all());

        return redirect()->route('tim.profillulusan.index')->with('success', 'Profil Lulusan berhasil ditambahkan!');
    }

    public function edit($id_pl)
    {
        $tahuns = Tahun::all();
        $user = Auth::user();

        $profillulusan = ProfilLulusan::where('id_pl', $id_pl)
            ->where('kode_prodi', $user->kode_prodi)
            ->first();

        if (!$profillulusan) {
            abort(403, 'Akses ditolak');
        }
        $prodis = Prodi::all();
        $profillulusan = ProfilLulusan::findOrFail($id_pl);
        return view('tim.profillulusan.edit', compact('profillulusan', 'prodis', 'tahuns'));
    }

    public function update(Request $request, $id_pl)
    {
        $user = Auth::user();

        if (!$user || !$user->kode_prodi) {
            abort(403);
        }
        $profillulusan = ProfilLulusan::where('id_pl', $id_pl)
            ->where('kode_prodi', $user->kode_prodi)
            ->first();

        if (!$profillulusan) {
            abort(403, 'Akses ditolak');
        }
        $request->merge(['kode_prodi' => $user->kode_prodi]);
        $request->validate([
            'id_tahun' => 'required|exists:tahun,id_tahun',
            'kode_pl' => 'required|string|max:10',
            'kode_prodi' => 'required|string|max:10',
            'deskripsi_pl' => 'required',
            'profesi_pl' => 'required',
            'unsur_pl' => 'required|in:Pengetahuan,Keterampilan Khusus,Sikap dan Keterampilan Umum',
            'keterangan_pl' => 'required|in:Kompetensi Utama Bidang,Kompetensi Tambahan',
            'sumber_pl' => 'required',
        ]);

        $profillulusan->update($request->all());
        return redirect()->route('tim.profillulusan.index')->with('success', 'Profil Lulusan berhasil diperbarui.');
    }

    public function detail(ProfilLulusan $id_pl)
    {
        $tahuns = Tahun::all();
        $user = Auth::user();

        if (!$user || !$user->kode_prodi || $id_pl->kode_prodi !== $user->kode_prodi) {
            abort(403, 'Akses ditolak');
        }

        return view('tim.profillulusan.detail', compact('id_pl', 'tahuns'));
    }

    public function destroy(ProfilLulusan $id_pl)
    {
        $id_pl->delete();
        return redirect()->route('tim.profillulusan.index')->with('sukses', 'Profil Lulusan Berhasil Dihapus');
    }
}
