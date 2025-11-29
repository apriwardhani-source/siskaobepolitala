@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header ala Wadir1 -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-diagram-project text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pemetaan CPL - CPMK - MK</h1>
                    <p class="mt-1 text-sm text-gray-600">Relasi CPL ke CPMK dan Mata Kuliah</p>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
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

        @if(session('sukses'))
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
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </h2>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('admin.pemetaancplcpmkmk.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-university text-blue-500 mr-1"></i>
                                Program Studi
                            </label>
                            <select name="kode_prodi" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">Semua Prodi</option>
                                @foreach(($prodis ?? []) as $p)
                                  <option value="{{ $p->kode_prodi }}" {{ ($kode_prodi ?? '')==$p->kode_prodi ? 'selected' : '' }}>
                                      {{ $p->nama_prodi }}
                                  </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar text-green-500 mr-1"></i>
                                Tahun Kurikulum
                            </label>
                            <select name="id_tahun" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">Semua</option>
                                @foreach(($tahun_tersedia ?? []) as $t)
                                  <option value="{{ $t->id_tahun }}" {{ ($id_tahun ?? '')==$t->id_tahun ? 'selected' : '' }}>
                                      {{ $t->tahun }}
                                  </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="self-end flex gap-2">
                            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Tampilkan Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @php $isFiltered = !empty($kode_prodi) || !empty($id_tahun); @endphp

        @if(!$isFiltered)
            <!-- Empty state sebelum filter -->
            <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="w-20 h-20 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                        <i class="fas fa-filter text-3xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
                <p class="text-gray-600 mt-1">Silakan pilih program studi dan tahun untuk menampilkan data pemetaan.</p>
            </div>
        @elseif(isset($kode_prodi) && $kode_prodi!=='' && ($dataKosong ?? false))
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded mb-8">
                <div class="text-sm text-yellow-800">Data kosong untuk filter yang dipilih.</div>
            </div>
        @endif

        @if($isFiltered && !empty($matrix))
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-[#1e3c72] to-[#2a5298] text-white sticky top-0 z-10">
                            <tr>
                                <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider border-r border-[#2a5298]">
                                    <div class="flex items-center">
                                        <i class="fas fa-bullseye mr-2"></i>
                                        Kode CPL
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider border-r border-[#2a5298] w-96">
                                    <div class="flex items-center">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Deskripsi CPL
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider border-r border-[#2a5298] w-32">
                                    <div class="flex items-center">
                                        <i class="fas fa-list-ol mr-2"></i>
                                        Kode CPMK
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider border-r border-[#2a5298]">
                                    <div class="flex items-center">
                                        <i class="fas fa-align-left mr-2"></i>
                                        Deskripsi CPMK
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-book mr-2"></i>
                                        Mata Kuliah
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($matrix as $kode_cpl => $cpl)
                                @php
                                    $cpmk_count = isset($cpl['cpmk']) ? count($cpl['cpmk']) : 1;
                                    $first = true;
                                @endphp

                                @if(isset($cpl['cpmk']) && !empty($cpl['cpmk']))
                                    @foreach ($cpl['cpmk'] as $kode_cpmk => $cpmk)
                                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                                            @if ($first)
                                                <td class="px-4 py-4 border-r border-gray-200 align-top bg-gradient-to-r from-blue-50 to-transparent" rowspan="{{ $cpmk_count }}">
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-sm">
                                                        {{ $kode_cpl }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-4 border-r border-gray-200 text-sm text-gray-700 align-top leading-relaxed" rowspan="{{ $cpmk_count }}">
                                                    {{ $cpl['deskripsi'] ?? '-' }}
                                                </td>
                                                @php $first = false; @endphp
                                            @endif

                                            <td class="px-4 py-4 border-r border-gray-200">
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-sm">
                                                    {{ $kode_cpmk }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 border-r border-gray-200 text-sm text-gray-700 leading-relaxed">
                                                {{ $cpmk['deskripsi'] ?? '-' }}
                                            </td>
                                            <td class="px-4 py-4">
                                                @if(isset($cpmk['mk']) && !empty($cpmk['mk']))
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach (array_unique($cpmk['mk']) as $mk)
                                                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-green-500 to-green-600 text-white shadow-sm">
                                                                {{ $mk }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-sm">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                                        <td class="px-4 py-4 border-r border-gray-200 align-top bg-gradient-to-r from-blue-50 to-transparent">
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-sm">
                                                {{ $kode_cpl }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 border-r border-gray-200 text-sm text-gray-700 leading-relaxed">
                                            {{ $cpl['deskripsi'] ?? '-' }}
                                        </td>
                                        <td class="px-4 py-4 border-r border-gray-200 text-center text-sm text-gray-400">-</td>
                                        <td class="px-4 py-4 border-r border-gray-200 text-sm text-gray-400">-</td>
                                        <td class="px-4 py-4 text-sm text-gray-400">-</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</div>

@push('styles')
<style>
.overflow-x-auto {
  scrollbar-width: thin;
  scrollbar-color: #cbd5e0 #f7fafc;
}

.overflow-x-auto::-webkit-scrollbar {
  height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
  background: #f7fafc;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
  background-color: #cbd5e0;
  border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
  background-color: #a0aec0;
}
</style>
@endpush

@push('scripts')
<script>
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
@endpush
@endsection

