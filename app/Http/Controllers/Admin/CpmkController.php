<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cpmk;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class CpmkController extends Controller
{
    /**
     * Display a listing of the resource.
     * Use Case: "Kelola CPMK" - Menampilkan daftar CPMK
     */
    public function index()
    {
        // Ambil semua data CPMK dengan relasi mata_kuliah, diurutkan berdasarkan yang terbaru
        $cpmks = Cpmk::with('mataKuliah.prodi')->latest()->paginate(10); // Sesuaikan jumlah item per halaman

        // Return ke view index CPMK
        return view('admin.cpmk.index', compact('cpmks'));
    }

    /**
     * Show the form for creating a new resource.
     * Use Case: "Tambah Data CPMK" - Menampilkan form tambah CPMK
     */
    public function create()
    {
        // Ambil data mata kuliah untuk dropdown di form
        $mataKuliahs = MataKuliah::with('prodi')->get(); // Eager load prodi untuk ditampilkan di dropdown

        // Return ke view form create CPMK
        return view('admin.cpmk.create', compact('mataKuliahs'));
    }

    /**
     * Store a newly created resource in storage.
     * Use Case: "Tambah Data CPMK" - Menyimpan data CPMK baru
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $validatedData = $request->validate([
            'kode_cpmk' => 'required|string|max:10|unique:cpmks,kode_cpmk', // Validasi kode_cpmk unik di tabel cpmks kolom kode_cpmk
            'deskripsi' => 'required|string',
          // Validasi mata_kuliah_id ada di tabel mata_kuliahs
            // 'bobot' => 'nullable|integer|min:0|max:100', // Validasi bobot jika ada
        ], [
            // Pesan error kustom (opsional)
            'kode_cpmk.unique' => 'Kode CPMK ini sudah digunakan.',
   
            // 'bobot.min' => 'Bobot minimal 0%.', // Pesan error bobot jika ada
            // 'bobot.max' => 'Bobot maksimal 100%.', // Pesan error bobot jika ada
        ]);

        // 2. Simpan data CPMK baru ke database
        // Pastikan model Cpmk memiliki $fillable yang sesuai
        Cpmk::create($validatedData);

        // 3. Redirect kembali ke halaman daftar CPMK dengan pesan sukses
        // Pastikan route 'cpmk.index' sudah didefinisikan
        return redirect()->route('cpmk.index') // Atau admin.manage.cpmk jika pakai route manual
                         ->with('success', 'CPMK baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * (Opsional, bisa digunakan untuk halaman detail CPMK jika diperlukan)
     */
    public function show(Cpmk $cpmk)
    {
        // Eager load relasi jika diperlukan di halaman detail
        $cpmk->load('mataKuliah.prodi');
        return view('admin.cpmk.show', compact('cpmk'));
    }

    /**
     * Show the form for editing the specified resource.
     * Use Case: "Edit Data CPMK" - Menampilkan form edit CPMK
     */
    public function edit(Cpmk $cpmk)
    {
        // 1. Ambil data yang dibutuhkan untuk dropdown di form edit
        $mataKuliahs = MataKuliah::with('prodi')->get(); // Eager load prodi untuk ditampilkan di dropdown

        // 2. Return ke view form edit dengan data CPMK yang akan diedit dan data dropdown
        return view('admin.cpmk.edit', compact('cpmk', 'mataKuliahs'));
    }

    /**
     * Update the specified resource in storage.
     * Use Case: "Edit Data CPMK" - Memperbarui data CPMK
     */
    public function update(Request $request, Cpmk $cpmk)
    {
        // 1. Validasi input dari form edit
        $validatedData = $request->validate([
            'kode_cpmk' => 'required|string|max:10|unique:cpmks,kode_cpmk,' . $cpmk->id, // Unique kecuali untuk record ini
            'deskripsi' => 'required|string',
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id', // Validasi mata_kuliah_id ada di tabel mata_kuliahs
            // 'bobot' => 'nullable|integer|min:0|max:100', // Validasi bobot jika ada
        ], [
            // Pesan error kustom (opsional)
            'kode_cpmk.unique' => 'Kode CPMK ini sudah digunakan.',
            'mata_kuliah_id.exists' => 'Mata Kuliah yang dipilih tidak valid.',
            // 'bobot.min' => 'Bobot minimal 0%.', // Pesan error bobot jika ada
            // 'bobot.max' => 'Bobot maksimal 100%.', // Pesan error bobot jika ada
        ]);

        // 2. Update data CPMK di database
        $cpmk->update($validatedData);

        // 3. Redirect kembali ke halaman daftar CPMK dengan pesan sukses
        return redirect()->route('cpmk.index') // Atau admin.manage.cpmk jika pakai route manual
                         ->with('success', 'Data CPMK berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * Use Case: "Hapus Data CPMK" - Menghapus data CPMK
     */
    public function destroy(Cpmk $cpmk)
    {
        // Validasi tambahan: Cek apakah CPMK memiliki relasi yang mencegah penghapusan
        // Misalnya, jika CPMK sudah memiliki Mapping atau Komponen Penilaian, mungkin tidak boleh dihapus.
        // Untuk sekarang, kita asumsikan bisa dihapus jika tidak ada constraint khusus.
        // Contoh validasi (opsional):
        // if ($cpmk->mappings()->count() > 0) {
        //     return redirect()->route('cpmk.index')
        //                      ->with('error', 'Tidak dapat menghapus CPMK karena sudah memiliki Mapping CPL terkait.');
        // }
        // if ($cpmk->komponenPenilaians()->count() > 0) {
        //     return redirect()->route('cpmk.index')
        //                      ->with('error', 'Tidak dapat menghapus CPMK karena sudah memiliki Komponen Penilaian terkait.');
        // }

        // 1. Hapus data CPMK dari database
        $cpmk->delete();

        // 2. Redirect kembali ke halaman daftar CPMK dengan pesan sukses
        return redirect()->route('cpmk.index') // Atau admin.manage.cpmk jika pakai route manual
                         ->with('success', 'CPMK berhasil dihapus.');
    }
}