@extends('layouts.wadir1.app')
@section('title','Visi & Misi Politala')
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
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Visi &amp; Misi Politala</h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Ringkasan arah dan tujuan institusi sebagai panduan seluruh program OBE.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content cards -->
        <div class="grid gap-6 md:grid-cols-2">

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
                    @if(isset($misis) && $misis->count() > 0)
                        <ol class="space-y-3">
                            @foreach ($misis as $index => $m)
                                <li class="flex items-start space-x-3">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-500 text-white text-xs font-semibold mt-0.5 shadow">
                                        {{ $index + 1 }}
                                    </span>
                                    <p class="text-gray-700 leading-relaxed">
                                        {{ $m->misi }}
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

    </div>
</div>
@endsection
