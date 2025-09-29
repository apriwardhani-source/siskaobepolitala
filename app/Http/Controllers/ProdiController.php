<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Prodi; // Pastikan model Prodi sudah ada
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil semua data prodi dari database
        $prodis = Prodi::all(); // Untuk tampilan awal, kamu bisa gunakan paginate() nanti
        // Return ke view index prodi
        return view('admin.manage_prodi', compact('prodis')); // Sesuaikan nama view
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return ke view form create prodi
        return view('admin.create_prodi');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_prodi' => 'required|string|max:10|unique:prodis,kode_prodi', // Unique di tabel prodis kolom kode_prodi
            'nama_prodi' => 'required|string|max:255',
            // Tambahkan validasi untuk kolom lain jika ada, misalnya 'jenjang'
            // 'jenjang' => 'required|in:D3,S1,S2,S3'
        ]);

        // Buat prodi baru di database
        Prodi::create($request->all());

        // Redirect kembali ke index prodi dengan pesan sukses
        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prodi  $prodi
     * @return \Illuminate\Http\Response
     */
    public function show(Prodi $prodi)
    {
        // Return ke view detail prodi
        return view('admin.show_prodi', compact('prodi')); // Buat view ini nanti jika diperlukan
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prodi  $prodi
     * @return \Illuminate\Http\Response
     */
    public function edit(Prodi $prodi)
    {
        // Return ke view form edit prodi, sertakan data prodi
        return view('admin.edit_prodi', compact('prodi')); // Buat view ini nanti
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prodi  $prodi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prodi $prodi)
    {
        // Validasi input
        $request->validate([
            'kode_prodi' => 'required|string|max:10|unique:prodis,kode_prodi,'.$prodi->id, // Unique kecuali untuk prodi ini
            'nama_prodi' => 'required|string|max:255',
            // Tambahkan validasi untuk kolom lain jika ada
        ]);

        // Update data prodi di database
        $prodi->update($request->all());

        // Redirect kembali ke index prodi dengan pesan sukses
        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prodi  $prodi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prodi $prodi)
    {
        // Hapus data prodi dari database
        $prodi->delete();

        // Redirect kembali ke index prodi dengan pesan sukses
        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil dihapus.');
    }
}