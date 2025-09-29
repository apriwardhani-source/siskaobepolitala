<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Impor facade Auth

class DashboardController extends Controller
{
    public function index()
    {
        // Karena route dilindungi oleh middleware 'auth', kita tahu user sudah login
        // View dashboard.blade.php akan menampilkan konten berdasarkan role user
        return view('dashboard');
    }
}