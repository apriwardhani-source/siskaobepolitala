@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard Kurikulum OBE</h1>
            <p class="mt-2 text-sm text-gray-600">Progress implementasi kurikulum berbasis Outcome-Based Education per Program Studi</p>
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
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
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
                            <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
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
                            <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
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
                            <div class="w-14 h-14 bg-gradient-to-br from-red-400 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-exclamation-circle text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                
                <!-- Export Section -->
                @if (Auth::user()->role === 'admin' && isset($prodis))
                <form id="exportForm" action="{{ route('admin.export.excel') }}" method="GET" class="flex-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Program Studi</label>
                            <select name="kode_prodi" id="prodiSelect" required
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg 
                                       focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="" selected disabled>Pilih Prodi</option>
                                @foreach ($prodis as $prodi)
                                    <option value="{{ $prodi->kode_prodi }}">{{ $prodi->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kurikulum</label>
                            <select name="id_tahun" id="tahunSelect" required
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg 
                                       focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="" disabled {{ empty($id_tahun) ? 'selected' : '' }}>Pilih Tahun</option>
                                @foreach ($availableYears as $th)
                                    <option value="{{ $th->id_tahun }}" {{ $id_tahun == $th->id_tahun ? 'selected' : '' }}>
                                        {{ $th->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-2 flex items-end gap-3">
                            <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 
                                       text-white font-medium rounded-lg shadow-sm hover:shadow-md 
                                       transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <i class="fas fa-file-excel mr-2"></i>
                                Export Excel
                            </button>

                            <button type="button" onclick="exportWord()"
                                class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 
                                       text-white font-medium rounded-lg shadow-sm hover:shadow-md 
                                       transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <i class="fas fa-file-word mr-2"></i>
                                Export Word
                            </button>
                        </div>
                    </div>
                </form>
                @else
                <form action="{{ route('tim.export.excel') }}" method="GET" class="flex-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kurikulum</label>
                            <select name="id_tahun" required
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg 
                                       focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="" disabled {{ empty($id_tahun) ? 'selected' : '' }}>Pilih Tahun</option>
                                @foreach ($availableYears as $th)
                                    <option value="{{ $th->id_tahun }}" {{ $id_tahun == $th->id_tahun ? 'selected' : '' }}>
                                        {{ $th->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 
                                       text-white font-medium rounded-lg shadow-sm hover:shadow-md 
                                       transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <i class="fas fa-file-excel mr-2"></i>
                                Export Excel
                            </button>
                        </div>
                    </div>
                </form>
                @endif

                <!-- Search -->
                <div class="lg:w-80">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Program Studi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="search-prodi-dashboard" placeholder="Cari prodi..." 
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg 
                                      focus:ring-2 focus:ring-blue-500 focus:border-transparent 
                                      placeholder-gray-400 text-sm transition-all duration-200">
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Section -->
        @if (request()->filled('tahun_progress'))
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-5">
                    <h2 class="text-xl font-bold text-white">Progress Penyusunan Kurikulum OBE</h2>
                    <p class="mt-1 text-sm text-gray-300">Tahun Kurikulum: {{ $availableYears->firstWhere('id_tahun', request('tahun_progress'))->tahun ?? '-' }}</p>
                </div>

                <div class="p-6">
                    <!-- Target Info Box -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-5 mb-8">
                        <h4 class="font-semibold text-blue-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Target Standar Kurikulum OBE
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-blue-600">9</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">CPL</div>
                                <div class="text-xs text-gray-500">Capaian Profil Lulusan</div>
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
                                                {{ $prodi->avg_progress >= 80 ? 'bg-gradient-to-r from-green-500 to-green-600' : 
                                                   ($prodi->avg_progress >= 50 ? 'bg-gradient-to-r from-amber-500 to-amber-600' : 
                                                   'bg-gradient-to-r from-red-500 to-red-600') }}"
                                         style="width: {{ $prodi->avg_progress }}%">
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Progress -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="bg-white rounded-lg p-3 border border-blue-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                        <span class="text-xs font-semibold text-blue-600">{{ $prodi->progress_cpl }}%</span>
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $prodi->cpl_count }}/9</div>
                                    <div class="text-xs text-gray-600">CPL</div>
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
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">Pilih Tahun Progress</h3>
                <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                    Silakan pilih tahun kurikulum di bawah untuk menampilkan progress implementasi OBE per program studi.
                </p>
                
                <!-- Year Filter Form -->
                <form method="GET" action="{{ route('admin.dashboard') }}" class="mt-6 max-w-sm mx-auto">
                    <div class="flex gap-3">
                        <select name="tahun_progress" required
                            class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg 
                                   focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="" disabled selected>Pilih Tahun Kurikulum</option>
                            @foreach ($availableYears as $th)
                                <option value="{{ $th->id_tahun }}">{{ $th->tahun }}</option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium 
                                   rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                            Tampilkan
                        </button>
                    </div>
                </form>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
function exportWord(e) {
    event.preventDefault();
    
    const form = document.getElementById('exportForm');
    const prodi = form.querySelector('select[name="kode_prodi"]').value;
    const tahun = form.querySelector('select[name="id_tahun"]').value;

    if (!prodi || !tahun) {
        alert('Harap pilih Prodi dan Tahun terlebih dahulu.');
        return;
    }

    const url = `{{ url('/export/kpt') }}?kode_prodi=${prodi}&id_tahun=${tahun}`;
    window.open(url, '_blank');
}

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
