@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Detail Sub CPMK</h1>
            <p class="mt-2 text-sm text-gray-600">Informasi lengkap tentang Sub CPMK {{ $subcpmk->sub_cpmk }}</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="px-8 py-6 space-y-6">

                <!-- Kode CPMK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode CPMK</label>
                    <div class="w-full bg-purple-50 border border-purple-200 rounded-lg px-4 py-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                            {{ $subcpmk->kode_cpmk }}
                        </span>
                    </div>
                </div>

                <!-- Deskripsi CPMK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi CPMK</label>
                    <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 min-h-[80px]">
                        {{ $subcpmk->deskripsi_cpmk }}
                    </div>
                </div>

                <!-- Sub CPMK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Sub CPMK</label>
                    <div class="w-full bg-blue-50 border border-blue-200 rounded-lg px-4 py-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                            {{ $subcpmk->sub_cpmk }}
                        </span>
                    </div>
                </div>

                <!-- Uraian Sub CPMK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Uraian Sub CPMK</label>
                    <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 min-h-[100px]">
                        {{ $subcpmk->uraian_cpmk }}
                    </div>
                </div>

            </div>

            <!-- Footer Actions -->
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <a href="{{ route('kaprodi.subcpmk.index') }}"
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
