<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prodi; // Impor model Prodi
use App\Models\Mahasiswa; // Impor model Mahasiswa
use App\Models\Angkatan; // Impor model Angkatan
use App\Models\MataKuliah; // Impor model MataKuliah (buat dulu jika belum ada)

class ManageDataController extends Controller
{
    public function __construct()
    {
        // Pastikan user login dan memiliki role admin untuk akses fungsi di sini
        // Kita gunakan pengecekan role manual di setiap method
    }

    // Method untuk menampilkan daftar Prodi (Admin)
    public function indexProdi()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $prodis = Prodi::all(); // Ambil semua data prodi
        return view('admin.manage_prodi', compact('prodis'));
    }

    // Method untuk menampilkan daftar Mahasiswa (Admin)
    public function indexMahasiswa()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil mahasiswa beserta relasi angkatan dan prodi untuk ditampilkan di tabel
        $mahasiswas = Mahasiswa::with('angkatan.prodi')->get(); 
        return view('admin.manage_mahasiswa', compact('mahasiswas'));
    }

    // Method untuk menampilkan daftar Angkatan (Admin)
    public function indexAngkatan()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil angkatan beserta relasi prodi untuk ditampilkan di tabel
        $angkatans = Angkatan::with('prodi')->get();
        return view('admin.manage_angkatan', compact('angkatans'));
    }

    // Method untuk menampilkan daftar Mata Kuliah (Admin)
    public function indexMatkul()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil mata kuliah beserta relasi prodi untuk ditampilkan di tabel
        $matkuls = MataKuliah::with('prodi')->get();
        return view('admin.manage_matkul', compact('matkuls'));
    }

    // Method untuk menampilkan form tambah Prodi (Admin)
    public function showCreateProdiForm()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.create_prodi');
    }

    // Method untuk menyimpan Prodi baru (Admin)
    public function storeProdi(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Validasi dan simpan data prodi baru
        $request->validate([
            'kode_prodi' => 'required|string|unique:prodis,kode_prodi',
            'nama_prodi' => 'required|string',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        Prodi::create($request->all()); // Simpan ke database
        return redirect()->route('admin.manage.prodi')->with('success', 'Prodi berhasil ditambahkan.');
    }

    // Method untuk menampilkan form tambah Mahasiswa (Admin)
    public function showCreateMahasiswaForm()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil data angkatan beserta prodi untuk dropdown
        $angkatans = Angkatan::with('prodi')->get();
        return view('admin.create_mahasiswa', compact('angkatans'));
    }

    // Method untuk menyimpan Mahasiswa baru (Admin)
    public function storeMahasiswa(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Validasi dan simpan data mahasiswa baru
        $request->validate([
            'nim' => 'required|string|unique:mahasiswas,nim',
            'nama_mahasiswa' => 'required|string',
            'angkatan_id' => 'required|exists:angkatans,id', // Validasi bahwa angkatan_id ada di tabel angkatans
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        Mahasiswa::create($request->all()); // Simpan ke database
        return redirect()->route('admin.manage.mahasiswa')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    // Method untuk menampilkan form tambah Angkatan (Admin)
    public function showCreateAngkatanForm()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil data prodi untuk dropdown
        $prodis = Prodi::all();
        return view('admin.create_angkatan', compact('prodis'));
    }

    // Method untuk menyimpan Angkatan baru (Admin)
    public function storeAngkatan(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Validasi dan simpan data angkatan baru
        $request->validate([
            'tahun_angkatan' => 'required|string|unique:angkatans,tahun_angkatan,NULL,id,prodi_id,' . $request->prodi_id, // Unique berdasarkan prodi
            'prodi_id' => 'required|exists:prodis,id',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        Angkatan::create($request->all()); // Simpan ke database
        return redirect()->route('admin.manage.angkatan')->with('success', 'Angkatan berhasil ditambahkan.');
    }

    // Method untuk menampilkan form tambah Mata Kuliah (Admin)
    public function showCreateMatkulForm()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil data prodi untuk dropdown
        $prodis = Prodi::all();
        return view('admin.create_matkul', compact('prodis'));
    }

    // Method untuk menyimpan Mata Kuliah baru (Admin)
    public function storeMatkul(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Validasi dan simpan data mata kuliah baru
        $request->validate([
            'kode_matkul' => 'required|string|unique:mata_kuliahs,kode_matkul',
            'nama_matkul' => 'required|string',
            'sks' => 'required|integer|min:1|max:6', // Misalnya SKS antara 1-6
            'prodi_id' => 'required|exists:prodis,id',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        MataKuliah::create($request->all()); // Simpan ke database
        return redirect()->route('admin.manage.matkul')->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    // Tambahkan method untuk edit/update/hapus jika diperlukan nanti
    // public function editProdi($id) { ... }
    // public function updateProdi(Request $request, $id) { ... }
    // public function deleteProdi($id) { ... }
    // ... dan seterusnya untuk Mahasiswa, Angkatan, Matkul
}