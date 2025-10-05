<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class AngkatanController extends Controller
{
    // Tampilkan daftar angkatan
    public function index()
    {
        $angkatans = Angkatan::with('matkul')->get();
        return view('admin.manage_angkatan', compact('angkatans'));
    }

    // Form create
    public function create()
    {
        $matkuls = MataKuliah::all();
        return view('admin.create_angkatan', compact('matkuls'));
    }

    // Simpan angkatan baru
    public function store(Request $request)
    {
        $request->validate([
            'tahun_kurikulum' => 'required|string',
            'matkul_id' => 'required|exists:mata_kuliahs,id',
        ]);

        Angkatan::create($request->only(['tahun_kurikulum', 'matkul_id']));
        return redirect()->route('admin.manage.angkatan')->with('success', 'Kurikulum berhasil ditambahkan.');
    }

    // Form edit
    public function edit($id)
    {
        $angkatan = Angkatan::findOrFail($id);
        $matkuls = MataKuliah::all();
        return view('admin.edit_angkatan', compact('angkatan', 'matkuls'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_kurikulum' => 'required|string',
            'matkul_id' => 'required|exists:mata_kuliahs,id',
        ]);

        $angkatan = Angkatan::findOrFail($id);
        $angkatan->update($request->only(['tahun_kurikulum', 'matkul_id']));

        return redirect()->route('admin.manage.angkatan')->with('success', 'Kurikulum berhasil diperbarui.');
    }

    // Hapus data
    public function destroy($id)
    {
        $angkatan = Angkatan::findOrFail($id);
        $angkatan->delete();

        return redirect()->route('admin.manage.angkatan')->with('success', 'Kurikulum berhasil dihapus.');
    }
}
