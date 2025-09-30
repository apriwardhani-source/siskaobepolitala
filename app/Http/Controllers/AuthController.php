<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Impor model User

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Akan kita buat view-nya
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
    $request->session()->regenerate();

    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');   // <= baris ini diarahkan ke route admin
    } elseif ($user->role === 'kaprodi') {
        return redirect()->route('kaprodi.dashboard'); // <= baris ini diarahkan ke route kaprodi
    } else {
        return redirect()->route('home'); // fallback
    }
}


    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Kembali ke halaman login
    }
}