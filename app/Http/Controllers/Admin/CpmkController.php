<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cpl;
use App\Models\Cpmk;
use Illuminate\Http\Request;

class CpmkController extends Controller
{
    public function index()
    {
        $cpmks = Cpmk::with('cpl', 'mataKuliahs')->latest()->paginate(10);
        return view('admin.cpmk.index', compact('cpmks'));
    }

    public function create()
    {
        $cpls = Cpl::all();
        return view('admin.cpmk.create', compact('cpls'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cpl_id' => 'required|exists:cpls,id',
            'kode_cpmk' => 'required|array|min:1',
            'kode_cpmk.*' => 'required|string|max:10|unique:cpmks,kode_cpmk',
            'deskripsi' => 'required|array|min:1',
            'deskripsi.*' => 'required|string',
        ]);

        // Buat semua CPMK sekaligus untuk CPL yang sama
        foreach ($validated['kode_cpmk'] as $index => $kode_cpmk) {
            if (isset($validated['deskripsi'][$index])) {
                Cpmk::create([
                    'cpl_id' => $validated['cpl_id'],
                    'kode_cpmk' => $kode_cpmk,
                    'deskripsi' => $validated['deskripsi'][$index],
                ]);
            }
        }

        return redirect()->route('cpmk.index')->with('success', 'Beberapa CPMK berhasil ditambahkan untuk CPL yang sama.');
    }

    public function edit(Cpmk $cpmk)
    {
        $cpls = Cpl::all();
        return view('admin.cpmk.edit', compact('cpmk', 'cpls'));
    }

    public function update(Request $request, Cpmk $cpmk)
    {
        $validated = $request->validate([
            'cpl_id' => 'required|exists:cpls,id',
            'kode_cpmk' => 'required|string|max:10|unique:cpmks,kode_cpmk,' . $cpmk->id,
            'deskripsi' => 'required|string',
        ]);

        $cpmk->update([
            'cpl_id' => $validated['cpl_id'],
            'kode_cpmk' => $validated['kode_cpmk'],
            'deskripsi' => $validated['deskripsi'],
        ]);

        return redirect()->route('cpmk.index')->with('success', 'Data CPMK berhasil diperbarui.');
    }

    public function destroy(Cpmk $cpmk)
    {
        $cpmk->delete();
        return redirect()->route('cpmk.index')->with('success', 'CPMK berhasil dihapus.');
    }
}
