<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Tambahkan ini

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah ada berdasarkan google_id
            $existingUser = User::where('google_id', $googleUser->id)->first();

            if ($existingUser) {
                // Jika ditemukan berdasarkan google_id, login
                Auth::login($existingUser);
            } else {
                // Cek apakah email dari Google sudah terdaftar di database (tanpa google_id)
                $user = User::where('email', $googleUser->email)->first();

                if ($user) {
                    // Jika email ditemukan, artinya akun ini sudah dibuat oleh admin
                    // Update dengan google_id agar bisa login via Google ke depannya
                    $user->google_id = $googleUser->id;
                    $user->save();
                    Auth::login($user);
                } else {
                    // Jika email TIDAK ditemukan, user belum didaftarkan oleh admin
                    // Tolak login atau buat user baru dengan role default (pilih salah satu)
                    // Contoh: Tolak login
                    return redirect('/login')->with('error', 'Akun dengan email ini belum terdaftar oleh admin.');
                    // Contoh alternatif: Buat user baru dengan role default
                    // $newUser = User::create([
                    //     'name' => $googleUser->name,
                    //     'email' => $googleUser->email,
                    //     'google_id' => $googleUser->id,
                    //     'password' => Hash::make('password_dummy_google'), // Tetap hash
                    //     'role' => 'dosen', // Atau role default lain
                    // ]);
                    // Auth::login($newUser);
                }
            }

            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            \Log::error('Google SSO Error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }
}