<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\Prodi;
use Illuminate\Http\Request;

class AngkatanController extends Controller
{
    // Tampilkan daftar angkatan
    public function index()
    {
        $angkatans = Angkatan::with('prodi')->get();
        return view('admin.manage_angkatan', compact('angkatans'));
    }

    // Form create
    public function create()
    {
        $prodis = Prodi::all();
        return view('admin.create_angkatan', compact('prodis'));
    }

    // Simpan angkatan baru
    public function store(Request $request)
    {
        $request->validate([
            'tahun_kurikulum' => 'required|string',
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        Angkatan::create($request->only(['tahun_kurikulum', 'prodi_id']));
        return redirect()->route('admin.manage.angkatan')->with('success', 'Angkatan berhasil ditambahkan.');
    }

    // Form edit
    public function edit($id)
    {
        $angkatan = Angkatan::findOrFail($id);
        $prodis = Prodi::all();
        return view('admin.edit_angkatan', compact('angkatan', 'prodis'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_kurikulum' => 'required|string',
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        $angkatan = Angkatan::findOrFail($id);
        $angkatan->update($request->only(['tahun_kurikulum', 'prodi_id']));

        return redirect()->route('admin.manage.angkatan')->with('success', 'Angkatan berhasil diperbarui.');
    }

    // Hapus data
    public function destroy($id)
    {
        $angkatan = Angkatan::findOrFail($id);
        $angkatan->delete();

        return redirect()->route('admin.manage.angkatan')->with('success', 'Angkatan berhasil dihapus.');
    }
}
