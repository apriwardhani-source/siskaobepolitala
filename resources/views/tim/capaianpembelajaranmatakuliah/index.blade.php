@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        {{-- Header ala admin CPMK / Tim CPL --}}
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-bullseye text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                        Capaian Pembelajaran Mata Kuliah (CPMK)
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Kelola dan pantau daftar CPMK untuk program studi Anda berdasarkan tahun kurikulum.
                    </p>
                </div>
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div id="alert-success" class="mb-6 rounded-lg bg-green-50 border-l-4 border-green-500 p-4 shadow-sm animate-fade-in">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-green-800">Berhasil!</h3>
                        <p class="mt-1 text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.closest('#alert-success').remove()"
                            class="ml-4 text-green-500 hover:text-green-700 focus:outline-none">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if (session('sukses'))
            <div id="alert-sukses" class="mb-6 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm animate-fade-in">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-red-800">Perhatian!</h3>
                        <p class="mt-1 text-sm text-red-700">{{ session('sukses') }}</p>
                    </div>
                    <button onclick="this.closest('#alert-sukses').remove()"
                            class="ml-4 text-red-500 hover:text-red-700 focus:outline-none">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Kartu Filter CPMK (mirip admin) --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
            <div class="bg-blue-600 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter CPMK
                </h2>
                <div class="flex gap-2">
                    <a href="{{ route('tim.capaianpembelajaranmatakuliah.import') }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-file-excel mr-2"></i>
                        Import Excel
                    </a>
                    <a href="{{ route('tim.capaianpembelajaranmatakuliah.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah CPMK
                    </a>
                </div>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('tim.capaianpembelajaranmatakuliah.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Program Studi</label>
                            <input type="text"
                                   value="{{ $prodiName ?? '-' }}"
                                   class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800"
                                   readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kurikulum</label>
                            <select name="id_tahun"
                                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">Semua</option>
                                @foreach(($tahun_tersedia ?? []) as $t)
                                    <option value="{{ $t->id_tahun }}" {{ ($id_tahun ?? '') == $t->id_tahun ? 'selected' : '' }}>
                                        {{ $t->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="self-end flex gap-2">
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Tampilkan Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @php
            $isFiltered = !empty($id_tahun);
            $cpmkCollection = collect($cpmks ?? []);
        @endphp

        @if(!$isFiltered)
            {{-- Empty state sebelum filter --}}
            <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="w-20 h-20 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                        <i class="fas fa-filter text-3xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
                <p class="text-gray-600 mt-1">
                    Silakan pilih tahun kurikulum untuk menampilkan data CPMK program studi Anda.
                </p>
            </div>
        @elseif($cpmkCollection->isNotEmpty())
            {{-- Tabel Hasil --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Daftar CPMK</h2>
                    <div class="relative w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="search" placeholder="Cari CPMK..."
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg
                                      focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                      placeholder-gray-400 text-sm transition-all duration-200">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700 w-12">No</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700 w-32">Kode CPMK</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Deskripsi</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-700 w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($cpmkCollection as $index => $row)
                                <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            {{ $row->kode_cpmk }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-900">
                                        {{ $row->deskripsi_cpmk }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-center text-sm">
                                        <a href="{{ route('tim.capaianpembelajaranmatakuliah.detail', $row->id_cpmk) }}"
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
        @else
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                <div class="text-sm text-yellow-800">
                    Data CPMK belum tersedia untuk tahun kurikulum yang dipilih.
                </div>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
// Pencarian di tabel
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    if (!searchInput) return;

    searchInput.addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });

    // Auto-hide alerts
    setTimeout(function () {
        ['alert-success', 'alert-sukses'].forEach(function (id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.add('animate-fade-out');
                setTimeout(function () {
                    el.remove();
                }, 300);
            }
        });
    }, 5000);
});
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

