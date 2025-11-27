@extends('layouts.app')

@section('title', 'Visi & Misi Prodi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Visi &amp; Misi Program Studi</h1>
            <p class="mt-2 text-sm text-gray-600">
                Halaman ini menampilkan visi utama serta rincian misi program studi sebagai dasar penyusunan kurikulum OBE.
            </p>
        </div>

        <div class="space-y-8">
            {{-- Visi Section --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Visi Program Studi</h2>
                @if ($visis)
                    <p class="text-gray-800 leading-relaxed whitespace-pre-line">
                        {{ $visis->deskripsi ?? $visis->visi ?? '' }}
                    </p>
                @else
                    <p class="text-gray-500 text-sm">
                        Data visi belum tersedia. Silakan tambahkan data visi di modul administrasi yang sesuai.
                    </p>
                @endif
            </div>

            {{-- Misi Section --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Misi Program Studi</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                        {{ $misis->count() }} Misi
                    </span>
                </div>

                @if ($misis->isNotEmpty())
                    <ol class="space-y-3 list-decimal list-inside text-gray-800">
                        @foreach ($misis as $misi)
                            <li class="leading-relaxed">
                                {{ $misi->deskripsi ?? $misi->misi ?? '' }}
                            </li>
                        @endforeach
                    </ol>
                @else
                    <p class="text-gray-500 text-sm">
                        Data misi belum tersedia. Silakan tambahkan data misi terkait visi yang dipilih.
                    </p>
                @endif
            </div>

            {{-- Informasi Prodi --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Program Studi</h2>
                @if ($prodis->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($prodis as $prodi)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-400 transition-colors">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded bg-blue-100 text-blue-800">
                                        {{ $prodi->kode_prodi }}
                                    </span>
                                </div>
                                <p class="font-medium text-gray-900">{{ $prodi->nama_prodi }}</p>
                                @if (!empty($prodi->jenjang))
                                    <p class="text-xs text-gray-500 mt-1">Jenjang: {{ $prodi->jenjang }}</p>
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

