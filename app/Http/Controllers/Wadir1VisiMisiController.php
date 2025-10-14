<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Wadir1VisiMisiController extends Controller
{
    public function index()
    {
        $visis = DB::table('visis')->first();

        $misis = $visis ? DB::table('misis')->where('visi_id', $visis->id)->get() : collect();

        $prodis = DB::table('prodis')->get();

        return view('wadir1.visimisi.index', compact('visis', 'misis', 'prodis'));
    }
}
