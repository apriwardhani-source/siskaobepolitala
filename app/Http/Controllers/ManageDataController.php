<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prodi; 
use App\Models\Mahasiswa; 
use App\Models\Angkatan; 
use App\Models\MataKuliah; 

class ManageDataController extends Controller
{
    // ================= PRODI =================
    public function indexProdi()
    {
        $this->authorizeAdmin();
        $prodis = Prodi::all();
        return view('admin.manage_prodi', compact('prodis'));
    }

    public function showCreateProdiForm()
    {
        $this->authorizeAdmin();
        return view('admin.create_prodi');
    }

    public function storeProdi(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'kode_prodi' => 'required|string|unique:prodis,kode_prodi',
            'nama_prodi' => 'required|string',
        ]);

        Prodi::create($request->only(['kode_prodi','nama_prodi']));
        return redirect()->route('admin.manage.prodi')->with('success', 'Prodi berhasil ditambahkan.');
    }

    // ================= MAHASISWA =================
public function indexMahasiswa()
{
    $this->authorizeAdmin();
    $mahasiswas = Mahasiswa::with('prodi')->get(); 
    return view('admin.manage_mahasiswa', compact('mahasiswas'));
}

public function showCreateMahasiswaForm()
{
    $this->authorizeAdmin();
    $angkatans = Angkatan::all(); // kalau masih mau dropdown tahun dari tabel angkatan
    $prodis = Prodi::all();
    return view('admin.create_mahasiswa', compact('angkatans','prodis'));
}

public function storeMahasiswa(Request $request)
{
    $this->authorizeAdmin();

    $request->validate([
        'nim' => 'required|string|unique:mahasiswas,nim',
        'nama' => 'required|string',
        'tahun_kurikulum' => 'required|string',
        'prodi_id' => 'required|exists:prodis,id',
    ]);

    Mahasiswa::create($request->only(['nim','nama','tahun_kurikulum','prodi_id']));

    return redirect()->route('admin.manage.mahasiswa')
                     ->with('success', 'Mahasiswa berhasil ditambahkan.');
}

// Form edit mahasiswa
public function editMahasiswa($id)
{
    $this->authorizeAdmin();
    $mahasiswa = Mahasiswa::findOrFail($id);
    $angkatans = Angkatan::all();
    $prodis = Prodi::all();
    return view('admin.edit_mahasiswa', compact('mahasiswa','angkatans','prodis'));
}

// Update mahasiswa
public function updateMahasiswa(Request $request, $id)
{
    $this->authorizeAdmin();

    $request->validate([
        'nim' => 'required|string|unique:mahasiswas,nim,'.$id,
        'nama' => 'required|string',
        'tahun_kurikulum' => 'required|string',
        'prodi_id' => 'required|exists:prodis,id',
    ]);

    $mahasiswa = Mahasiswa::findOrFail($id);
    $mahasiswa->update($request->only(['nim','nama','tahun_kurikulum','prodi_id']));

    return redirect()->route('admin.manage.mahasiswa')
                     ->with('success', 'Mahasiswa berhasil diperbarui.');
}

// Hapus mahasiswa
public function deleteMahasiswa($id)
{
    $this->authorizeAdmin();
    $mahasiswa = Mahasiswa::findOrFail($id);
    $mahasiswa->delete();

    return redirect()->route('admin.manage.mahasiswa')
                     ->with('success', 'Mahasiswa berhasil dihapus.');
}

    // ================= ANGKATAN =================
    public function indexAngkatan()
    {
        $this->authorizeAdmin();
        $angkatans = Angkatan::with('prodi')->get();
        return view('admin.manage_angkatan', compact('angkatans'));
    }

    public function showCreateAngkatanForm()
    {
        $this->authorizeAdmin();
        $prodis = Prodi::all();
        return view('admin.create_angkatan', compact('prodis'));
    }

    public function storeAngkatan(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'tahun_angkatan' => 'required|string|unique:angkatans,tahun_angkatan,NULL,id,prodi_id,' . $request->prodi_id,
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        Angkatan::create($request->only(['tahun_angkatan','prodi_id']));
        return redirect()->route('admin.manage.angkatan')->with('success', 'Angkatan berhasil ditambahkan.');
    }

    // ================= MATA KULIAH =================
    public function indexMatkul()
    {
        $this->authorizeAdmin();
        $matkuls = MataKuliah::with('prodi')->get();
        return view('admin.manage_matkul', compact('matkuls'));
    }

    public function showCreateMatkulForm()
    {
        $this->authorizeAdmin();
        $prodis = Prodi::all();
        return view('admin.create_matkul', compact('prodis'));
    }

    public function storeMatkul(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'kode_matkul' => 'required|string|unique:mata_kuliahs,kode_matkul',
            'nama_matkul' => 'required|string',
            'sks' => 'required|integer|min:1|max:6',
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        MataKuliah::create($request->only(['kode_matkul','nama_matkul','sks','prodi_id']));
        return redirect()->route('admin.manage.matkul')->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    // ================= HELPER =================
    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }
}
