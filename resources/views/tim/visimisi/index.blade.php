@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Visi & Misi</h1>
            <p class="mt-2 text-sm text-gray-600">Visi dan Misi Politeknik Negeri Tanah Laut</p>
        </div>

        <!-- Visi Politala -->
        <div class="mb-6">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-500">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-100">
                    <h2 class="text-xl font-bold text-blue-900 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                        Visi Politala
                    </h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 text-center leading-relaxed text-lg">
                        {{ $visis ? $visis->visi : 'Data visi belum tersedia' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Misi Politala -->
        <div class="mb-6">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-green-500">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-green-100">
                    <h2 class="text-xl font-bold text-green-900 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        Misi Politala
                    </h2>
                </div>
                <div class="p-6">
                    @if($misis->count() > 0)
                        <ol class="space-y-3">
                            @foreach ($misis as $index => $misi)
                                <li class="flex items-start">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-800 font-bold text-sm mr-3 flex-shrink-0">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="text-gray-700 leading-relaxed pt-1">{{ $misi->misi }}</span>
                                </li>
                            @endforeach
                        </ol>
                    @else
                        <p class="text-gray-500 text-center py-4">Data misi belum tersedia</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Visi Keilmuan Prodi -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-amber-500">
            <div class="bg-gradient-to-r from-amber-50 to-yellow-50 px-6 py-4 border-b border-amber-100">
                <h2 class="text-xl font-bold text-amber-900 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                    Visi Keilmuan Program Studi
                </h2>
            </div>
            <div class="p-6">
                @if($prodis->count() > 0)
                    <div class="space-y-6">
                        @foreach ($prodis as $prodi)
                            <div class="bg-gradient-to-r from-amber-50 to-yellow-50 rounded-lg p-5 border border-amber-200">
                                <h3 class="text-lg font-semibold text-amber-900 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $prodi->nama_prodi }}
                                </h3>
                                <p class="text-gray-700 leading-relaxed">{{ $prodi->visi_prodi }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Data visi prodi belum tersedia</p>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
