@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        {{-- Header dengan tombol kembali + logo (mirip detail CPMK tim) --}}
        <div class="mb-6">
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-arrow-left mr-2 text-xs"></i>
                kembali
            </a>
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-list-ul text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                        Detail Sub CPMK
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Informasi lengkap tentang Sub CPMK {{ $subcpmk->sub_cpmk }} pada CPMK {{ $subcpmk->kode_cpmk }}.
                    </p>
                </div>
            </div>
        </div>

        {{-- Kartu utama --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="px-8 py-6 space-y-6">

                {{-- Kode CPMK --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode CPMK</label>
                    <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-800 font-medium">
                        {{ $subcpmk->kode_cpmk }}
                    </div>
                </div>

                {{-- Deskripsi CPMK --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi CPMK</label>
                    <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 min-h-[80px]">
                        {{ $subcpmk->deskripsi_cpmk }}
                    </div>
                </div>

                {{-- Sub CPMK --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sub CPMK</label>
                    <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-800 font-medium">
                        {{ $subcpmk->sub_cpmk }}
                    </div>
                </div>

                {{-- Uraian Sub CPMK --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Uraian Sub CPMK</label>
                    <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 min-h-[80px]">
                        {{ $subcpmk->uraian_cpmk }}
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
