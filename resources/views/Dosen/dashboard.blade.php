@extends('layouts.dosen.app')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        {{-- Header dengan info Prodi (mirip Kaprodi) --}}
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard Kurikulum OBE</h1>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-100 text-blue-800 text-sm font-semibold">
                            {{ $prodi->kode_prodi ?? '-' }}
                        </span>
                        <span class="text-gray-700 font-medium">{{ $prodi->nama_prodi ?? '-' }}</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">
                        Monitoring progress implementasi kurikulum berbasis Outcome-Based Education untuk program studi Anda.
                    </p>
                </div>
            </div>
        </div>

        {{-- Bagian progress kurikulum dihilangkan untuk dashboard dosen --}}

        {{-- Mata Kuliah yang Diampu --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Mata Kuliah yang Diampu</h2>
                <span class="text-sm text-gray-500">
                    Total: {{ $totalMK }} MK, {{ $totalMahasiswa }} mahasiswa aktif
                </span>
            </div>
            <div class="overflow-x-auto">
                @if($mataKuliahs->count() > 0)
                    <table class="min-w-full bg-white text-sm divide-y divide-gray-200">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="px-4 py-3 text-center font-semibold">No</th>
                                <th class="px-4 py-3 text-left font-semibold">Kode MK</th>
                                <th class="px-4 py-3 text-left font-semibold">Nama Mata Kuliah</th>
                                <th class="px-4 py-3 text-center font-semibold">SKS</th>
                                <th class="px-4 py-3 text-center font-semibold">Semester</th>
                                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($mataKuliahs as $index => $mk)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">{{ $mk->kode_mk }}</td>
                                    <td class="px-4 py-3">{{ $mk->nama_mk }}</td>
                                    <td class="px-4 py-3 text-center">{{ $mk->sks_mk }}</td>
                                    <td class="px-4 py-3 text-center">{{ $mk->semester_mk }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('dosen.penilaian.index', ['kode_mk' => $mk->kode_mk]) }}"
                                           class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded-md text-xs font-semibold inline-flex items-center">
                                            <i class="bi bi-pencil-square mr-1"></i>Input Nilai
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-6">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
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
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
