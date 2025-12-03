@extends('layouts.wadir1.app')

@section('title', 'Detail Mata Kuliah - Wadir 1')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header selaras admin -->
        <div class="mb-6">
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-arrow-left mr-2 text-xs"></i>
                kembali
            </a>
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-book text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Detail Mata Kuliah</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Informasi lengkap mengenai mata kuliah yang dipilih.
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
                {{-- Bahan Kajian Terkait --}}
                @if (!empty($selectedBksIds) && ($bahanKajians ?? collect())->isNotEmpty())
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800 mb-2">Bahan Kajian Terkait</h3>
                        <div class="w-full p-4 border border-gray-200 rounded-lg bg-gray-50 space-y-2">
                            @foreach ($selectedBksIds as $id_bk)
                                @php
                                    $bkDetail = $bahanKajians->firstWhere('id_bk', $id_bk);
                                @endphp
                                @if ($bkDetail)
                                    <div class="text-sm text-gray-800">
                                        <span class="font-semibold">{{ $bkDetail->kode_bk }}</span> : {{ $bkDetail->nama_bk }}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- CPL Terkait --}}
                @if (!empty($selectedCplIds) && ($capaianprofillulusans ?? collect())->isNotEmpty())
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800 mb-2">Capaian Profil Lulusan Terkait</h3>
                        <div class="w-full p-4 border border-gray-200 rounded-lg bg-gray-50 space-y-2">
                            @foreach ($selectedCplIds as $id_cpl)
                                @php
                                    $cplDetail = $capaianprofillulusans->firstWhere('id_cpl', $id_cpl);
                                @endphp
                                @if ($cplDetail)
                                    <div class="text-sm text-gray-800">
                                        <span class="font-semibold">{{ $cplDetail->kode_cpl }}</span> : {{ $cplDetail->deskripsi_cpl }}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Detail Mata Kuliah --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="kode_mk" class="block text-sm font-semibold text-gray-800">Kode MK</label>
                        <input type="text" id="kode_mk" value="{{ $matakuliah->kode_mk }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2">
                        <label for="nama_mk" class="block text-sm font-semibold text-gray-800">Nama Mata Kuliah</label>
                        <input type="text" id="nama_mk" value="{{ $matakuliah->nama_mk }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2">
                        <label for="sks_mk" class="block text-sm font-semibold text-gray-800">SKS MK</label>
                        <input type="number" id="sks_mk" value="{{ $matakuliah->sks_mk }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2">
                        <label for="semester_mk" class="block text-sm font-semibold text-gray-800">Semester MK</label>
                        <input type="text" id="semester_mk" value="{{ $matakuliah->semester_mk }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label for="kompetensi_mk" class="block text-sm font-semibold text-gray-800">Kompetensi MK</label>
                        <input type="text" id="kompetensi_mk" value="{{ $matakuliah->kompetensi_mk }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

