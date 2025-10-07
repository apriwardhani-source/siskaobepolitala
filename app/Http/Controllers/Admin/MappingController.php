<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapping;
use App\Models\Cpl;
use App\Models\Cpmk;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MappingController extends Controller
{
    /** ========================
     *  INDEX
     * ======================== */
    public function index()
{
    // Ambil semua mapping dengan relasi CPL, CPMK, dan daftar Mata Kuliah
    $mappings = Mapping::with(['cpl', 'cpmk', 'mataKuliahs'])
        ->latest()
        ->paginate(10);

    return view('admin.mapping.index', compact('mappings'));
}


    /** ========================
     *  CREATE
     * ======================== */
    public function create()
    {
        $cpls = Cpl::all();
        $cpmks = Cpmk::all();
        $mataKuliahs = MataKuliah::all();

        return view('admin.mapping.create', compact('cpls', 'cpmks', 'mataKuliahs'));
    }

    /** ========================
     *  STORE
     * ======================== */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cpl_id' => 'required|exists:cpls,id',
            'cpmk_id' => 'required|exists:cpmks,id',
            'bobot' => 'required|numeric|min:0|max:100',
            'mata_kuliah_ids' => 'required|array|min:1',
            'mata_kuliah_ids.*' => 'exists:mata_kuliahs,id',
        ]);

        // Hitung total bobot CPMK yang sama
        $totalBobot = Mapping::where('cpmk_id', $validated['cpmk_id'])->sum('bobot');
        $totalBaru = $totalBobot + $validated['bobot'];

        if ($totalBaru > 100) {
            return back()->withErrors([
                'bobot' => '❌ Total bobot mapping untuk CPMK ini akan melebihi 100%. (Total saat ini: ' . $totalBobot . '%)'
            ])->withInput();
        }
// Cek apakah kombinasi CPL dan CPMK sudah ada
$exists = Mapping::where('cpl_id', $validated['cpl_id'])
                 ->where('cpmk_id', $validated['cpmk_id'])
                 ->exists();

if ($exists) {
    return back()->withErrors([
        'msg' => '❌ Mapping antara CPL dan CPMK ini sudah ada di database.'
    ])->withInput();
}

        // Simpan mapping utama
        $mapping = Mapping::create([
            'cpl_id' => $validated['cpl_id'],
            'cpmk_id' => $validated['cpmk_id'],
            'bobot' => $validated['bobot'],
        ]);

        // Simpan relasi pivot (mata kuliah)
        $mapping->mataKuliahs()->attach($validated['mata_kuliah_ids']);

        return redirect()->route('mapping.index')->with('success', '✅ Mapping baru berhasil ditambahkan.');
    }

    /** ========================
     *  EDIT
     * ======================== */
    public function edit(Mapping $mapping)
    {
        $cpls = Cpl::all();
        $cpmks = Cpmk::all();
        $mataKuliahs = MataKuliah::all();
        $selectedMataKuliahs = $mapping->mataKuliahs()->pluck('mata_kuliah_id')->toArray();

        return view('admin.mapping.edit', compact('mapping', 'cpls', 'cpmks', 'mataKuliahs', 'selectedMataKuliahs'));
    }

    /** ========================
     *  UPDATE
     * ======================== */
    public function update(Request $request, Mapping $mapping)
    {
        $validated = $request->validate([
            'cpl_id' => 'required|exists:cpls,id',
            'cpmk_id' => 'required|exists:cpmks,id',
            'bobot' => 'required|numeric|min:0|max:100',
            'mata_kuliah_ids' => 'required|array|min:1',
            'mata_kuliah_ids.*' => 'exists:mata_kuliahs,id',
        ]);

        // Hitung total bobot CPMK, tapi kurangi bobot milik mapping ini
        $totalBobot = Mapping::where('cpmk_id', $validated['cpmk_id'])
            ->where('id', '!=', $mapping->id)
            ->sum('bobot');

        $totalBaru = $totalBobot + $validated['bobot'];

        if ($totalBaru > 100) {
            return back()->withErrors([
                'bobot' => '❌ Total bobot mapping untuk CPMK ini akan melebihi 100%. (Total saat ini: ' . $totalBobot . '%)'
            ])->withInput();
        }

        // Update mapping utama
        $mapping->update([
            'cpl_id' => $validated['cpl_id'],
            'cpmk_id' => $validated['cpmk_id'],
            'bobot' => $validated['bobot'],
        ]);

        // Sinkronkan pivot mata kuliah
        $mapping->mataKuliahs()->sync($validated['mata_kuliah_ids']);

        return redirect()->route('mapping.index')->with('success', '✅ Data mapping berhasil diperbarui.');
    }

    /** ========================
     *  DESTROY
     * ======================== */
    public function destroy(Mapping $mapping)
    {
        $mapping->mataKuliahs()->detach();
        $mapping->delete();

        return redirect()->route('mapping.index')->with('success', '🗑️ Mapping berhasil dihapus.');
    }
}
