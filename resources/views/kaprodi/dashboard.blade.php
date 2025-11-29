@extends('layouts.app')

@section('title', 'Dashboard Kaprodi')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header with Prodi Info -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard Kurikulum OBE</h1>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-100 text-blue-800 text-sm font-semibold">
                            {{ $prodi->kode_prodi }}
                        </span>
                        <span class="text-gray-700 font-medium">{{ $prodi->nama_prodi }}</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">Monitoring progress implementasi kurikulum berbasis Outcome-Based Education</p>
                </div>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter Dashboard
                </h2>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('kaprodi.dashboard') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-file-excel text-green-500 mr-1"></i>
                            Tahun Kurikulum (Export)
                        </label>
                            <select name="id_tahun" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="" {{ empty($id_tahun) ? 'selected' : '' }}>Pilih Tahun</option>
                                @foreach ($availableYears as $th)
                                    <option value="{{ $th->id_tahun }}" {{ $id_tahun == $th->id_tahun ? 'selected' : '' }}>
                                        {{ $th->nama_kurikulum }} - {{ $th->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-chart-line text-blue-500 mr-1"></i>
                                Tahun Progress
                            </label>
                            <select name="tahun_progress" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">Pilih Tahun untuk Melihat Progress</option>
                                @foreach ($availableYears as $th)
                                    <option value="{{ $th->id_tahun }}" {{ request('tahun_progress') == $th->id_tahun ? 'selected' : '' }}>
                                        {{ $th->nama_kurikulum }} - {{ $th->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end gap-3">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Tampilkan Data
                            </button>
                            <button type="submit" formaction="{{ route('kaprodi.export.excel') }}"
                                class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                <i class="fas fa-file-excel mr-2"></i>
                                Export Excel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Progress Section -->
        @if (request()->filled('tahun_progress'))
            @if ($stats)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-5">
                    <h2 class="text-xl font-bold text-white">Progress Penyusunan Kurikulum OBE</h2>
                    <p class="mt-1 text-sm text-gray-300">
                        Tahun Kurikulum: {{ $availableYears->firstWhere('id_tahun', request('tahun_progress'))->nama_kurikulum ?? '-' }} 
                        ({{ $availableYears->firstWhere('id_tahun', request('tahun_progress'))->tahun ?? '-' }})
                    </p>
                </div>

                <div class="p-6">
                    <!-- Overall Progress -->
                    <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900">Progress Keseluruhan</h3>
                            <span class="inline-flex items-center px-5 py-2 rounded-full text-lg font-bold
                                         {{ $stats['avg_progress'] >= 80 ? 'bg-green-100 text-green-800' : 
                                            ($stats['avg_progress'] >= 50 ? 'bg-amber-100 text-amber-800' : 
                                            'bg-red-100 text-red-800') }}">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ $stats['avg_progress'] }}%
                            </span>
                        </div>
                        
                        <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500 
                                        {{ $stats['avg_progress'] >= 80 ? 'bg-gradient-to-r from-green-500 to-green-600' : 
                                           ($stats['avg_progress'] >= 50 ? 'bg-gradient-to-r from-amber-500 to-amber-600' : 
                                           'bg-gradient-to-r from-red-500 to-red-600') }}"
                                 style="width: {{ $stats['avg_progress'] }}%">
                            </div>
                        </div>

                        <p class="mt-3 text-sm text-gray-600">
                            @if($stats['avg_progress'] >= 80)
                                <i class="fas fa-check-circle text-green-600 mr-1"></i>
                                Kurikulum OBE hampir selesai! Segera finalisasi komponen yang tersisa.
                            @elseif($stats['avg_progress'] >= 50)
                                <i class="fas fa-hourglass-half text-amber-600 mr-1"></i>
                                Kurikulum OBE dalam tahap pengembangan. Lanjutkan penyusunan komponen yang belum lengkap.
                            @else
                                <i class="fas fa-exclamation-triangle text-red-600 mr-1"></i>
                                Kurikulum OBE masih dalam tahap awal. Segera lengkapi komponen-komponen utama.
                            @endif
                        </p>
                    </div>

                    <!-- Target Info Box -->
                    <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-5">
                        <h4 class="font-semibold text-blue-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Target Standar Kurikulum OBE (D4/S1)
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                            <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-100">
                                <div class="text-xl font-bold text-blue-600">{{ $stats['target']['cpl'] }}</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">CPL</div>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-100">
                                <div class="text-xl font-bold text-blue-600">{{ $stats['target']['mk'] }}</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">Mata Kuliah</div>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-100">
                                <div class="text-xl font-bold text-blue-600">{{ $stats['target']['sks_mk'] }}</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">Total SKS</div>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-100">
                                <div class="text-xl font-bold text-blue-600">{{ $stats['target']['cpmk'] }}</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">CPMK</div>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm border border-blue-100">
                                <div class="text-xl font-bold text-blue-600">{{ $stats['target']['subcpmk'] }}</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">Sub CPMK</div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Progress Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        
                        <!-- CPL -->
                        <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between mb-3">
                                <h5 class="font-semibold text-gray-900">CPL</h5>
                                <span class="text-sm font-semibold {{ $stats['progress_cpl'] >= 80 ? 'text-green-600' : ($stats['progress_cpl'] >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                                    {{ $stats['progress_cpl'] }}%
                                </span>
                            </div>
                            <div class="mb-3">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-full rounded-full {{ $stats['progress_cpl'] >= 80 ? 'bg-green-500' : ($stats['progress_cpl'] >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                         style="width: {{ $stats['progress_cpl'] }}%"></div>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">{{ $stats['cpl_count'] }}<span class="text-sm text-gray-500 font-normal"> / {{ $stats['target']['cpl'] }}</span></div>
                            <p class="text-xs text-gray-600 mt-1">Capaian Pembelajaran Lulusan</p>
                        </div>

                        <!-- Total SKS -->
                        <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between mb-3">
                                <h5 class="font-semibold text-gray-900">Total SKS</h5>
                                <span class="text-sm font-semibold {{ $stats['progress_sks_mk'] >= 80 ? 'text-green-600' : ($stats['progress_sks_mk'] >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                                    {{ $stats['progress_sks_mk'] }}%
                                </span>
                            </div>
                            <div class="mb-3">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-full rounded-full {{ $stats['progress_sks_mk'] >= 80 ? 'bg-green-500' : ($stats['progress_sks_mk'] >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                         style="width: {{ $stats['progress_sks_mk'] }}%"></div>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">{{ $stats['sks_mk'] }}<span class="text-sm text-gray-500 font-normal"> / {{ $stats['target']['sks_mk'] }}</span></div>
                            <p class="text-xs text-gray-600 mt-1">Total SKS Mata Kuliah</p>
                        </div>

                        <!-- CPMK -->
                        <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between mb-3">
                                <h5 class="font-semibold text-gray-900">CPMK</h5>
                                <span class="text-sm font-semibold {{ $stats['progress_cpmk'] >= 80 ? 'text-green-600' : ($stats['progress_cpmk'] >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                                    {{ $stats['progress_cpmk'] }}%
                                </span>
                            </div>
                            <div class="mb-3">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-full rounded-full {{ $stats['progress_cpmk'] >= 80 ? 'bg-green-500' : ($stats['progress_cpmk'] >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                         style="width: {{ $stats['progress_cpmk'] }}%"></div>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">{{ $stats['cpmk_count'] }}<span class="text-sm text-gray-500 font-normal"> / {{ $stats['target']['cpmk'] }}</span></div>
                            <p class="text-xs text-gray-600 mt-1">Capaian Pembelajaran MK</p>
                        </div>

                        <!-- Sub CPMK -->
                        <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between mb-3">
                                <h5 class="font-semibold text-gray-900">Sub CPMK</h5>
                                <span class="text-sm font-semibold {{ $stats['progress_subcpmk'] >= 80 ? 'text-green-600' : ($stats['progress_subcpmk'] >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                                    {{ $stats['progress_subcpmk'] }}%
                                </span>
                            </div>
                            <div class="mb-3">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-full rounded-full {{ $stats['progress_subcpmk'] >= 80 ? 'bg-green-500' : ($stats['progress_subcpmk'] >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                         style="width: {{ $stats['progress_subcpmk'] }}%"></div>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">{{ $stats['subcpmk_count'] }}<span class="text-sm text-gray-500 font-normal"> / {{ $stats['target']['subcpmk'] }}</span></div>
                            <p class="text-xs text-gray-600 mt-1">Sub Capaian Pembelajaran MK</p>
                        </div>

                        <!-- Mata Kuliah -->
                        <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between mb-3">
                                <h5 class="font-semibold text-gray-900">Mata Kuliah</h5>
                                <span class="text-sm font-semibold {{ $stats['progress_mk'] >= 80 ? 'text-green-600' : ($stats['progress_mk'] >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                                    {{ $stats['progress_mk'] }}%
                                </span>
                            </div>
                            <div class="mb-3">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-full rounded-full {{ $stats['progress_mk'] >= 80 ? 'bg-green-500' : ($stats['progress_mk'] >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                         style="width: {{ $stats['progress_mk'] }}%"></div>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">{{ $stats['mk_count'] }}<span class="text-sm text-gray-500 font-normal"> / {{ $stats['target']['mk'] }}</span></div>
                            <p class="text-xs text-gray-600 mt-1">Jumlah Mata Kuliah</p>
                        </div>

                    </div>
                </div>
            </div>
            @else
                <!-- No Data State -->
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Data Kurikulum</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Belum ada data kurikulum OBE untuk <strong>{{ $prodi->nama_prodi }}</strong> tahun <strong>{{ $availableYears->firstWhere('id_tahun', request('tahun_progress'))->tahun ?? '-' }}</strong>.
                    </p>
                    <p class="mt-3 text-sm text-gray-600 max-w-md mx-auto">
                        Silakan hubungi <strong>Tim Penyusun Kurikulum</strong> untuk menambahkan data Profil Lulusan, CPL, dan komponen kurikulum lainnya.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('kaprodi.dashboard') }}" 
                           class="inline-flex items-center px-5 py-2.5 bg-gray-600 hover:bg-gray-700 
                                  text-white font-medium rounded-lg shadow-sm hover:shadow-md 
                                  transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">Pilih Tahun untuk Melihat Progress</h3>
                <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                    Silakan pilih tahun kurikulum di atas untuk menampilkan progress implementasi OBE untuk program studi <strong>{{ $prodi->nama_prodi }}</strong>.
                </p>
            </div>
        @endif

    </div>
</div>

@endsection
