@extends('layouts.kaprodi.app')
@section('title','Visi & Misi Politala')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header mirip Wadir1 -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                        <i class="fas fa-bullseye text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Visi &amp; Misi Politala</h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Ringkasan arah dan tujuan institusi sebagai panduan seluruh program OBE.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content cards (disamakan dengan Wadir1) -->
        <div class="grid gap-6 md:grid-cols-2 items-start">

            {{-- Visi Politala Section --}}
            <div class="bg-white rounded-2xl shadow-lg border border-blue-50 overflow-hidden flex flex-col">
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
                <div class="px-6 py-5 flex-1 flex items-start">
                    <p class="text-gray-700 leading-relaxed text-justify md:text-left whitespace-pre-line">
                        {{ $visis ? ($visis->visi ?? $visis->deskripsi) : 'Data visi belum tersedia' }}
                    </p>
                </div>
            </div>

            {{-- Misi Politala Section --}}
            <div class="bg-white rounded-2xl shadow-lg border border-green-50 overflow-hidden flex flex-col">
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
                <div class="px-6 py-5 flex-1">
                    @if(isset($misis) && $misis->count() > 0)
                        <div class="bg-emerald-50/70 rounded-xl px-4 py-4">
                            <ol class="space-y-3">
                                @foreach ($misis as $index => $m)
                                    <li class="flex items-start space-x-3">
                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-500 text-white text-sm font-semibold flex-shrink-0">
                                            {{ $loop->iteration }}
                                        </span>
                                        <p class="text-gray-700 leading-relaxed text-justify">
                                            {{ $m->misi ?? $m->deskripsi }}
                                        </p>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    @else
                        <p class="text-gray-700 text-center">Data misi belum tersedia</p>
                    @endif
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
