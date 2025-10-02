<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function dashboard()
    {
        return view('dashboard'); // pastikan ada view resources/views/dosen/dashboard.blade.php
    }
}
