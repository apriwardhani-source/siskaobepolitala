<?php
// app/Http/Controllers/Admin/CplController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cpl;
use App\Models\Prodi;
use Illuminate\Http\Request;

class CplController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data CPL dengan relasi prodi, paginasi 10 per halaman
        $cpls = Cpl::with('prodi')->latest()->paginate(10);

        // ⬇️ TAMBAHKAN: urutkan item di halaman saat ini secara ASC (mis. berdasarkan kode_cpl)
        $cpls->setCollection(
            $cpls->getCollection()->sortBy('kode_cpl')->values()
        );

        // Return ke view index dengan data
        return view('admin.cpl.index', compact('cpls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua data prodi untuk dropdown
        $prodis = Prodi::all();

        // Return ke view create dengan data prodi
        return view('admin.cpl.create', compact('prodis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // ... (kode lain di atasnya tetap)
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kode_cpl' => 'required|string|max:10|unique:cpls,kode_cpl',
            'deskripsi' => 'required|string',
        ], [
            'kode_cpl.unique' => 'Kode CPL ini sudah digunakan.',
        ]);

        // ⬇️ TAMBAHKAN BARIS INI DI SINI
        $validatedData['prodi_id'] = auth()->user()->prodi_id ?? 1;

        // Simpan data ke database
        Cpl::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('cpl.index')->with('success', 'CPL baru berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cpl $cpl)
    {
        // Ambil semua data prodi untuk dropdown
        $prodis = Prodi::all();

        // Return ke view edit dengan data CPL yang akan diedit dan data prodi
        return view('admin.cpl.edit', compact('cpl', 'prodis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cpl $cpl)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kode_cpl' => 'required|string|max:10|unique:cpls,kode_cpl,' . $cpl->id,
            'deskripsi' => 'required|string',
        ], [
            // Pesan error kustom
            'kode_cpl.unique' => 'Kode CPL ini sudah digunakan.',
        ]);

        // Update data di database
        $cpl->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('cpl.index')->with('success', 'CPL berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cpl $cpl)
    {
        // Validasi: cek apakah CPL memiliki relasi yang mencegah penghapusan
        // Misalnya, jika CPL sudah memiliki mapping CPMK, mungkin tidak boleh dihapus.
        // Untuk sekarang, kita asumsikan bisa dihapus jika tidak ada constraint khusus.
        // Contoh validasi (opsional):
        // if ($cpl->mappings()->count() > 0) {
        //     return redirect()->route('cpl.index')
        //                      ->with('error', 'Tidak dapat menghapus CPL karena sudah memiliki Mapping CPMK terkait.');
        // }

        // Hapus data dari database
        $cpl->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('cpl.index')->with('success', 'CPL berhasil dihapus.');
    }
}