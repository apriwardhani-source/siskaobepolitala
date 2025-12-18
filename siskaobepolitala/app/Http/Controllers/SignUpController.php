<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    // Digunakan oleh routes/web.php
    public function create()
    {
        $prodis = Prodi::all();
        return view('auth.signup', compact('prodis'));
    }

    // Digunakan oleh routes/auth.php (alias ke create)
    public function showSignupForm()
    {
        return $this->create();
    }

    // Digunakan oleh routes/web.php
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:kaprodi,tim,dosen',
            'kode_prodi' => 'required|exists:prodis,kode_prodi',
            'nip' => 'required|string|min:10|max:20',
            'nohp' => 'required|string|min:10|max:15',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'kode_prodi' => $request->kode_prodi,
            'status' => 'pending',
            'nip' => $request->nip,
            'nohp' => $request->nohp,
        ]);

        return back()->with('success', 'Pendaftaran berhasil. Menunggu persetujuan admin.');
    }

    // Digunakan oleh routes/auth.php (alias ke store)
    public function signup(Request $request)
    {
        return $this->store($request);
    }
}
