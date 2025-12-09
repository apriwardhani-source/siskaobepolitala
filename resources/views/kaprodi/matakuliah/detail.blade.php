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
                    <i class="fas fa-book-open text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                        Detail Mata Kuliah
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Informasi lengkap mengenai mata kuliah {{ $matakuliah->kode_mk ?? '-' }} beserta CPL terkait.
                    </p>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-info-circle mr-2 text-sm"></i>
                    Informasi Mata Kuliah
                </h2>
            </div>

            <div class="px-6 py-6 space-y-6">
                <!-- CPL terkait (dengan badge warna) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        CPL Terkait
                        @if(!empty($selectedCPL))
                            <span class="ml-2 text-xs font-normal text-gray-500">({{ count($selectedCPL) }} CPL)</span>
                        @endif
                    </label>
                    <div class="w-full bg-blue-50 border border-blue-200 rounded-lg px-4 py-3">
                        @php
                            $selectedList = $selectedCPL ?? [];
                        @endphp
                        @if (!empty($selectedList))
                            @foreach ($selectedList as $id_cpl)
                                @php
                                    $cplDetail = $cplList->firstWhere('id_cpl', $id_cpl);
                                @endphp
                                @if ($cplDetail)
                                    <div class="flex items-start mb-3 last:mb-0">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-100 text-blue-800 mr-3 flex-shrink-0">
                                            {{ $cplDetail->kode_cpl }}
                                        </span>
                                        <span class="text-sm text-gray-700">{{ $cplDetail->deskripsi_cpl }}</span>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="text-gray-500 italic text-sm flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Tidak ada CPL terkait dengan mata kuliah ini.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info MK utama -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">Kode MK</label>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 mr-3">
                                {{ $matakuliah->kode_mk }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">Nama MK</label>
                        <input type="text" value="{{ $matakuliah->nama_mk }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">SKS MK</label>
                        <input type="text" value="{{ $matakuliah->sks_mk }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">Semester MK</label>
                        <input type="text" value="{{ $matakuliah->semester_mk }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-800">Kompetensi MK</label>
                        <input type="text" value="{{ $matakuliah->kompetensi_mk }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
