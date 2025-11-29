@extends('layouts.app')

@section('title', 'Visi & Misi Prodi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header mirip admin -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                        <i class="fas fa-bullseye text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Visi &amp; Misi Program Studi</h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Ringkasan arah dan tujuan program studi sebagai panduan penyusunan kurikulum OBE.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="grid gap-6 md:grid-cols-2">

            {{-- Visi Prodi Section --}}
            <div class="bg-white rounded-xl shadow-lg border border-blue-50 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white shadow">
                            <i class="fas fa-eye text-sm"></i>
                        </span>
                        <div>
                            <h2 class="text-lg font-semibold text-blue-900">Visi Program Studi</h2>
                            <p class="text-xs text-blue-600">Pernyataan visi utama yang menjadi arah pengembangan program studi.</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-5">
                    <p class="text-gray-700 leading-relaxed text-justify md:text-left">
                        {{ $visis ? ($visis->deskripsi ?? $visis->visi) : 'Data visi belum tersedia' }}
                    </p>
                </div>
            </div>

            {{-- Misi Prodi Section --}}
            <div class="bg-white rounded-xl shadow-lg border border-green-50 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-green-50 border-b border-green-100">
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500 text-white shadow">
                            <i class="fas fa-list-ul text-sm"></i>
                        </span>
                        <div>
                            <h2 class="text-lg font-semibold text-emerald-900">Misi Program Studi</h2>
                            <p class="text-xs text-emerald-700">Langkah strategis yang menjabarkan visi menjadi tindakan konkret.</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-5">
                    @if ($misis->isNotEmpty())
                        <ol class="space-y-3">
                            @foreach ($misis as $index => $misi)
                                <li class="flex items-start space-x-3">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-500 text-white text-xs font-semibold mt-0.5 shadow">
                                        {{ $index + 1 }}
                                    </span>
                                    <p class="text-gray-700 leading-relaxed text-justify md:text-left">
                                        {{ $misi->deskripsi ?? $misi->misi ?? '' }}
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

        <!-- Informasi Prodi Terkait -->
        <div class="mt-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Program Studi Terkait</h2>
                        <p class="text-xs text-gray-500">Daftar program studi yang menggunakan visi dan misi ini.</p>
                    </div>
                </div>
                <div class="px-6 py-5">
                    @if ($prodis->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($prodis as $prodi)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-400 transition-colors bg-white flex flex-col gap-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded bg-blue-100 text-blue-800">
                                            {{ $prodi->kode_prodi }}
                                        </span>
                                    </div>
                                    <p class="font-medium text-gray-900">{{ $prodi->nama_prodi }}</p>
                                    @if (!empty($prodi->jenjang))
                                        <p class="text-xs text-gray-500">Jenjang: {{ $prodi->jenjang }}</p>
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
</div>
@endsection
