@extends('layouts.app')

@section('title', 'Hasil OBE - Daftar Mahasiswa')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Hasil OBE</h1>
                    <p class="mt-1 text-sm text-gray-600">Hasil Capaian Pembelajaran Mahasiswa (Outcome-Based Education)</p>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter Mahasiswa
                </h2>
            </div>
            
            <div class="p-6">
                <form method="GET" action="{{ route('admin.hasilobe.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Program Studi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-university text-blue-500 mr-1"></i>
                                Program Studi
                            </label>
                            <select name="kode_prodi" 
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg 
                                       focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">Semua Prodi</option>
                                @foreach($prodi_options as $prodi)
                                    <option value="{{ $prodi->kode_prodi }}" {{ $kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                                        {{ $prodi->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tahun Angkatan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar text-green-500 mr-1"></i>
                                Tahun Angkatan
                            </label>
                            <select name="tahun_angkatan" required
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg 
                                       focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">Pilih Tahun Angkatan</option>
                                @foreach($tahun_options as $tahun)
                                    <option value="{{ $tahun->tahun }}" {{ $tahun_angkatan == $tahun->tahun ? 'selected' : '' }}>
                                        {{ $tahun->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Button -->
                        <div class="flex items-end">
                            <button type="submit" 
                                class="w-full px-6 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 
                                       text-white font-semibold rounded-lg shadow-md hover:shadow-lg 
                                       transform hover:scale-105 transition-all duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Tampilkan Data
                            </button>
                        </div>
                    </div>
                    
                    <!-- Active Filters -->
                    @if($tahun_angkatan || $kode_prodi)
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex flex-wrap gap-2 items-center">
                            <span class="text-sm text-gray-600 font-medium">Filter aktif:</span>
                            @if($tahun_angkatan)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Angkatan: {{ $tahun_angkatan }}
                                </span>
                            @endif
                            @if($kode_prodi)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                    <i class="fas fa-university mr-1"></i>
                                    {{ $prodi_options->where('kode_prodi', $kode_prodi)->first()->nama_prodi ?? 'Prodi' }}
                                </span>
                            @endif
                            <a href="{{ route('admin.hasilobe.index') }}" 
                               class="text-xs text-red-600 hover:text-red-800 hover:underline font-medium">
                                <i class="fas fa-times mr-1"></i>
                                Reset
                            </a>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Data Mahasiswa -->
        @if($mahasiswas->isNotEmpty())
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase">Total Mahasiswa</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $mahasiswas->count() }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-users text-blue-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase">Angkatan</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $tahun_angkatan }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-purple-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase">Program Studi</p>
                                <p class="mt-2 text-lg font-bold text-gray-900">
                                    {{ $kode_prodi ? ($prodi_options->where('kode_prodi', $kode_prodi)->first()->nama_prodi ?? 'Semua') : 'Semua Prodi' }}
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mahasiswa Cards -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-white">Daftar Mahasiswa</h2>
                        <div class="relative">
                            <input type="text" id="searchMahasiswa" placeholder="Cari mahasiswa..." 
                                   class="px-4 py-2 pr-10 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-gray-200">
                    @foreach($mahasiswas as $mahasiswa)
                    <div class="mahasiswa-item hover:bg-blue-50 transition-colors duration-150">
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center space-x-4 flex-1">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        {{ strtoupper(substr($mahasiswa->nama, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-semibold text-gray-900">{{ $mahasiswa->nama }}</h3>
                                    <div class="mt-1 flex items-center space-x-4 text-xs text-gray-500">
                                        <span class="flex items-center">
                                            <i class="fas fa-id-card mr-1"></i>
                                            {{ $mahasiswa->nim }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-university mr-1"></i>
                                            {{ $mahasiswa->prodi->nama_prodi ?? '-' }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar mr-1"></i>
                                            Angkatan {{ $mahasiswa->tahun_kurikulum }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('admin.hasilobe.detail', $mahasiswa->nim) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 
                                          text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg 
                                          transform hover:scale-105 transition-all duration-200">
                                    <i class="fas fa-chart-bar mr-2"></i>
                                    Lihat Hasil OBE
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        @elseif($tahun_angkatan)
            <!-- Empty State - No Data Found -->
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-users-slash text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak Ada Data Mahasiswa</h3>
                <p class="text-sm text-gray-500 mb-6">
                    Tidak ditemukan mahasiswa untuk angkatan {{ $tahun_angkatan }}
                    {{ $kode_prodi ? 'di prodi ' . ($prodi_options->where('kode_prodi', $kode_prodi)->first()->nama_prodi ?? '') : '' }}.
                </p>
                <a href="{{ route('admin.hasilobe.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
                    <i class="fas fa-redo mr-2"></i>
                    Coba Lagi
                </a>
            </div>
        @else
            <!-- Empty State - No Filter -->
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-filter text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Pilih Filter</h3>
                <p class="text-sm text-gray-500">
                    Silakan pilih tahun angkatan dan program studi untuk menampilkan data mahasiswa.
                </p>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
// Search functionality
document.getElementById('searchMahasiswa')?.addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const items = document.querySelectorAll('.mahasiswa-item');

    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(searchValue) ? '' : 'none';
    });
});
</script>
@endpush

@endsection
