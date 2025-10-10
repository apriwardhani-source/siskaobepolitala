<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CPL;
use App\Models\Cpmk;
use App\Models\SubCpmk;
use Illuminate\Http\Request;

class CpmkController extends Controller
{
    public function index()
    {
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
        'cpl_id'        => 'required|exists:cpls,id',
        'kode_cpmk'     => 'required|string|max:10|unique:cpmks,kode_cpmk,' . $cpmk->id,
        'deskripsi'     => 'required|string',
        'sub_cpmk'      => 'nullable',
        'sub_cpmk.*'    => 'nullable|string',
    ]);

    $cpmk->update([
        'cpl_id'    => $validated['cpl_id'],
        'kode_cpmk' => $validated['kode_cpmk'],
        'deskripsi' => $validated['deskripsi'],
    ]);

    // Update SUB-CPMK: hapus dan buat ulang sesuai input array
    if ($request->has('sub_cpmk')) {
        $cpmk->subCpmks()->delete();
        foreach ((array) $request->input('sub_cpmk') as $line) {
            $text = trim((string) $line);
            if ($text !== '') {
                SubCpmk::create([
                    'cpmk_id' => $cpmk->id,
                    'uraian'  => $text,
                ]);
            }
        }
    }

    return redirect()->route('cpmk.index')->with('success', 'Data CPMK beserta SUB-CPMK berhasil diperbarui.');
}


    public function destroy(Cpmk $cpmk)
    {
        $cpmk->delete();
        return redirect()->route('cpmk.index')->with('success', 'CPMK berhasil dihapus.');
    }
}
