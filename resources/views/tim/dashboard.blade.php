@extends('layouts.tim.app')

@section('title', 'Dashboard Tim')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        @php
            $singleProdi = $prodis->first();
            $selectedYear = $availableYears->firstWhere('id_tahun', $tahun_progress);
            $overallProgress = $singleProdi->avg_progress ?? 0;

            // Progress MK (mengikuti rumus pada controller Kaprodi)
            $targetMk = 48;
            $mkCount = $singleProdi->mk_count ?? 0;
            $progressMk = $singleProdi->progress_mk ?? ($mkCount > 0 ? min(100, round(($mkCount / $targetMk) * 100)) : 0);
        @endphp

        <!-- Header with Prodi Info (seperti Kaprodi) -->
        @if($singleProdi)
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
                            {{ $singleProdi->kode_prodi }}
                        </span>
                        <span class="text-gray-700 font-medium">{{ $singleProdi->nama_prodi }}</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">
                        Monitoring progress implementasi kurikulum berbasis Outcome-Based Education
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Filter Dashboard -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter Dashboard
                </h2>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('tim.dashboard') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-chart-line text-blue-500 mr-1"></i>
                                Tahun Progress
                            </label>
                            <select name="tahun_progress"
                                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">Pilih Tahun untuk Melihat Progress</option>
                                @foreach ($availableYears as $th)
                                    <option value="{{ $th->id_tahun }}" {{ ($tahun_progress ?? '') == $th->id_tahun ? 'selected' : '' }}>
                                        {{ $th->nama_kurikulum }} - {{ $th->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
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

        @if(!$tahun_progress && $singleProdi)
            <div class="bg-white rounded-xl shadow-lg p-12 text-center mb-8">
                <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">Pilih Tahun untuk Melihat Progress</h3>
                <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                    Silakan pilih tahun kurikulum di atas untuk menampilkan progress implementasi OBE untuk program studi
                    <strong>{{ $singleProdi->nama_prodi }}</strong>.
                </p>
            </div>
        @endif

        @if($tahun_progress)
        <!-- Header: Progress Penyusunan Kurikulum -->
        <div class="mb-8">
            <div class="bg-gray-900 rounded-3xl shadow-xl overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-gray-900 to-slate-800">
                    <h1 class="text-2xl md:text-3xl font-bold text-white tracking-tight">Progress Penyusunan Kurikulum OBE</h1>
                    <p class="mt-2 text-sm text-blue-100">
                        Tahun Kurikulum:
                        @if($selectedYear)
                            {{ $selectedYear->nama_kurikulum }} ({{ $selectedYear->tahun }})
                        @else
                            <span class="italic">Belum dipilih</span>
                        @endif
                    </p>
                </div>

                @if($tahun_progress && $singleProdi)
                    <div class="px-8 py-6 bg-blue-50">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Progress Keseluruhan</h2>
                            </div>
                            <div class="flex items-center">
                                <div class="inline-flex items-center px-4 py-2 rounded-full bg-amber-100 text-amber-700 text-sm font-semibold">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    {{ $overallProgress }}%
                                </div>
                            </div>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden mb-3">
                            <div class="h-full rounded-full bg-gradient-to-r from-amber-400 to-amber-500 transition-all duration-700"
                                 style="width: {{ $overallProgress }}%"></div>
                        </div>

                        <div class="flex items-center text-sm text-gray-700 mt-2">
                            <i class="fas fa-hourglass-half text-amber-500 mr-2"></i>
                            @if($overallProgress >= 100)
                                Kurikulum OBE sudah lengkap. Lakukan peninjauan berkala untuk menjaga kualitas.
                            @elseif($overallProgress > 0)
                                Kurikulum OBE dalam tahap pengembangan. Lanjutkan penyusunan komponen yang belum lengkap.
                            @else
                                Belum ada progress. Mulai dengan menyusun CPL, mata kuliah, dan CPMK.
                            @endif
                        </div>
                    </div>
                @else
                    <div class="px-8 py-6 bg-blue-50 text-sm text-gray-700">
                        Silakan pilih <strong>Tahun Progress</strong> terlebih dahulu untuk melihat progress penyusunan kurikulum OBE.
                    </div>
                @endif
            </div>
        </div>

        @if($tahun_progress && $prodicount > 0 && $singleProdi)
            <!-- Target Standar Kurikulum OBE -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 mb-8">
                <div class="px-6 py-4 border-b border-gray-200 bg-blue-50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-blue-600 text-white text-xs font-bold">i</span>
                        <h2 class="text-sm md:text-base font-semibold text-gray-900">Target Standar Kurikulum OBE (D4/S1)</h2>
                    </div>
                    <span class="text-xs text-gray-500 hidden md:inline">Referensi target progress untuk program studi</span>
                </div>
                <div class="px-6 py-5 bg-blue-50">
                    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                        <div class="bg-white rounded-xl shadow-sm px-5 py-4">
                            <p class="text-2xl font-bold text-blue-700">9</p>
                            <p class="mt-1 text-xs font-semibold text-gray-700">CPL</p>
                            <p class="text-[11px] text-gray-500 mt-1">Capaian Profil Lulusan</p>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm px-5 py-4">
                            <p class="text-2xl font-bold text-blue-700">48</p>
                            <p class="mt-1 text-xs font-semibold text-gray-700">Mata Kuliah</p>
                            <p class="text-[11px] text-gray-500 mt-1">Jumlah Mata Kuliah</p>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm px-5 py-4">
                            <p class="text-2xl font-bold text-blue-700">144</p>
                            <p class="mt-1 text-xs font-semibold text-gray-700">Total SKS</p>
                            <p class="text-[11px] text-gray-500 mt-1">Total SKS Mata Kuliah (D4)</p>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm px-5 py-4">
                            <p class="text-2xl font-bold text-blue-700">20</p>
                            <p class="mt-1 text-xs font-semibold text-gray-700">CPMK</p>
                            <p class="text-[11px] text-gray-500 mt-1">Capaian Pembelajaran MK</p>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm px-5 py-4">
                            <p class="text-2xl font-bold text-blue-700">40</p>
                            <p class="mt-1 text-xs font-semibold text-gray-700">Sub CPMK</p>
                            <p class="text-[11px] text-gray-500 mt-1">Indikator Pencapaian</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Cards per Komponen -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
                <!-- CPL -->
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold text-gray-900">CPL</h4>
                        @php $pcpl = $singleProdi->progress_cpl ?? 0; @endphp
                        <span class="text-sm font-semibold {{ $pcpl >= 80 ? 'text-green-600' : ($pcpl >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                            {{ $pcpl }}%
                        </span>
                    </div>
                    <div class="mb-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-full rounded-full {{ $pcpl >= 80 ? 'bg-green-500' : ($pcpl >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                 style="width: {{ $pcpl }}%"></div>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">
                        {{ $singleProdi->cpl_count ?? 0 }} <span class="text-sm font-normal text-gray-500">/ 9</span>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">Capaian Pembelajaran Lulusan</p>
                </div>

                <!-- Total SKS -->
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-3">
                        <h5 class="font-semibold text-gray-900">Total SKS</h5>
                        @php $psks = $singleProdi->progress_sks_mk ?? 0; @endphp
                        <span class="text-sm font-semibold {{ $psks >= 80 ? 'text-green-600' : ($psks >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                            {{ $psks }}%
                        </span>
                    </div>
                    <div class="mb-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-full rounded-full {{ $psks >= 80 ? 'bg-green-500' : ($psks >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                 style="width: {{ $psks }}%"></div>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">
                        {{ $singleProdi->sks_mk ?? 0 }} <span class="text-sm font-normal text-gray-500">/ 144</span>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">Total SKS Mata Kuliah</p>
                </div>

                <!-- CPMK -->
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-3">
                        <h5 class="font-semibold text-gray-900">CPMK</h5>
                        @php $pcpmk = $singleProdi->progress_cpmk ?? 0; @endphp
                        <span class="text-sm font-semibold {{ $pcpmk >= 80 ? 'text-green-600' : ($pcpmk >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                            {{ $pcpmk }}%
                        </span>
                    </div>
                    <div class="mb-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-full rounded-full {{ $pcpmk >= 80 ? 'bg-green-500' : ($pcpmk >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                 style="width: {{ $pcpmk }}%"></div>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">
                        {{ $singleProdi->cpmk_count ?? 0 }} <span class="text-sm font-normal text-gray-500">/ 20</span>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">Capaian Pembelajaran MK</p>
                </div>

                <!-- Sub CPMK -->
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-3">
                        <h5 class="font-semibold text-gray-900">Sub CPMK</h5>
                        @php $psub = $singleProdi->progress_subcpmk ?? 0; @endphp
                        <span class="text-sm font-semibold {{ $psub >= 80 ? 'text-green-600' : ($psub >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                            {{ $psub }}%
                        </span>
                    </div>
                    <div class="mb-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-full rounded-full {{ $psub >= 80 ? 'bg-green-500' : ($psub >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                 style="width: {{ $psub }}%"></div>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">
                        {{ $singleProdi->subcpmk_count ?? 0 }} <span class="text-sm font-normal text-gray-500">/ 40</span>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">Sub Capaian Pembelajaran MK</p>
                </div>

                <!-- Mata Kuliah -->
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-3">
                        <h5 class="font-semibold text-gray-900">Mata Kuliah</h5>
                        <span class="text-sm font-semibold {{ $progressMk >= 80 ? 'text-green-600' : ($progressMk >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                            {{ $progressMk }}%
                        </span>
                    </div>
                    <div class="mb-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-full rounded-full {{ $progressMk >= 80 ? 'bg-green-500' : ($progressMk >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                 style="width: {{ $progressMk }}%"></div>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">
                        {{ $mkCount }} <span class="text-sm font-normal text-gray-500">/ 48</span>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">Jumlah Mata Kuliah</p>
                </div>
            </div>
        @elseif($tahun_progress)
            <!-- No Data State -->
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                          d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Data Kurikulum</h3>
                <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                    Belum ada data kurikulum OBE untuk tahun yang dipilih.
                </p>
            </div>
        @endif
        @endif

    </div>
</div>

@endsection
