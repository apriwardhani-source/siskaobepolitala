@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header - disamakan dengan Admin -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                        <i class="fas fa-bullseye text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Visi &amp; Misi Politala</h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Ringkasan visi dan misi institusi sebagai panduan tim kurikulum OBE.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visi & Misi Politala (layout sama admin) -->
        <div class="grid gap-6 md:grid-cols-2 mb-8">

            {{-- Visi Politala Section --}}
            <div class="bg-white rounded-xl shadow-lg border border-blue-50 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white shadow">
                            <i class="fas fa-eye text-sm"></i>
                        </span>
                        <div>
                            <h2 class="text-lg font-semibold text-blue-900">Visi Politala</h2>
                            <p class="text-xs text-blue-600">Gambaran besar tujuan akhir yang ingin dicapai.</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-5">
                    <p class="text-gray-700 leading-relaxed text-justify md:text-left">
                        {{ $visis ? $visis->visi : 'Data visi belum tersedia' }}
                    </p>
                </div>
            </div>

            {{-- Misi Politala Section --}}
            <div class="bg-white rounded-xl shadow-lg border border-green-50 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-green-50 border-b border-green-100">
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500 text-white shadow">
                            <i class="fas fa-list-ul text-sm"></i>
                        </span>
                        <div>
                            <h2 class="text-lg font-semibold text-emerald-900">Misi Politala</h2>
                            <p class="text-xs text-emerald-700">Langkah strategis untuk mewujudkan visi.</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-5">
                    @if($misis->count() > 0)
                        <ol class="space-y-3">
                            @foreach ($misis as $index => $misi)
                                <li class="flex items-start space-x-3">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-500 text-white text-xs font-semibold mt-0.5 shadow">
                                        {{ $index + 1 }}
                                    </span>
                                    <p class="text-gray-700 leading-relaxed">
                                        {{ $misi->misi }}
                                    </p>
                                </li>
                            @endforeach
                        </ol>
                    @else
                        <p class="text-gray-700 text-center">Data misi belum tersedia</p>
                    @endif
                </div>
            </div>

        </div>

        <!-- Program Studi Terkait (gaya seperti screenshot, aksen kuning) -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-amber-100">
            <div class="px-6 py-4 bg-gradient-to-r from-amber-50 to-yellow-50 border-b border-amber-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-500 text-white shadow">
                            <i class="fas fa-university text-sm"></i>
                        </span>
                        <div>
                            <h2 class="text-lg font-semibold text-amber-900">Program Studi Terkait</h2>
                            <p class="text-xs text-amber-700">Daftar program studi yang menggunakan visi dan misi ini.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-6 py-5">
                @if($prodis->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($prodis as $prodi)
                            <div class="border border-amber-200 rounded-lg p-4 bg-white hover:border-amber-400 transition-colors flex flex-col gap-1 shadow-sm">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded bg-amber-100 text-amber-800">
                                        {{ $prodi->kode_prodi }}
                                    </span>
                                </div>
                                <p class="font-medium text-gray-900">{{ $prodi->nama_prodi }}</p>
                                @if (!empty($prodi->visi_prodi))
                                    <p class="text-xs text-gray-600 mt-1">{{ $prodi->visi_prodi }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">
                        Data program studi belum tersedia.
                    </p>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
