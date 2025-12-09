@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header ala Wadir1 -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-book text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Mata Kuliah</h1>
                    <p class="mt-1 text-sm text-gray-600">Daftar mata kuliah per program studi dan tahun kurikulum (mode baca saja)</p>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success'))
        <div id="alert-success" class="mb-6 rounded-lg bg-green-50 border-l-4 border-green-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-green-800">Berhasil!</h3>
                    <p class="mt-1 text-sm text-green-700">{{ session('success') }}</p>
                </div>
                <button onclick="this.closest('#alert-success').remove()" 
                        class="ml-4 text-green-500 hover:text-green-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if (session('sukses'))
        <div id="alert-sukses" class="mb-6 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-800">Perhatian!</h3>
                    <p class="mt-1 text-sm text-red-700">{{ session('sukses') }}</p>
                </div>
                <button onclick="this.closest('#alert-sukses').remove()" 
                        class="ml-4 text-red-500 hover:text-red-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        <!-- Kartu Filter -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
            <div class="bg-blue-600 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter Mata Kuliah
                </h2>
                {{-- mode read-only: tidak ada tombol tambah --}}
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('admin.matakuliah.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Prodi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Program Studi</label>
                            <select name="kode_prodi" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">Semua Prodi</option>
                                @foreach(($prodis ?? []) as $prodi)
                                  <option value="{{ $prodi->kode_prodi }}" {{ ($kode_prodi ?? '') == $prodi->kode_prodi ? 'selected' : '' }}>
                                      {{ $prodi->nama_prodi }}
                                  </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Tahun -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kurikulum</label>
                            <select name="id_tahun" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">Semua</option>
                                @foreach(($tahun_tersedia ?? []) as $t)
                                  <option value="{{ $t->id_tahun }}" {{ ($id_tahun ?? '') == $t->id_tahun ? 'selected' : '' }}>
                                      {{ $t->tahun }}
                                  </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Actions -->
                        <div class="self-end flex gap-2">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                <i class="fas fa-search mr-2"></i> Tampilkan Data
                            </button>
                            @if(isset($kode_prodi) && $kode_prodi)
                            <a href="{{ route('admin.matakuliah.export', ['kode_prodi'=>($kode_prodi ?? request('kode_prodi')), 'id_tahun'=>($id_tahun ?? request('id_tahun'))]) }}" 
                               class="inline-flex items-center px-4 py-2.5 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                                <i class="fas fa-file-excel mr-2"></i> Export Excel
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @php
            $selectedYear = collect($tahun_tersedia ?? [])->firstWhere('id_tahun', $id_tahun);
            $selectedProdi = collect($prodis ?? [])->firstWhere('kode_prodi', $kode_prodi);
            $isFiltered = !empty($kode_prodi) || !empty($id_tahun);
        @endphp

        @if(!$isFiltered)
            <!-- Empty state sebelum filter -->
            <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="w-20 h-20 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                        <i class="fas fa-filter text-3xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
                <p class="text-gray-600 mt-1">Silakan pilih program studi dan tahun untuk menampilkan data mata kuliah.</p>
            </div>
        @else
            <!-- Filter Aktif -->
            <div class="bg-white rounded-xl shadow border border-gray-200 p-4 mb-6">
                <div class="text-sm text-gray-600 mb-2">Filter aktif:</div>
                <div class="flex flex-wrap gap-2 items-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Angkatan: {{ $selectedYear->tahun ?? 'Semua' }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">
                        <i class="fas fa-university mr-2"></i>
                        {{ $selectedProdi->nama_prodi ?? 'Semua Program Studi' }}
                    </span>
                    <a href="{{ route('admin.matakuliah.index') }}"
                       class="text-red-600 text-sm ml-2">
                        <i class="fas fa-times mr-1"></i>Reset
                    </a>
                </div>
            </div>
        @endif

        @if(isset($kode_prodi) && $kode_prodi!=='' && ($dataKosong ?? false))
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded mb-6">
                <div class="text-sm text-yellow-800">Data mata kuliah belum tersedia untuk filter yang dipilih.</div>
            </div>
        @endif

        <!-- Statistik MK, Angkatan, Program Studi -->
        @if($isFiltered && !$dataKosong && $selectedProdi)
            <!-- Baris Statistik: Total MK, Angkatan, Program Studi (gaya seperti Wadir1) -->
            @php
                $totalMk = ($mata_kuliahs ?? collect())->count();
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Total MK -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-500">
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase">Total MK</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalMk }}</p>
                        </div>
                        <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center text-white">
                            <i class="fas fa-book text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Angkatan / Tahun Kurikulum -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-green-500">
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase">Angkatan</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $selectedYear->tahun ?? '-' }}</p>
                        </div>
                        <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center text-white">
                            <i class="fas fa-calendar text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Program Studi (ringkas) -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-purple-500">
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase">Program Studi</p>
                            <p class="mt-2 text-xl font-bold text-gray-900">{{ $selectedProdi->nama_prodi ?? '-' }}</p>
                        </div>
                        <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center text-white">
                            <i class="fas fa-graduation-cap text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tabel Hasil -->
        @if(($mata_kuliahs ?? collect())->isNotEmpty())
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Mata Kuliah</h2>
                    <div class="relative">
                        <input id="searchMk" type="text" class="pl-9 pr-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Cari MK...">
                        <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table id="tableMk" class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700 w-12">No</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700 w-28">Kode</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Nama</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-700 w-20">SKS</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-700 w-24">Semester</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-700 w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($mata_kuliahs as $index => $mk)
                                <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                            {{ $mk->kode_mk }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-900">
                                        {{ $mk->nama_mk }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-center text-sm font-semibold text-gray-900">
                                        {{ $mk->sks_mk }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-center text-sm text-gray-700">
                                        {{ $mk->semester_mk }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-center text-sm">
                                        <a href="{{ route('admin.matakuliah.detail', $mk->kode_mk) }}"
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-all duration-200"
                                           title="Lihat Detail">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
// Search MK
const sMk = document.getElementById('searchMk');
const tMk = document.getElementById('tableMk');
if (sMk && tMk) {
    sMk.addEventListener('input', function () {
        const q = this.value.toLowerCase();
        tMk.querySelectorAll('tbody tr').forEach(function(tr) {
            const text = tr.innerText.toLowerCase();
            tr.style.display = text.includes(q) ? '' : 'none';
        });
    });
}

// Auto-hide alerts
setTimeout(function() {
    ['alert-success', 'alert-sukses'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('animate-fade-out');
            setTimeout(function() { el.remove(); }, 300);
        }
    });
}, 5000);
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fade-out {
    from { opacity: 1; }
    to { opacity: 0; }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

.animate-fade-out {
    animation: fade-out 0.3s ease-out;
}
</style>
@endpush
@endsection
