@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header -->
        <div class="mb-6">
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-arrow-left mr-2 text-xs"></i>
                kembali
            </a>
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-bullseye text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                        Detail Capaian Pembelajaran Mata Kuliah
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Informasi lengkap mengenai CPMK {{ $cpmk->kode_cpmk ?? '-' }} beserta CPL dan mata kuliah terkait.
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-info-circle mr-2 text-sm"></i>
                    Informasi CPMK
                </h2>
            </div>

            <div class="px-6 py-6 space-y-6">

                <!-- Kode CPMK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode CPMK</label>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                        {{ $cpmk->kode_cpmk }}
                    </span>
                </div>

                <!-- Deskripsi CPMK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi CPMK</label>
                    <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 min-h-[100px]">
                        {{ $cpmk->deskripsi_cpmk }}
                    </div>
                </div>

                <!-- CPL Terkait -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        CPL Terkait
                        <span class="ml-2 text-xs font-normal text-gray-500">({{ $cpls->count() }} CPL)</span>
                    </label>
                    <div class="w-full bg-blue-50 border border-blue-200 rounded-lg px-4 py-3">
                        @forelse ($cpls as $cpl)
                            <div class="flex items-start mb-3 last:mb-0">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-100 text-blue-800 mr-3 flex-shrink-0">
                                    {{ $cpl->kode_cpl }}
                                </span>
                                <span class="text-sm text-gray-700">{{ $cpl->deskripsi_cpl }}</span>
                            </div>
                        @empty
                            <div class="text-gray-500 italic text-sm flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Tidak ada CPL terkait dengan CPMK ini
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- MK Terkait -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Mata Kuliah Terkait
                        <span class="ml-2 text-xs font-normal text-gray-500">({{ $mks->count() }} Mata Kuliah)</span>
                    </label>
                    <div class="w-full bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                        @forelse ($mks as $mk)
                            <div class="flex items-start mb-3 last:mb-0">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-green-100 text-green-800 mr-3 flex-shrink-0">
                                    {{ $mk->kode_mk }}
                                </span>
                                <span class="text-sm text-gray-700">{{ $mk->nama_mk }}</span>
                            </div>
                        @empty
                            <div class="text-gray-500 italic text-sm flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Tidak ada mata kuliah terkait dengan CPMK ini
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
