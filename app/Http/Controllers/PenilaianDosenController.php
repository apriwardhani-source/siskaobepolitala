<?php

namespace App\Http\Controllers;

use App\Models\NilaiMahasiswa;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TeknikPenilaian;
use App\Models\CapaianProfilLulusan;
use App\Models\CapaianPembelajaranMataKuliah;
use App\Models\Tahun;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Create nilai
        $nilai = NilaiMahasiswa::create(array_merge(
            $request->all(),
            ['user_id' => Auth::id()]
        ));

        // Load relationships untuk notifikasi
        $nilai->load(['mahasiswa', 'mataKuliah', 'teknikPenilaian', 'tahun']);

        // Kirim notifikasi WhatsApp ke admin
        try {
            $whatsappService = new WhatsAppService();
            $whatsappService->sendNilaiNotification([
                'dosen_name' => Auth::user()->name,
                'mata_kuliah' => $nilai->mataKuliah->nama_mk ?? 'N/A',
                'kode_mk' => $nilai->kode_mk,
                'mahasiswa_name' => $nilai->mahasiswa->nama ?? 'N/A',
                'nim' => $nilai->nim,
                'teknik_penilaian' => $nilai->teknikPenilaian->nama_teknik ?? 'N/A',
                'nilai' => $nilai->nilai,
                'tahun' => $nilai->tahun->tahun ?? 'N/A',
            ]);
        } catch (\Exception $e) {
            // Log error tapi jangan block proses
            \Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }

        return redirect()->route('dosen.penilaian.index')->with('success', 'Nilai berhasil ditambahkan dan notifikasi terkirim ke admin');
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

        $nilaiList = [];

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
                        'user_id' => Auth::id(),
                    ]
                );

                // Collect untuk notifikasi
                $teknik = TeknikPenilaian::find($teknik_id);
                $nilaiList[] = [
                    'teknik' => $teknik->nama_teknik ?? "Teknik #{$teknik_id}",
                    'nilai' => $nilai_data[$teknik_id]
                ];
            }
        }

        // Kirim notifikasi WhatsApp bulk ke admin
        if (!empty($nilaiList)) {
            try {
                $mahasiswa = Mahasiswa::where('nim', $nim)->first();
                $mataKuliah = MataKuliah::where('kode_mk', $kode_mk)->first();
                $tahunData = Tahun::find($tahun);

                $whatsappService = new WhatsAppService();
                $whatsappService->sendBulkNilaiNotification([
                    'dosen_name' => Auth::user()->name,
                    'mata_kuliah' => $mataKuliah->nama_mk ?? 'N/A',
                    'kode_mk' => $kode_mk,
                    'mahasiswa_name' => $mahasiswa->nama ?? 'N/A',
                    'nim' => $nim,
                    'tahun' => $tahunData->tahun ?? 'N/A',
                    'nilai_list' => $nilaiList,
                ]);
            } catch (\Exception $e) {
                // Log error tapi jangan block proses
                \Log::error('WhatsApp bulk notification failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('dosen.penilaian.index', ['kode_mk' => $kode_mk, 'tahun' => $tahun])->with('success', 'Nilai berhasil ditambahkan dan notifikasi terkirim ke admin');
    }
}