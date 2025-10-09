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
    /** INDEX */
    public function index()
{
    // Ambil semua CPL + CPMK + MK terkait (jika ada)
    $cpls = \App\Models\Cpl::with([
        'cpmks.mataKuliahs',              // ambil semua CPMK beserta MK-nya
        'cpmks.mappings.mataKuliahs'      // ambil MK yang lewat mapping
    ])->get();

    // Bentuk array gabungan seperti sebelumnya
    $grouped = $cpls->map(function ($cpl) {
        // ambil semua CPMK dari CPL ini
        $allCpmks = $cpl->cpmks;

        // kumpulkan semua MK dari CPMK dan dari mapping
        $allMataKuliahs = collect();
        foreach ($allCpmks as $cpmk) {
            $allMataKuliahs = $allMataKuliahs
                ->merge($cpmk->mataKuliahs)
                ->merge(optional($cpmk->mappings)->flatMap->mataKuliahs ?? []);
        }

        return [
            'cpl' => $cpl,
            'cpmks' => $allCpmks->unique('id'),
            'mataKuliahs' => $allMataKuliahs->unique('id'),
        ];
    });

    return view('admin.mapping.index', compact('grouped'));
}

    /** CREATE */
    public function create()
{
    // Ambil semua CPL
    $cpls = Cpl::all();

    // Ambil semua CPMK yang belum tergabung ke CPL mana pun
    $cpmks = Cpmk::all();

    return view('admin.mapping.create', compact('cpls', 'cpmks'));
}


    /** STORE */
    public function store(Request $request)
{
    $validated = $request->validate([
        'cpl_id' => 'required|exists:cpls,id',
        'cpmk_ids' => 'required|array|min:1',
        'cpmk_ids.*' => 'exists:cpmks,id',
    ]);

    foreach ($validated['cpmk_ids'] as $cpmk_id) {
        // 1️⃣ Buat mapping antara CPL dan CPMK
        $mapping = Mapping::firstOrCreate([
            'cpl_id' => $validated['cpl_id'],
            'cpmk_id' => $cpmk_id,
        ]);

        // 2️⃣ Ambil semua MK yang sudah terhubung ke CPMK ini
        $cpmk = \App\Models\Cpmk::with('mataKuliahs')->find($cpmk_id);

        if ($cpmk && $cpmk->mataKuliahs->isNotEmpty()) {
            // 3️⃣ Hubungkan MK tersebut ke mapping ini (tabel pivot mapping_mata_kuliahs)
            $mapping->mataKuliahs()->syncWithoutDetaching(
                $cpmk->mataKuliahs->pluck('id')->toArray()
            );
        }

        // 4️⃣ (Opsional) update cpl_id pada CPMK (supaya resmi tergabung)
        $cpmk->update(['cpl_id' => $validated['cpl_id']]);
    }

    return redirect()->route('mapping.index')
        ->with('success', '✅ Mapping CPL → CPMK → MK berhasil disimpan dan MK ikut otomatis.');
}


    /** DESTROY */
    public function destroy(Mapping $mapping)
    {
        $mapping->mataKuliahs()->detach();
        $mapping->delete();
        return redirect()->route('mapping.index')
            ->with('success', '🗑️ Mapping berhasil dihapus.');
    }
    public function edit($id)
{
    // Ambil CPL berdasarkan ID yang dikirim
    $cpl = \App\Models\Cpl::with([
        'cpmks.mataKuliahs', // CPMK + MK terkait
        'cpmks.mappings.mataKuliahs'
    ])->findOrFail($id);

    // Ambil semua CPMK (untuk referensi pilihan kalau mau ubah)
    $allCpmks = \App\Models\Cpmk::all();
    $allMataKuliahs = \App\Models\MataKuliah::all();

    // Ambil CPMK yang sudah tergabung ke CPL ini
    $selectedCpmks = $cpl->cpmks->pluck('id')->toArray();

    return view('admin.mapping.edit', compact('cpl', 'allCpmks', 'allMataKuliahs', 'selectedCpmks'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'cpmk_ids' => 'required|array|min:1',
        'cpmk_ids.*' => 'exists:cpmks,id',
    ]);

    // Ambil CPL yang dimaksud
    $cpl = \App\Models\Cpl::findOrFail($id);

    // 1️⃣ Hapus semua mapping lama milik CPL ini
    $oldMappings = \App\Models\Mapping::where('cpl_id', $cpl->id)->get();
    foreach ($oldMappings as $old) {
        $old->mataKuliahs()->detach(); // hapus pivot MK
        $old->delete();                // hapus record mapping
    }

    // 2️⃣ Buat mapping baru dari CPMK yang dipilih
    foreach ($validated['cpmk_ids'] as $cpmk_id) {
        $mapping = \App\Models\Mapping::create([
            'cpl_id' => $cpl->id,
            'cpmk_id' => $cpmk_id,
        ]);

        // Ambil MK dari CPMK
        $cpmk = \App\Models\Cpmk::with('mataKuliahs')->find($cpmk_id);
        if ($cpmk && $cpmk->mataKuliahs->isNotEmpty()) {
            $mapping->mataKuliahs()->syncWithoutDetaching(
                $cpmk->mataKuliahs->pluck('id')->toArray()
            );
        }

        // Update kolom cpl_id di tabel cpmks (opsional)
        $cpmk->update(['cpl_id' => $cpl->id]);
    }

    return redirect()->route('mapping.index')
        ->with('success', '✅ Mapping CPL berhasil diperbarui.');
}


}
