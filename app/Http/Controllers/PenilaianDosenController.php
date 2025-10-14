<?php

namespace App\Http\Controllers;

use App\Models\NilaiMahasiswa;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TeknikPenilaian;
use App\Models\CapaianProfilLulusan;
use App\Models\CapaianPembelajaranMataKuliah;
use App\Models\Tahun;
use Illuminate\Http\Request;

class PenilaianDosenController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->tahun;
        $kode_mk = $request->kode_mk;
        $nim = $request->nim;
        
        $query = NilaiMahasiswa::query();
        
        if ($tahun) {
            $query->where('id_tahun', $tahun);
        }
        
        if ($kode_mk) {
            $query->where('kode_mk', $kode_mk);
        }
        
        if ($nim) {
            $query->where('nim', $nim);
        }
        
        $nilais = $query->with(['mahasiswa', 'mataKuliah', 'teknikPenilaian', 'cpl', 'cpmk', 'tahun'])->get();
        $tahun_options = Tahun::all();
        $mata_kuliahs = MataKuliah::all();
        $mahasiswas = Mahasiswa::all();
        
        return view('dosen.penilaian.index', compact('nilais', 'tahun_options', 'mata_kuliahs', 'mahasiswas', 'tahun', 'kode_mk', 'nim'));
    }

    public function create($kode_mk = null)
    {
        $tahun = Tahun::all();
        $mahasiswa = Mahasiswa::all();
        $mata_kuliah = $kode_mk ? MataKuliah::where('kode_mk', $kode_mk)->first() : null;
        $teknik_penilaian = TeknikPenilaian::where('kode_mk', $kode_mk)->get();
        $cpls = CapaianProfilLulusan::all();
        $cpmks = CapaianPembelajaranMataKuliah::all();
        
        return view('dosen.penilaian.create', compact('tahun', 'mahasiswa', 'mata_kuliah', 'teknik_penilaian', 'cpls', 'cpmks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'kode_mk' => 'required',
            'id_teknik' => 'required',
            'nilai' => 'required|numeric|min:0|max:100',
            'id_tahun' => 'required',
        ]);

        NilaiMahasiswa::create($request->all());

        return redirect()->route('dosen.penilaian.index')->with('success', 'Nilai berhasil ditambahkan');
    }

    public function edit($id)
    {
        $nilai = NilaiMahasiswa::findOrFail($id);
        $tahun = Tahun::all();
        $mahasiswa = Mahasiswa::all();
        $mata_kuliah = MataKuliah::all();
        $teknik_penilaian = TeknikPenilaian::where('kode_mk', $nilai->kode_mk)->get();
        $cpls = CapaianProfilLulusan::all();
        $cpmks = CapaianPembelajaranMataKuliah::all();
        
        return view('dosen.penilaian.edit', compact('nilai', 'tahun', 'mahasiswa', 'mata_kuliah', 'teknik_penilaian', 'cpls', 'cpmks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nim' => 'required',
            'kode_mk' => 'required',
            'id_teknik' => 'required',
            'nilai' => 'required|numeric|min:0|max:100',
            'id_tahun' => 'required',
        ]);

        $nilai = NilaiMahasiswa::findOrFail($id);
        $nilai->update($request->all());

        return redirect()->route('dosen.penilaian.index')->with('success', 'Nilai berhasil diperbarui');
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'kode_mk' => 'required',
            'teknik_penilaian' => 'required|array',
            'teknik_penilaian.*' => 'exists:teknik_penilaian,id_teknik',
            'nilai.*' => 'required|numeric|min:0|max:100',
        ]);

        $nilai_data = $request->nilai;
        $teknik_penilaian_ids = $request->teknik_penilaian;
        $tahun = $request->tahun;
        $kode_mk = $request->kode_mk;
        $nim = $request->nim;

        foreach ($teknik_penilaian_ids as $index => $teknik_id) {
            if (isset($nilai_data[$teknik_id]) && $nilai_data[$teknik_id] !== null) {
                NilaiMahasiswa::updateOrCreate(
                    [
                        'nim' => $nim,
                        'kode_mk' => $kode_mk,
                        'id_teknik' => $teknik_id,
                        'id_tahun' => $tahun,
                    ],
                    [
                        'nilai' => $nilai_data[$teknik_id],
                    ]
                );
            }
        }

        return redirect()->route('dosen.penilaian.index', ['kode_mk' => $kode_mk, 'tahun' => $tahun])->with('success', 'Nilai berhasil ditambahkan');
    }
}