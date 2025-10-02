<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cpl;
use App\Models\Prodi;
use Illuminate\Http\Request;

class CplController extends Controller
{
    public function index()
    {
        $cpls = Cpl::with('prodi')->latest()->paginate(10);
        return view('admin.cpl.index', compact('cpls'));
    }

    public function create()
    {
        $prodis = Prodi::all();
        return view('admin.cpl.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_cpl' => 'required|string|max:10|unique:cpls,kode_cpl',
            'deskripsi' => 'required|string',
            'threshold' => 'required|numeric|min:0|max:100',
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        Cpl::create($validatedData);

        return redirect()->route('cpl.index')->with('success', 'CPL berhasil ditambahkan.');
    }

    public function edit(Cpl $cpl)
    {
        $prodis = Prodi::all();
        return view('admin.cpl.edit', compact('cpl', 'prodis'));
    }

    public function update(Request $request, Cpl $cpl)
    {
        $validatedData = $request->validate([
            'kode_cpl' => 'required|string|max:10|unique:cpls,kode_cpl,' . $cpl->id,
            'deskripsi' => 'required|string',
            'threshold' => 'required|numeric|min:0|max:100',
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        $cpl->update($validatedData);

        return redirect()->route('cpl.index')->with('success', 'CPL berhasil diperbarui.');
    }

    public function destroy(Cpl $cpl)
    {
        $cpl->delete();
        return redirect()->route('cpl.index')->with('success', 'CPL berhasil dihapus.');
    }
}