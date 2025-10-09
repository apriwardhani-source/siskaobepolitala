<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cpmk;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class CpmkController extends Controller
{
    public function index()
    {
        $cpmks = Cpmk::with('mataKuliahs')->latest()->paginate(10);
        return view('admin.cpmk.index', compact('cpmks'));
    }

    public function create()
    {
        $matkuls = MataKuliah::all();
        return view('admin.cpmk.create', compact('matkuls'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_cpmk' => 'required|string|max:10|unique:cpmks,kode_cpmk',
            'deskripsi' => 'required|string',
            'mata_kuliahs' => 'required|array',
            'mata_kuliahs.*' => 'exists:mata_kuliahs,id',
        ]);

        $cpmk = Cpmk::create($validated);
        $cpmk->mataKuliahs()->attach($validated['mata_kuliahs']);

        return redirect()->route('cpmk.index')->with('success', 'CPMK baru berhasil ditambahkan.');
    }

    public function edit(Cpmk $cpmk)
    {
        $matkuls = MataKuliah::all();
        $selected = $cpmk->mataKuliahs->pluck('id')->toArray();
        return view('admin.cpmk.edit', compact('cpmk', 'matkuls', 'selected'));
    }

    public function update(Request $request, Cpmk $cpmk)
    {
        $validated = $request->validate([
            'kode_cpmk' => 'required|string|max:10|unique:cpmks,kode_cpmk,' . $cpmk->id,
            'deskripsi' => 'required|string',
            'mata_kuliahs' => 'required|array',
            'mata_kuliahs.*' => 'exists:mata_kuliahs,id',
        ]);

        $cpmk->update($validated);
        $cpmk->mataKuliahs()->sync($validated['mata_kuliahs']);

        return redirect()->route('cpmk.index')->with('success', 'Data CPMK berhasil diperbarui.');
    }

    public function destroy(Cpmk $cpmk)
    {
        $cpmk->mataKuliahs()->detach();
        $cpmk->delete();
        return redirect()->route('cpmk.index')->with('success', 'CPMK berhasil dihapus.');
    }
}
