<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cpl;
use Illuminate\Http\Request;

class CplController extends Controller
{
    public function index()
    {
        // Urut ASC berdasar kode_cpl
    $cpls = Cpl::orderBy('kode_cpl', 'asc')->get();

    return view('admin.cpl.index', compact('cpls'));
    }

    public function create()
    {
        return view('admin.cpl.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_cpl' => 'required|string|max:10|unique:cpls,kode_cpl',
            'deskripsi' => 'required|string',
        ]);

        Cpl::create($validated);
        return redirect()->route('cpl.index')->with('success', 'CPL baru berhasil ditambahkan.');
    }

    public function show(Cpl $cpl)
    {
        $cpl->load('cpmks.mataKuliahs');
        return view('admin.cpl.show', compact('cpl'));
    }

    public function edit(Cpl $cpl)
    {
        return view('admin.cpl.edit', compact('cpl'));
    }

    public function update(Request $request, Cpl $cpl)
    {
        $validated = $request->validate([
            'kode_cpl' => 'required|string|max:10|unique:cpls,kode_cpl,' . $cpl->id,
            'deskripsi' => 'required|string',
        ]);

        $cpl->update($validated);
        return redirect()->route('cpl.index')->with('success', 'CPL berhasil diperbarui.');
    }

    public function destroy(Cpl $cpl)
    {
        $cpl->delete();
        return redirect()->route('cpl.index')->with('success', 'CPL berhasil dihapus.');
    }
}
