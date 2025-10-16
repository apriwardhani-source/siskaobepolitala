<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ProfilLulusan;
use App\Models\CapaianProfilLulusan;
use Illuminate\Support\Facades\DB;

class AdminProdiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::all();
        return view('admin.prodi.index', compact('prodis'));
    }

    public function create()
    {
        return view('admin.prodi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_prodi' => 'required|string|max:10|unique:prodis,kode_prodi',
            'nama_prodi' => 'required|string|max:100',
            'nama_kaprodi' => 'required|string|max:100',
            'jenjang_pendidikan' => ['required', Rule::in(['D3', 'D4'])],
        ]);

        Prodi::create($request->all());
        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil ditambahkan.');
    }

    public function edit(Prodi $prodi)
    {
        return view('admin.prodi.edit', compact('prodi'));
    }

    public function update(Request $request, Prodi $prodi)
    {
        $request->validate([
            'kode_prodi' => ['required', 'string', 'max:10', Rule::unique('prodis', 'kode_prodi')->ignore($prodi->kode_prodi, 'kode_prodi')],
            'nama_prodi' => 'required|string|max:100',
            'nama_kaprodi' => 'required|string|max:100',
            'jenjang_pendidikan' => ['required', Rule::in(['D3', 'D4'])],
        ]);

        $prodi->update($request->all());
        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil diperbarui.');
    }

    public function detail(Prodi $prodi)
    {
        return view('admin.prodi.detail', compact('prodi'));
    }

    public function destroy($kode_prodi)
    {
        // Hapus Profil Lulusan yang terkait dengan prodi ini
        ProfilLulusan::where('kode_prodi', $kode_prodi)->delete();

        // Hapus Capaian Profil Lulusan (CPL) yang terkait dengan prodi ini
        // (struktur baru: CPL langsung punya kode_prodi, tidak perlu pivot cpl_pl)
        CapaianProfilLulusan::where('kode_prodi', $kode_prodi)->delete();

        // Hapus Prodi
        Prodi::where('kode_prodi', $kode_prodi)->delete();

        return redirect()->route('admin.prodi.index')->with('sukses', 'Prodi berhasil dihapus beserta data terkait.');
    }
}
