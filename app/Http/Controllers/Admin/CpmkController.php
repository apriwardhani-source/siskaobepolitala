<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CPL;
use App\Models\Cpmk;
use Illuminate\Http\Request;

class CpmkController extends Controller
{
    public function index()
    {
        //urutan terlama ke terbaru
        $cpmks = Cpmk::with('cpl')->oldest()->paginate(10);
    return view('admin.cpmk.index', compact('cpmks'));
        // Tidak perlu memanggil relasi Mata Kuliah
        $cpmks = Cpmk::with('cpl')->latest()->paginate(10);
        return view('admin.cpmk.index', compact('cpmks'));
    }

    public function create()
    {
        $cpls = CPL::all();
        return view('admin.cpmk.create', compact('cpls'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'cpl_id' => 'required|exists:cpls,id',
        'kode_cpmk' => 'required|string|max:10|unique:cpmks,kode_cpmk',
        'deskripsi' => 'required|string',
    ]);

    Cpmk::create([
        'cpl_id' => $validated['cpl_id'],
        'kode_cpmk' => $validated['kode_cpmk'],
        'deskripsi' => $validated['deskripsi'],
    ]);

    return redirect()->route('cpmk.index')->with('success', 'CPMK baru berhasil ditambahkan.');
}


    public function edit(Cpmk $cpmk)
    {
        $cpls = CPL::all();
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
