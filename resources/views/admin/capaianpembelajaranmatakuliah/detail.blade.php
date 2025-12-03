@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Detail Capaian Pembelajaran Mata Kuliah</h1>
            <p class="mt-2 text-sm text-gray-600">
                Informasi lengkap tentang CPMK {{ $cpmk->kode_cpmk ?? '-' }}.
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="px-8 py-6 space-y-6">

                <!-- Kode CPMK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode CPMK</label>
                    <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-800 font-medium">
                        {{ $cpmk->kode_cpmk ?? '-' }}
                    </div>
                </div>

                <!-- Deskripsi CPMK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi CPMK</label>
                    <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 min-h-[100px]">
                        {{ $cpmk->deskripsi_cpmk ?? '-' }}
                    </div>
                </div>

                <!-- CPL Terkait -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        CPL Terkait
                        <span class="ml-2 text-xs font-normal text-gray-500">({{ ($cpls ?? collect())->count() }} CPL)</span>
                    </label>
                    <div class="w-full bg-blue-50 border border-blue-200 rounded-lg px-4 py-3">
                        @forelse ($cpls ?? collect() as $cpl)
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
                                Tidak ada CPL terkait dengan CPMK ini.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Mata Kuliah Terkait -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Mata Kuliah Terkait
                        <span class="ml-2 text-xs font-normal text-gray-500">({{ ($mks ?? collect())->count() }} Mata Kuliah)</span>
                    </label>
                    <div class="w-full bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                        @forelse ($mks ?? collect() as $mk)
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
                                Tidak ada mata kuliah terkait dengan CPMK ini.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <div class="px-8 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.capaianpembelajaranmatakuliah.index') }}"
                       class="inline-flex items-center px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

