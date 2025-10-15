@extends('layouts.dosen.app')

@section('title', 'Penilaian Mahasiswa')

@section('content')
<div class="bg-white p-4 md:p-6 lg:p-8 rounded-lg shadow-md">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Penilaian Mahasiswa</h1>
        <p class="text-gray-600 mt-2">Input nilai akhir mahasiswa per mata kuliah</p>
        <hr class="border-t-4 border-black my-5">
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white px-4 py-3 rounded-md mb-6 relative">
            <span class="font-bold">{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'"
                class="absolute top-2 right-3 text-white font-bold text-lg">
                &times;
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-500 text-white px-4 py-3 rounded-md mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Filter Form -->
    <div class="bg-gray-50 p-6 rounded-lg shadow mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Pilih Mata Kuliah & Tahun Kurikulum</h2>
        <form method="GET" action="{{ route('dosen.penilaian.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="kode_mk" class="block text-sm font-semibold text-gray-700 mb-2">Mata Kuliah</label>
                <select name="kode_mk" id="kode_mk" class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Pilih Mata Kuliah --</option>
                    @foreach($mataKuliahs as $mk)
                        <option value="{{ $mk->kode_mk }}" {{ $selectedMK && $selectedMK->kode_mk == $mk->kode_mk ? 'selected' : '' }}>
                            {{ $mk->kode_mk }} - {{ $mk->nama_mk }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="id_tahun" class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kurikulum</label>
                <select name="id_tahun" id="id_tahun" class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Pilih Tahun --</option>
                    @foreach($tahunKurikulums as $tahun)
                        <option value="{{ $tahun->id_tahun }}" {{ $selectedTahun == $tahun->id_tahun ? 'selected' : '' }}>
                            {{ $tahun->tahun }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-800 text-white font-bold px-6 py-2 rounded-md">
                    <i class="bi bi-search mr-2"></i>Tampilkan Mahasiswa
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Nilai Mahasiswa -->
    @if($mahasiswas !== null)
        @if($mahasiswas->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Daftar Mahasiswa</h2>
                        <p class="text-sm text-gray-600">
                            MK: <span class="font-semibold">{{ $selectedMK->nama_mk }}</span> | 
                            Jumlah: <span class="font-semibold">{{ $mahasiswas->count() }} mahasiswa</span>
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('dosen.penilaian.store') }}">
                    @csrf
                    <input type="hidden" name="kode_mk" value="{{ $selectedMK->kode_mk }}">
                    <input type="hidden" name="id_tahun" value="{{ $selectedTahun }}">

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="px-4 py-3 text-center text-sm font-semibold">No</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">NIM</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Nama Mahasiswa</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold">Tahun Kurikulum</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold">Nilai Akhir (0-100)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($mahasiswas as $index => $mhs)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-4 text-center text-sm">{{ $index + 1 }}</td>
                                        <td class="px-4 py-4 text-sm font-medium">{{ $mhs->nim }}</td>
                                        <td class="px-4 py-4 text-sm">{{ $mhs->nama_mahasiswa }}</td>
                                        <td class="px-4 py-4 text-center text-sm">
                                            {{ $mhs->tahunKurikulum ? $mhs->tahunKurikulum->tahun : '-' }}
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <input type="number" 
                                                name="nilai[{{ $mhs->nim }}]" 
                                                value="{{ $mhs->nilai_akhir }}" 
                                                min="0" 
                                                max="100" 
                                                step="0.01"
                                                class="w-24 border border-gray-300 px-3 py-2 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="0-100">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-between items-center">
                        <p class="text-sm text-gray-600 italic">
                            * Nilai harus antara 0 - 100. Kosongkan jika belum ada nilai.
                        </p>
                        <button type="submit" class="bg-green-600 hover:bg-green-800 text-white font-bold px-6 py-3 rounded-md">
                            <i class="bi bi-save mr-2"></i>Simpan Semua Nilai
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="bi bi-exclamation-triangle text-yellow-400 text-3xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700 font-semibold">Tidak ada mahasiswa</p>
                        <p class="text-sm text-yellow-700 mt-1">
                            Tidak ditemukan mahasiswa aktif untuk tahun kurikulum yang dipilih.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="bg-blue-50 border-l-4 border-blue-400 p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="bi bi-info-circle text-blue-400 text-3xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700 font-semibold">Petunjuk</p>
                    <p class="text-sm text-blue-700 mt-1">
                        Silakan pilih Mata Kuliah dan Tahun Kurikulum di atas untuk menampilkan daftar mahasiswa.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
