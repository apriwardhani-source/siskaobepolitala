<?php

namespace App\Http\Controllers;

use App\Models\TeknikPenilaian;
use App\Models\MataKuliah;
use App\Models\CapaianProfilLulusan;
use App\Models\CapaianPembelajaranMataKuliah;
use App\Models\Tahun;
use Illuminate\Http\Request;

class TeknikPenilaianController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->tahun;
        $kode_mk = $request->kode_mk;
        
        $query = TeknikPenilaian::query();
        
        if ($tahun) {
            $query->where('id_tahun', $tahun);
        }
        
        if ($kode_mk) {
            $query->where('kode_mk', $kode_mk);
        }
        
        $teknik_penilaians = $query->with(['mataKuliah', 'cpl', 'cpmk', 'tahun'])->get();
        $tahun_options = Tahun::all();
        $mata_kuliahs = MataKuliah::all();
        
        return view('dosen.teknik_penilaian.index', compact('teknik_penilaians', 'tahun_options', 'mata_kuliahs', 'tahun', 'kode_mk'));
    }

    public function create($kode_mk = null)
    {
        $tahun = Tahun::all();
        $mata_kuliah = MataKuliah::all();
        $cpls = CapaianProfilLulusan::all();
        $cpmks = CapaianPembelajaranMataKuliah::all();
        
        if ($kode_mk) {
            $mata_kuliah_selected = MataKuliah::where('kode_mk', $kode_mk)->first();
        } else {
            $mata_kuliah_selected = null;
        }
        
        return view('dosen.teknik_penilaian.create', compact('tahun', 'mata_kuliah', 'cpls', 'cpmks', 'mata_kuliah_selected'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_teknik' => 'required',
            'kode_mk' => 'required',
            'id_tahun' => 'required',
        ]);

        TeknikPenilaian::create($request->all());

        return redirect()->route('dosen.teknik_penilaian.index')->with('success', 'Teknik penilaian berhasil ditambahkan');
    }

    public function edit($id)
    {
        $teknik = TeknikPenilaian::findOrFail($id);
        $tahun = Tahun::all();
        $mata_kuliah = MataKuliah::all();
        $cpls = CapaianProfilLulusan::all();
        $cpmks = CapaianPembelajaranMataKuliah::all();
        
        return view('dosen.teknik_penilaian.edit', compact('teknik', 'tahun', 'mata_kuliah', 'cpls', 'cpmks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_teknik' => 'required',
            'kode_mk' => 'required',
            'id_tahun' => 'required',
        ]);

        $teknik = TeknikPenilaian::findOrFail($id);
        $teknik->update($request->all());

        return redirect()->route('dosen.teknik_penilaian.index')->with('success', 'Teknik penilaian berhasil diperbarui');
    }

    public function destroy($id)
    {
        $teknik = TeknikPenilaian::findOrFail($id);
        $teknik->delete();

        return redirect()->route('dosen.teknik_penilaian.index')->with('success', 'Teknik penilaian berhasil dihapus');
    }
}