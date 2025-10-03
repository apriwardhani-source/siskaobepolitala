<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapping;
use App\Models\Cpl;
use App\Models\Cpmk;
use Illuminate\Http\Request;

class MappingController extends Controller
{
    /**
     * Display a listing of the resource.
     * Use Case: "Mapping CPMK → CPL" - Menampilkan daftar mapping
     */
    public function index()
    {
        // Ambil semua data mapping dengan relasi cpl dan cpmk, diurutkan berdasarkan yang terbaru
        $mappings = Mapping::with(['cpl', 'cpmk.mataKuliah.prodi'])->latest()->paginate(10); // Sesuaikan jumlah item per halaman

        // Return ke view index mapping
        return view('admin.mapping.index', compact('mappings'));
    }

    /**
     * Show the form for creating a new resource.
     * Use Case: "Mapping CPMK → CPL" - Menampilkan form tambah mapping
     */
    public function create()
    {
        // Ambil data cpl dan cpmk untuk dropdown di form
        $cpls = Cpl::all();
        $cpmks = Cpmk::with('mataKuliah.prodi')->get(); // Eager load relasi untuk ditampilkan di dropdown

        // Return ke view form create mapping
        return view('admin.mapping.create', compact('cpls', 'cpmks'));
    }

    /**
     * Store a newly created resource in storage.
     * Use Case: "Mapping CPMK → CPL" - Menyimpan data mapping baru
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $validatedData = $request->validate([
            'cpl_id' => 'required|exists:cpls,id',
            'cpmk_id' => 'required|exists:cpmks,id',
            'bobot' => 'required|numeric|min:0|max:100',
        ], [
            // Pesan error kustom (opsional)
            'cpl_id.exists' => 'CPL yang dipilih tidak valid.',
            'cpmk_id.exists' => 'CPMK yang dipilih tidak valid.',
            'bobot.min' => 'Bobot minimal 0%.',
            'bobot.max' => 'Bobot maksimal 100%.',
        ]);

        // 2. Validasi unik: cek apakah pasangan CPL-CPMK sudah ada
        $existingMapping = Mapping::where('cpl_id', $validatedData['cpl_id'])
                                  ->where('cpmk_id', $validatedData['cpmk_id'])
                                  ->first();

        if ($existingMapping) {
            return redirect()->back()
                             ->withErrors(['msg' => 'Mapping CPL dan CPMK ini sudah ada.'])
                             ->withInput();
        }

        // 3. Validasi total bobot: cek apakah total bobot untuk CPMK ini sudah 100%
        $totalBobot = Mapping::where('cpmk_id', $validatedData['cpmk_id'])
                             ->sum('bobot');

        if (($totalBobot + $validatedData['bobot']) > 100) {
            return redirect()->back()
                             ->withErrors(['bobot' => 'Total bobot mapping untuk CPMK ini akan melebihi 100%.'])
                             ->withInput();
        }

        // 4. Simpan data mapping baru ke database
        Mapping::create($validatedData);

        // 5. Redirect kembali ke halaman daftar mapping dengan pesan sukses
        return redirect()->route('mapping.index')
                         ->with('success', 'Mapping baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * (Opsional, bisa digunakan untuk halaman detail mapping jika diperlukan)
     */
    public function show(Mapping $mapping)
    {
        // Eager load relasi jika diperlukan di halaman detail
        $mapping->load(['cpl', 'cpmk.mataKuliah.prodi']);
        return view('admin.mapping.show', compact('mapping'));
    }

    /**
     * Show the form for editing the specified resource.
     * Use Case: "Mapping CPMK → CPL" - Menampilkan form edit mapping
     */
    public function edit(Mapping $mapping)
    {
        // 1. Ambil data yang dibutuhkan untuk dropdown di form edit
        $cpls = Cpl::all();
        $cpmks = Cpmk::with('mataKuliah.prodi')->get();

        // 2. Return ke view form edit dengan data mapping yang akan diedit dan data dropdown
        return view('admin.mapping.edit', compact('mapping', 'cpls', 'cpmks'));
    }

    /**
     * Update the specified resource in storage.
     * Use Case: "Mapping CPMK → CPL" - Memperbarui data mapping
     */
    public function update(Request $request, Mapping $mapping)
    {
        // 1. Validasi input dari form edit
        $validatedData = $request->validate([
            'cpl_id' => 'required|exists:cpls,id',
            'cpmk_id' => 'required|exists:cpmks,id',
            'bobot' => 'required|numeric|min:0|max:100',
        ], [
            // Pesan error kustom
            'cpl_id.exists' => 'CPL yang dipilih tidak valid.',
            'cpmk_id.exists' => 'CPMK yang dipilih tidak valid.',
            'bobot.min' => 'Bobot minimal 0%.',
            'bobot.max' => 'Bobot maksimal 100%.',
        ]);

        // 2. Validasi unik: cek apakah pasangan CPL-CPMK sudah ada (kecuali untuk record ini)
        $existingMapping = Mapping::where('cpl_id', $validatedData['cpl_id'])
                                  ->where('cpmk_id', $validatedData['cpmk_id'])
                                  ->where('id', '!=', $mapping->id) // Kecuali untuk record ini
                                  ->first();

        if ($existingMapping) {
            return redirect()->back()
                             ->withErrors(['msg' => 'Mapping CPL dan CPMK ini sudah ada.'])
                             ->withInput();
        }

        // 3. Validasi total bobot: cek apakah total bobot untuk CPMK ini sudah 100%
        // Hitung total bobot saat ini untuk CPMK ini, lalu kurangi bobot lama dan tambahkan bobot baru
        $totalBobotSaatIni = Mapping::where('cpmk_id', $validatedData['cpmk_id'])
                                    ->sum('bobot');

        $totalBobotBaru = $totalBobotSaatIni - $mapping->bobot + $validatedData['bobot'];

        if ($totalBobotBaru > 100) {
            return redirect()->back()
                             ->withErrors(['bobot' => 'Total bobot mapping untuk CPMK ini akan melebihi 100%.'])
                             ->withInput();
        }

        // 4. Update data mapping di database
        $mapping->update($validatedData);

        // 5. Redirect kembali ke halaman daftar mapping dengan pesan sukses
        return redirect()->route('mapping.index')
                         ->with('success', 'Data mapping berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * Use Case: "Mapping CPMK → CPL" - Menghapus data mapping
     */
    public function destroy(Mapping $mapping)
    {
        // 1. Hapus data mapping dari database
        $mapping->delete();

        // 2. Redirect kembali ke halaman daftar mapping dengan pesan sukses
        return redirect()->route('mapping.index')
                         ->with('success', 'Mapping berhasil dihapus.');
    }
}