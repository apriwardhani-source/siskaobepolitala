@extends('layouts.wadir1.app')

@section('title', 'Dashboard Wadir 1')

@section('content')

<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard Kurikulum OBE - Wadir 1</h1>
            <p class="mt-2 text-sm text-gray-600">Monitoring progress implementasi kurikulum berbasis Outcome-Based Education per Program Studi</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-500 transform hover:scale-105 transition-all duration-200">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Program Studi</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $prodicount }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-graduation-cap text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-green-500 transform hover:scale-105 transition-all duration-200">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Sudah Selesai</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $ProdiSelesai }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-check-circle text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-amber-500 transform hover:scale-105 transition-all duration-200">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Dalam Progress</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $ProdiProgress }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-amber-500 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-spinner text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-red-500 transform hover:scale-105 transition-all duration-200">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Belum Dimulai</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $ProdiBelumMulai }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-red-500 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-exclamation-circle text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center"><i class="fas fa-filter mr-2"></i>Filter Dashboard</h2>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('wadir1.dashboard') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kurikulum</label>
                            <select name="tahun_progress" required class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="" disabled {{ empty($tahun_progress) ? 'selected' : '' }}>Pilih Tahun</option>
                                @foreach ($availableYears as $th)
                                    <option value="{{ $th->id_tahun }}" {{ $tahun_progress == $th->id_tahun ? 'selected' : '' }}>{{ $th->tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Program Studi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-search text-gray-400"></i></div>
                                <input type="text" id="search-prodi-dashboard" placeholder="Cari prodi..." class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400 text-sm transition-all duration-200">
                            </div>
                        </div>
                        <div class="flex items-end gap-3">
                            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200"><i class="fas fa-search mr-2"></i> Tampilkan Data</button>
                            <button type="submit" formaction="{{ route('wadir1.export.excel') }}" class="inline-flex items-center px-4 py-2.5 bg-green-600 text-white rounded-lg shadow hover:bg-green-700"><i class="fas fa-file-excel mr-2"></i> Export Excel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Progress Section -->
        @if (request()->filled('tahun_progress'))
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gray-800 px-6 py-5">
                    <h2 class="text-xl font-bold text-white">Progress Penyusunan Kurikulum OBE</h2>
                    <p class="mt-1 text-sm text-gray-300">Tahun Kurikulum: {{ $availableYears->firstWhere('id_tahun', request('tahun_progress'))->tahun ?? '-' }}</p>
                </div>

                <div class="p-6" id="tahunProgress">
                    <!-- Target Info Box -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-5 mb-8">
                        <h4 class="font-semibold text-blue-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Target Standar Kurikulum OBE
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-blue-600">9</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">CPL</div>
                                <div class="text-xs text-gray-500">Capaian Profil Lulusan</div>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-blue-600">48</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">Mata Kuliah</div>
                                <div class="text-xs text-gray-500">Jumlah Mata Kuliah</div>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-blue-600">144</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">Total SKS</div>
                                <div class="text-xs text-gray-500">Mata Kuliah (D4)</div>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-blue-600">20</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">CPMK</div>
                                <div class="text-xs text-gray-500">Capaian Pembelajaran MK</div>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-blue-600">40</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">Sub CPMK</div>
                                <div class="text-xs text-gray-500">Indikator Pencapaian</div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Cards -->
                    <div class="space-y-6">
                        @foreach ($prodis as $prodi)
                        <div class="prodi-card bg-gray-50 rounded-lg p-6 border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $prodi->nama_prodi }}</h3>
                                <div class="flex items-center space-x-3">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                                                 {{ $prodi->avg_progress >= 80 ? 'bg-green-100 text-green-800' : 
                                                    ($prodi->avg_progress >= 50 ? 'bg-amber-100 text-amber-800' : 
                                                    'bg-red-100 text-red-800') }}">
                                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $prodi->avg_progress }}% Selesai
                                    </span>
                                </div>
                            </div>

                            <!-- Main Progress Bar -->
                            <div class="mb-5">
                                <div class="flex justify-between text-xs text-gray-600 mb-2">
                                    <span>Progress Keseluruhan</span>
                                    <span class="font-semibold">{{ $prodi->avg_progress }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500 
                                                {{ $prodi->avg_progress >= 80 ? 'bg-green-500' : 
                                                   ($prodi->avg_progress >= 50 ? 'bg-amber-500' : 
                                                   'bg-red-500') }}"
                                         style="width: {{ $prodi->avg_progress }}%">
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Progress -->
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                <div class="bg-white rounded-lg p-3 border border-blue-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                        <span class="text-xs font-semibold text-blue-600">{{ $prodi->progress_cpl }}%</span>
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $prodi->cpl_count }}/9</div>
                                    <div class="text-xs text-gray-600">CPL</div>
                                </div>

                                <div class="bg-white rounded-lg p-3 border border-green-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                        <span class="text-xs font-semibold text-green-600">{{ $prodi->progress_mk }}%</span>
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $prodi->mk_count }}/48</div>
                                    <div class="text-xs text-gray-600">Mata Kuliah</div>
                                </div>

                                <div class="bg-white rounded-lg p-3 border border-amber-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
                                        <span class="text-xs font-semibold text-amber-600">{{ $prodi->progress_sks_mk }}%</span>
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $prodi->sks_mk }}/144</div>
                                    <div class="text-xs text-gray-600">Total SKS</div>
                                </div>

                                <div class="bg-white rounded-lg p-3 border border-orange-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="w-3 h-3 bg-orange-500 rounded-full"></span>
                                        <span class="text-xs font-semibold text-orange-600">{{ $prodi->progress_cpmk }}%</span>
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $prodi->cpmk_count }}/20</div>
                                    <div class="text-xs text-gray-600">CPMK</div>
                                </div>

                                <div class="bg-white rounded-lg p-3 border border-red-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                                        <span class="text-xs font-semibold text-red-600">{{ $prodi->progress_subcpmk }}%</span>
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $prodi->subcpmk_count }}/40</div>
                                    <div class="text-xs text-gray-600">Sub CPMK</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State (tanpa tombol) -->
            <div class="bg-white rounded-xl shadow border border-gray-200 p-12 text-center mb-8">
                <div class="flex justify-center mb-2">
                    <div class="w-16 h-16 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                        <svg class="w-9 h-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M4 20h16" stroke-width="1.5" stroke-linecap="round"/>
                            <rect x="5" y="12" width="3" height="6" rx="1.5" fill="currentColor"/>
                            <rect x="10.5" y="9" width="3" height="9" rx="1.5" fill="currentColor"/>
                            <rect x="16" y="6" width="3" height="12" rx="1.5" fill="currentColor"/>
                        </svg>
                    </div>
                </div>
                <h3 class="mt-6 text-xl font-semibold text-gray-900">Pilih Tahun Progress</h3>
                <p class="mt-2 text-sm text-gray-600 max-w-xl mx-auto">
                    Silakan gunakan "Filter Dashboard" di atas untuk memilih tahun dan menampilkan data.
                </p>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
// Search functionality
document.getElementById('search-prodi-dashboard').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const cards = document.querySelectorAll('.prodi-card');

    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(searchValue) ? '' : 'none';
    });
});
</script>
@endpush

@endsection
