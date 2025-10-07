<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cpmk;
use Illuminate\Http\Request;

class CpmkController extends Controller
{
    /** Tampilkan daftar CPMK */
    public function index()
    {
        $cpmks = Cpmk::latest()->paginate(10);
        return view('admin.cpmk.index', compact('cpmks'));
    }

    /** Tampilkan form tambah CPMK */
    public function create()
    {
        return view('admin.cpmk.create');
    }

    /** Simpan CPMK baru */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_cpmk' => 'required|string|max:10|unique:cpmks,kode_cpmk',
            'deskripsi' => 'required|string',
        ], [
            'kode_cpmk.unique' => 'Kode CPMK ini sudah digunakan.',
        ]);

        Cpmk::create($validated);

        return redirect()->route('cpmk.index')
                         ->with('success', 'CPMK baru berhasil ditambahkan.');
    }

    /** Tampilkan detail CPMK */
    public function show(Cpmk $cpmk)
    {
        return view('admin.cpmk.show', compact('cpmk'));
    }

    /** Tampilkan form edit CPMK */
    public function edit(Cpmk $cpmk)
    {
        return view('admin.cpmk.edit', compact('cpmk'));
    }

    /** Update CPMK */
    public function update(Request $request, Cpmk $cpmk)
    {
        $validated = $request->validate([
            'kode_cpmk' => 'required|string|max:10|unique:cpmks,kode_cpmk,' . $cpmk->id,
            'deskripsi' => 'required|string',
        ]);

        $cpmk->update($validated);

        return redirect()->route('cpmk.index')
                         ->with('success', 'Data CPMK berhasil diperbarui.');
    }

    /** Hapus CPMK */
    public function destroy(Cpmk $cpmk)
    {
        $cpmk->delete();
        return redirect()->route('cpmk.index')
                         ->with('success', 'CPMK berhasil dihapus.');
    }
}
