@extends('layouts.kaprodi.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check-square text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Capaian Profil Lulusan (CPL)</h1>
                    <p class="mt-2 text-sm text-gray-600">Lihat capaian pembelajaran lulusan program studi</p>
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

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <!-- Header Filter -->
            <div class="bg-blue-600 px-6 py-4 flex items-center justify-between text-white">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-500 flex items-center justify-center shadow">
                        <i class="fas fa-filter text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold">Filter CPL</h2>
                        <p class="text-xs text-blue-100">Pilih program studi dan tahun kurikulum untuk menampilkan daftar CPL.</p>
                    </div>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="px-6 py-5 border-b border-gray-200 bg-white">
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between space-y-4 sm:space-y-0">
                    <!-- Filter -->
                    <form id="kaprodi-cpl-filter" method="GET" action="{{ route('kaprodi.capaianpembelajaranlulusan.index') }}" class="flex-1">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-university text-blue-500 mr-1"></i>
                                    Program Studi
                                </label>
                                <select name="kode_prodi"
                                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg 
                                           focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <option value="">Pilih Program Studi</option>
                                    @foreach ($prodis as $prodi)
                                        <option value="{{ $prodi->kode_prodi }}" {{ $kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                                            {{ $prodi->nama_prodi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @if($kode_prodi)
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar text-green-500 mr-1"></i>
                                    Tahun Kurikulum
                                </label>
                                <select name="id_tahun"
                                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg 
                                           focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($tahun_tersedia as $th)
                                        <option value="{{ $th->id_tahun }}" {{ $id_tahun == $th->id_tahun ? 'selected' : '' }}>
                                            {{ $th->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                        </div>
                    </form>

                    <!-- Actions -->
                    <div class="flex gap-3">
                        <button type="submit" form="kaprodi-cpl-filter"
                                class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 
                                       text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg 
                                       transform hover:scale-105 transition-all duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Tampilkan Data
                        </button>
                        <a href="{{ route('kaprodi.export.excel', ['id_tahun' => $id_tahun ?? request('id_tahun')]) }}"
                           class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                            <i class="fas fa-file-excel mr-2"></i>
                            Export Excel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content diselaraskan dengan tampilan Wadir1 -->
            @php
                $selectedYear = collect($tahun_tersedia ?? [])->firstWhere('id_tahun', $id_tahun);
                $isFiltered = !empty($kode_prodi) || !empty($id_tahun);
            @endphp

            @if(!$isFiltered)
                <!-- Empty State - belum pilih filter -->
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Pilih Filter</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Silakan pilih tahun kurikulum untuk menampilkan data CPL program studi Anda.
                    </p>
                </div>
            @elseif(isset($dataKosong) && $dataKosong)
                <!-- Empty State - No Data -->
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Data CPL</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Belum ada Capaian Profil Lulusan untuk kombinasi filter yang dipilih.
                    </p>
                </div>
            @else
                <!-- Filter aktif + summary cards -->
                <div class="mb-6 space-y-4">
                    <div class="bg-white rounded-xl shadow border border-gray-200 p-4">
                        <div class="text-sm text-gray-600 mb-2">Filter aktif:</div>
                        <div class="flex flex-wrap gap-2 items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                Angkatan: {{ $selectedYear->tahun ?? 'Semua' }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">
                                <i class="fas fa-university mr-2"></i>
                                {{ $capaianpembelajaranlulusans->first()->nama_prodi ?? 'Program Studi' }}
                            </span>
                            <a href="{{ route('kaprodi.capaianpembelajaranlulusan.index') }}" class="text-red-600 text-sm ml-2">
                                <i class="fas fa-times mr-1"></i>Reset
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-500">
                            <div class="p-6 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 uppercase">Total CPL</p>
                                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $capaianpembelajaranlulusans->count() }}</p>
                                </div>
                                <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center text-white">
                                    <i class="fas fa-check-square text-2xl"></i>
                                </div>
                            </div>
                        </div>
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
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-purple-500">
                            <div class="p-6 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 uppercase">Program Studi</p>
                                    <p class="mt-2 text-xl font-bold text-gray-900">
                                        {{ $capaianpembelajaranlulusans->first()->nama_prodi ?? '-' }}
                                    </p>
                                </div>
                                <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center text-white">
                                    <i class="fas fa-graduation-cap text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                            <tr>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider w-16">No</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Kode CPL</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Deskripsi</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider w-40">Program Studi</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider w-28">Tahun</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider w-40">Status</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($capaianpembelajaranlulusans as $index => $cpl)
                            <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $cpl->kode_cpl }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">
                                    {{ Str::limit($cpl->deskripsi_cpl, 100) }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $cpl->nama_prodi ?? '-' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $cpl->tahun ?? '-' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @php
                                        $status = $cpl->status_cpl;
                                        $statusLabel = $status === 'Kompetensi Utama Bidang'
                                            ? 'Utama'
                                            : ($status === 'Kompetensi Tambahan' ? 'Tambahan' : '-');
                                        $statusClass = $status === 'Kompetensi Utama Bidang'
                                            ? 'bg-green-100 text-green-800'
                                            : ($status === 'Kompetensi Tambahan' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-600');
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-center">
                                    <a href="{{ route('kaprodi.capaianpembelajaranlulusan.detail', $cpl->id_cpl) }}" 
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
            @endif

        </div>
    </div>
</div>

@push('scripts')
<script>
setTimeout(function() {
    ['alert-success', 'alert-sukses'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('animate-fade-out');
            setTimeout(() => el.remove(), 300);
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
