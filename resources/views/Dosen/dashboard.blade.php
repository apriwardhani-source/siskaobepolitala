@extends('layouts.dosen.app')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="bg-white p-4 md:p-6 lg:p-8 rounded-lg shadow-md">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Dosen</h1>
        <p class="text-gray-600 mt-2">Selamat datang, {{ auth()->user()->name }}</p>
        <hr class="border-t-4 border-black my-5">
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Mata Kuliah Diampu</p>
                    <h2 class="text-4xl font-bold mt-2">{{ $totalMK }}</h2>
                </div>
                <i class="bi bi-book text-5xl opacity-80"></i>
            </div>
        </div>

        <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Total Mahasiswa</p>
                    <h2 class="text-4xl font-bold mt-2">{{ $totalMahasiswa }}</h2>
                </div>
                <i class="bi bi-people text-5xl opacity-80"></i>
            </div>
        </div>

        <div class="bg-purple-500 text-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Program Studi</p>
                    <h2 class="text-lg font-bold mt-2">{{ auth()->user()->prodi->nama_prodi ?? '-' }}</h2>
                </div>
                <i class="bi bi-building text-5xl opacity-80"></i>
            </div>
        </div>
    </div>

    <!-- Mata Kuliah yang Diampu -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Mata Kuliah yang Diampu</h2>
        
        @if($mataKuliahs->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-3 text-center text-sm font-semibold">No</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Kode MK</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Nama Mata Kuliah</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold">SKS</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold">Semester</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($mataKuliahs as $index => $mk)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 text-center text-sm">{{ $index + 1 }}</td>
                                <td class="px-4 py-4 text-sm">{{ $mk->kode_mk }}</td>
                                <td class="px-4 py-4 text-sm">{{ $mk->nama_mk }}</td>
                                <td class="px-4 py-4 text-center text-sm">{{ $mk->sks_mk }}</td>
                                <td class="px-4 py-4 text-center text-sm">{{ $mk->semester_mk }}</td>
                                <td class="px-4 py-4 text-center">
                                    <a href="{{ route('dosen.penilaian.index') }}" 
                                       class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded-md text-sm">
                                        <i class="bi bi-pencil-square mr-1"></i>Input Nilai
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="bi bi-exclamation-triangle text-yellow-400 text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Anda belum ditugaskan untuk mengampu mata kuliah. Silakan hubungi Admin Prodi untuk penugasan.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
