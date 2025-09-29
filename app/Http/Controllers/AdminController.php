<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Impor model User
use Illuminate\Support\Facades\Hash; // Impor facade Hash untuk password

class AdminController extends Controller
{
    public function __construct()
    {
        // Tambahkan pengecekan role di sini secara manual di setiap method
        // Atau buat middleware nanti jika kamu ingin kembali menggunakannya
    }

    // Method untuk menampilkan daftar user
    public function manageUsers()
    {
        // Cek role user
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $users = User::all(); // Ambil semua user
        return view('admin.manage_users', compact('users')); // Akan kita buat view ini
    }

    // Method untuk menampilkan form tambah user
    public function showCreateUserForm()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.create_user'); // Akan kita buat view ini
    }

    // Method untuk menyimpan user baru
    public function storeUser(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Pastikan email unik
            'role' => 'required|in:admin,dosen,akademik,kaprodi,wadir', // Validasi role
            'password' => 'nullable|min:8|confirmed', // Password opsional, minimal 8 karakter, konfirmasi harus cocok
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : Hash::make('password_default'), // Buat password hash, gunakan default jika kosong
        ]);

        return redirect()->route('admin.manage.users')->with('success', 'User berhasil ditambahkan.');
    }

    // Method untuk menampilkan form edit user (opsional untuk sekarang)
    // public function showEditUserForm($id) { ... }

    // Method untuk update user (opsional untuk sekarang)
    // public function updateUser(Request $request, $id) { ... }

    // Method untuk nonaktifkan/hapus user (opsional untuk sekarang, bisa soft delete)
    // public function deactivateUser($id) { ... }
}