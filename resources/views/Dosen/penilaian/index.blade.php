@extends('layouts.dosen.app')

@section('title', 'Penilaian Mahasiswa')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header (disamakan gaya dengan Kaprodi Pemetaan) -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-pencil-alt text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Penilaian Mahasiswa</h1>
                    <p class="mt-2 text-sm text-gray-600">Input dan kelola nilai akhir mahasiswa per mata kuliah.</p>
                </div>
            </div>
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

        <!-- Kartu utama: Filter + Konten -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <!-- Header Filter -->
            <div class="bg-blue-600 px-6 py-4 flex items-center justify-between text-white">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-500 flex items-center justify-center shadow">
                        <i class="fas fa-filter text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold">Filter Penilaian</h2>
                        <p class="text-xs text-blue-100">Pilih mata kuliah dan tahun kurikulum untuk menampilkan daftar mahasiswa.</p>
                    </div>
                </div>
            </div>

            <!-- Toolbar / Filter Form -->
            <div class="px-6 py-5 border-b border-gray-200 bg-white">
                <form method="GET" action="{{ route('dosen.penilaian.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="kode_mk" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-book mr-1 text-blue-500"></i>Mata Kuliah
                        </label>
                        <select name="kode_mk" id="kode_mk"
                                class="w-full border border-gray-300 px-4 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                required>
                            <option value="">-- Pilih Mata Kuliah --</option>
                            @foreach($mataKuliahs as $mk)
                                <option value="{{ $mk->kode_mk }}" {{ $selectedMK && $selectedMK->kode_mk == $mk->kode_mk ? 'selected' : '' }}>
                                    {{ $mk->kode_mk }} - {{ $mk->nama_mk }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="id_tahun" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-calendar mr-1 text-green-500"></i>Tahun Kurikulum
                        </label>
                        <select name="id_tahun" id="id_tahun"
                                class="w-full border border-gray-300 px-4 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                required>
                            <option value="">-- Pilih Tahun --</option>
                            @foreach($tahunKurikulums as $tahun)
                                <option value="{{ $tahun->id_tahun }}" {{ $selectedTahun == $tahun->id_tahun ? 'selected' : '' }}>
                                    {{ $tahun->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                            <i class="bi bi-search mr-2"></i>Tampilkan Mahasiswa
                        </button>
                    </div>
                </form>
            </div>

            <!-- Konten Penilaian -->
            <div class="p-6 bg-gray-50">
    @if($mahasiswas !== null && $selectedMK !== null)
        @if($mahasiswas->count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
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
                        <table class="min-w-full bg-white border border-gray-200 text-sm divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-700 to-gray-800 text-white">
                                <tr>
                                    <th class="px-4 py-3 text-center font-semibold text-xs uppercase tracking-wider">No</th>
                                    <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">NIM</th>
                                    <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Nama Mahasiswa</th>
                                    <th class="px-4 py-3 text-center font-semibold text-xs uppercase tracking-wider">Tahun Kurikulum</th>
                                    <th class="px-4 py-3 text-center font-semibold text-xs uppercase tracking-wider">Nilai Akhir (0-100)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($mahasiswas as $index => $mhs)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-4 text-center text-sm">{{ $index + 1 }}</td>
                                        <td class="px-4 py-4 text-sm font-medium">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                                {{ $mhs->nim }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-sm">{{ $mhs->nama_mahasiswa }}</td>
                                        <td class="px-4 py-4 text-center text-sm">
                                            @if($mhs->tahunKurikulum)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                    {{ $mhs->tahunKurikulum->tahun }}
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <input type="number" 
                                                name="nilai[{{ $mhs->nim }}]" 
                                                value="{{ $mhs->nilai_akhir }}" 
                                                min="0" 
                                                max="100" 
                                                step="0.01"
                                                class="w-24 border border-gray-300 px-3 py-2 rounded-lg text-center focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                            <i class="bi bi-save mr-2"></i>Simpan Semua Nilai
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg border border-yellow-100">
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
        <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-lg border border-blue-100">
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
            </div> <!-- end content card body -->
        </div> <!-- end main card -->

    </div>
</div>
@endsection
