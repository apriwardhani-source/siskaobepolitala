@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header selaras dengan Wadir1/Admin -->
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
                        Detail Capaian Profil Lulusan (CPL)
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Informasi lengkap mengenai CPL yang dipilih untuk program studi dan tahun kurikulum terkait.
                    </p>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-info-circle mr-2 text-sm"></i>
                    Informasi CPL
                </h2>
            </div>

            <div class="px-6 py-6 space-y-6">
                <!-- Profil Lulusan terkait (jika ada) -->
                @if (!empty($selectedProfilLulusans))
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800 mb-2">Profil Lulusan Terkait</h3>
                        <div class="w-full p-4 border border-gray-200 rounded-lg bg-gray-50 space-y-2">
                            @foreach ($selectedProfilLulusans as $id_pl)
                                @php
                                    $plDetail = $profilLulusans->firstWhere('id_pl', $id_pl);
                                @endphp
                                @if ($plDetail)
                                    <div class="text-sm text-gray-800">
                                        <span class="font-semibold">{{ $plDetail->kode_pl }}</span> : {{ $plDetail->deskripsi_pl }}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Info Prodi & Tahun -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Program Studi</p>
                        <p class="mt-2 text-base md:text-lg font-bold text-gray-900">
                            {{ $id_cpl->prodi->nama_prodi ?? '-' }}
                        </p>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Tahun Kurikulum</p>
                        <p class="mt-2 text-base md:text-lg font-bold text-gray-900">
                            {{ $id_cpl->tahun?->tahun ?? '-' }}
                        </p>
                    </div>
                </div>

                <!-- Detail CPL -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="kode_cpl" class="block text-sm font-semibold text-gray-800">Kode CPL</label>
                        <input type="text" id="kode_cpl" value="{{ $id_cpl->kode_cpl }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2">
                        <label for="status_cpl" class="block text-sm font-semibold text-gray-800">Status CPL</label>
                        <input type="text" id="status_cpl" value="{{ $id_cpl->status_cpl ?: '-' }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label for="deskripsi_cpl" class="block text-sm font-semibold text-gray-800">Deskripsi CPL</label>
                        <textarea id="deskripsi_cpl" rows="4" readonly
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">{{ $id_cpl->deskripsi_cpl }}</textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

