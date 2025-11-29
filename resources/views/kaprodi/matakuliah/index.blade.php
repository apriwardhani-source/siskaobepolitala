@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-book-open text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Daftar Mata Kuliah</h1>
                    <p class="mt-2 text-sm text-gray-600">Lihat mata kuliah dan kurikulum program studi</p>
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

        @if (session('sukses') || session('error'))
        <div id="alert-error" class="mb-6 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-800">Perhatian!</h3>
                    <p class="mt-1 text-sm text-red-700">{{ session('sukses') ?? session('error') }}</p>
                </div>
                <button onclick="this.closest('#alert-error').remove()" 
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
                        <h2 class="text-lg font-bold">Filter Mata Kuliah</h2>
                        <p class="text-xs text-blue-100">Pilih tahun kurikulum dan cari mata kuliah berdasarkan kata kunci.</p>
                    </div>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="px-6 py-5 border-b border-gray-200 bg-white">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between space-y-4 lg:space-y-0 gap-4">
                    
                    <!-- Filter -->
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-calendar text-green-500 mr-1"></i>
                            Tahun Kurikulum
                        </label>
                        <select id="tahun" name="id_tahun"
                            class="block w-full max-w-xs px-4 py-2.5 border border-gray-300 rounded-lg 
                                   focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="" {{ empty($id_tahun) ? 'selected' : '' }}>Semua Tahun</option>
                            @if (isset($tahun_tersedia))
                                @foreach ($tahun_tersedia as $thn)
                                    <option value="{{ $thn->id_tahun }}" {{ $id_tahun == $thn->id_tahun ? 'selected' : '' }}>
                                        {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Search -->
                    <div class="lg:w-80">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-search text-blue-500 mr-1"></i>
                            Cari Mata Kuliah
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search" placeholder="Cari mata kuliah..." 
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg 
                                          focus:ring-2 focus:ring-blue-500 focus:border-transparent 
                                          placeholder-gray-400 text-sm transition-all duration-200">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3">
                        <button type="button" onclick="updateFilter()"
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

                @php
                    $selectedYear = collect($tahun_tersedia ?? [])->firstWhere('id_tahun', $id_tahun);
                    $isFiltered = !empty($id_tahun);
                    $prodiName = ($mata_kuliahs ?? collect())->first()->nama_prodi ?? (Auth::user()->prodi->nama_prodi ?? '-');
                @endphp

                @if(($mata_kuliahs ?? collect())->isNotEmpty())
                    <!-- Filter aktif + summary cards ala Wadir1 -->
                    <div class="mt-4 space-y-4">
                        <div class="bg-white rounded-xl shadow border border-gray-200 p-4">
                            <div class="text-sm text-gray-600 mb-2">Filter aktif:</div>
                            <div class="flex flex-wrap gap-2 items-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    Angkatan: {{ $selectedYear->tahun ?? '-' }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">
                                    <i class="fas fa-university mr-2"></i>
                                    {{ $prodiName }}
                                </span>
                                <a href="{{ route('kaprodi.matakuliah.index') }}" 
                                   class="text-red-600 text-sm ml-2">
                                    <i class="fas fa-times mr-1"></i>Reset
                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-500">
                                <div class="p-6 flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 uppercase">Total MK</p>
                                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ ($mata_kuliahs ?? collect())->count() }}</p>
                                    </div>
                                    <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center text-white">
                                        <i class="fas fa-book text-2xl"></i>
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
                                        <p class="mt-2 text-xl font-bold text-gray-900">{{ $prodiName }}</p>
                                    </div>
                                    <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center text-white">
                                        <i class="fas fa-graduation-cap text-2xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Content -->
            @if($isFiltered && ($mata_kuliahs ?? collect())->isEmpty())
                <!-- Empty State -->
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Mata Kuliah</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Belum ada mata kuliah untuk program studi ini. Hubungi Admin atau Tim untuk menambahkan data.
                    </p>
                </div>
            @else
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                            <tr>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-16">No</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-28">Kode MK</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Nama Mata Kuliah</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-20">SKS</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-24">Semester</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($mata_kuliahs as $index => $mk)
                            <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                        {{ $mk->kode_mk }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900">
                                    {{ $mk->nama_mk }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-semibold text-gray-900">
                                    {{ $mk->sks_mk }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                                    {{ $mk->semester_mk }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                    <a href="{{ route('kaprodi.matakuliah.detail', $mk->kode_mk) }}" 
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
function updateFilter() {
    const tahunSelect = document.getElementById('tahun');
    const idTahun = tahunSelect.value;

    let url = "{{ route('kaprodi.matakuliah.index') }}";
    
    if (idTahun) {
        url += '?id_tahun=' + encodeURIComponent(idTahun);
    }

    window.location.href = url;
}

// Search functionality
document.getElementById('search').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

// Auto-hide alerts
setTimeout(function() {
    ['alert-success', 'alert-error'].forEach(id => {
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
