@extends('layouts.dosen.app')

@section('title', 'Detail Mata Kuliah')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('dosen.dashboard') }}"
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-arrow-left mr-2 text-xs"></i>
                Kembali
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
                        Informasi mata kuliah yang Anda ampu beserta tahun kurikulum terkait.
                    </p>
                </div>
            </div>
        </div>

        {{-- Card utama --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-info-circle mr-2 text-sm"></i>
                    Informasi Mata Kuliah
                </h2>
                <a href="{{ route('dosen.penilaian.index', ['kode_mk' => $mataKuliah->kode_mk]) }}"
                   class="inline-flex items-center px-4 py-2 bg-white text-blue-700 rounded-lg text-xs font-semibold shadow hover:bg-blue-50 transition">
                    <i class="fas fa-pencil-alt mr-2 text-xs"></i>
                    Input / Kelola Nilai
                </a>
            </div>

            <div class="px-6 py-6 space-y-6">
                {{-- Informasi dasar MK --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">Kode MK</label>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 mr-3">
                                {{ $mataKuliah->kode_mk }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">Nama MK</label>
                        <input type="text" value="{{ $mataKuliah->nama_mk }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">SKS</label>
                        <input type="text" value="{{ $mataKuliah->sks_mk }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">Semester</label>
                        <input type="text" value="{{ $mataKuliah->semester_mk }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-800">Kompetensi MK</label>
                        <textarea readonly rows="2"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800 resize-none">{{ $mataKuliah->kompetensi_mk }}</textarea>
                    </div>
                </div>

                {{-- Informasi Prodi --}}
                <div class="pt-4 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">Program Studi</label>
                        <input type="text"
                               value="{{ $mataKuliah->prodi ? $mataKuliah->prodi->nama_prodi : '-' }}"
                               readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">Tahun Kurikulum (Penugasan)</label>
                        @if($tahunKurikulums->isNotEmpty())
                            <div class="flex flex-wrap gap-2">
                                @foreach($tahunKurikulums as $tahun)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        {{ $tahun->tahun }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <input type="text" value="-" readonly
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                        @endif
                    </div>
                </div>

                {{-- Dosen Pengampu --}}
                <div class="pt-4 border-t border-gray-100">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Dosen Pengampu</label>
                    @if(isset($dosenPengampu) && $dosenPengampu->isNotEmpty())
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 space-y-2">
                            @foreach($dosenPengampu as $dosen)
                                <div class="flex items-center text-sm text-gray-800">
                                    <i class="fas fa-user-graduate mr-2 text-blue-500"></i>
                                    <span class="font-medium">{{ $dosen->name }}</span>
                                    @if($dosen->nip)
                                        <span class="ml-2 text-xs text-gray-500">({{ $dosen->nip }})</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-500 italic">
                            Belum ada data dosen pengampu tercatat untuk mata kuliah ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
