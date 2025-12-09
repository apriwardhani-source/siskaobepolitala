<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Tahun;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tahun_kurikulum = $request->tahun_kurikulum;  // Menerima parameter tahun_kurikulum dari form
        
        // Hanya menampilkan mahasiswa dari prodi user yang login (TIM)
        $kode_prodi = $user->kode_prodi;
        
        $query = Mahasiswa::query();
        
        if ($tahun_kurikulum) {
            $query->where('id_tahun_kurikulum', $tahun_kurikulum);
        }
        
        $query->where('kode_prodi', $kode_prodi);
        
        $mahasiswas = $query->with(['prodi', 'tahunKurikulum'])->orderBy('nim', 'asc')->get();
        $tahun_angkatans = Tahun::all();
        // Hanya prodi user yang tampil di dropdown
        $prodis = collect([Prodi::where('kode_prodi', $kode_prodi)->first()]);
        
        return view('tim.mahasiswa.index', compact('mahasiswas', 'tahun_angkatans', 'prodis', 'tahun_kurikulum', 'kode_prodi'));
    }

    public function create()
    {
        $user = Auth::user();
        $tahun_angkatans = Tahun::all();
        // Hanya prodi user yang tampil
        $prodis = collect([Prodi::where('kode_prodi', $user->kode_prodi)->first()]);
        return view('tim.mahasiswa.create', compact('tahun_angkatans', 'prodis'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('id', $id)
                    ->where('kode_prodi', $user->kode_prodi)
                    ->with(['prodi', 'tahunKurikulum'])
                    ->firstOrFail();

        return view('tim.mahasiswa.detail', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim',
            'nama_mahasiswa' => 'required',
            'id_tahun_kurikulum' => 'required',
            'status' => 'required|in:aktif,lulus,cuti,keluar',
        ]);

        Mahasiswa::create([
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'kode_prodi' => $user->kode_prodi,
            'id_tahun_kurikulum' => $request->id_tahun_kurikulum,
            'status' => $request->status,
        ]);

        return redirect()->route('tim.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('id', $id)
                    ->where('kode_prodi', $user->kode_prodi)
                    ->firstOrFail();
        $tahun_angkatans = Tahun::all();
        // Hanya prodi user yang tampil
        $prodis = collect([Prodi::where('kode_prodi', $user->kode_prodi)->first()]);
        return view('tim.mahasiswa.edit', compact('mahasiswa', 'tahun_angkatans', 'prodis'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim,' . $id,
            'nama_mahasiswa' => 'required',
            'id_tahun_kurikulum' => 'required',
            'status' => 'required|in:aktif,lulus,cuti,keluar',
        ]);

        $mahasiswa = Mahasiswa::where('id', $id)
                    ->where('kode_prodi', $user->kode_prodi)
                    ->firstOrFail();
        
        $mahasiswa->update([
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'id_tahun_kurikulum' => $request->id_tahun_kurikulum,
            'status' => $request->status,
        ]);

        return redirect()->route('tim.mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        
        $mahasiswa = Mahasiswa::where('id', $id)
                    ->where('kode_prodi', $user->kode_prodi)
                    ->firstOrFail();
        $mahasiswa->delete();

        return redirect()->route('tim.mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus');
    }
}
