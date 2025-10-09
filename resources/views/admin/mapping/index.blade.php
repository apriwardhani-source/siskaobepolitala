@extends('layouts.app')

@section('title', 'Kelola Mapping CPL → CPMK → MK')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">Kelola Mapping CPL → CPMK → MK</h1>
                <p class="text-sm text-gray-300 mt-1">
                    Daftar seluruh hubungan antara CPL, CPMK, dan Mata Kuliah.
                </p>
            </div>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="glass-card rounded-lg p-4 mb-4 text-green-200 border border-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="glass-card rounded-lg p-4 mb-4 text-red-200 border border-red-400">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabel Mapping -->
        <div class="glass-card rounded-lg overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white/10">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">CPL</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Deskripsi CPL</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">CPMK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">MK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kode MK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white/10 divide-y divide-gray-200">
                        @forelse ($grouped as $group)
                            <tr class="border-b border-white/10 align-top">
                                <!-- CPL -->
                                <td class="px-6 py-4 text-sm text-white font-semibold align-top">
                                    {{ $group['cpl']->kode_cpl }}
                                </td>
                                <td class="px-6 py-4 text-sm text-white align-top">
                                    {{ Str::limit($group['cpl']->deskripsi, 120) }}
                                </td>

                                <!-- CPMK list -->
                                <td class="px-6 py-4 text-sm text-white align-top">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($group['cpmks'] as $cpmk)
                                            <li>
                                                <strong>{{ $cpmk->kode_cpmk }}</strong> – {{ Str::limit($cpmk->deskripsi, 80) }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>

                                <!-- MK list -->
                                <td class="px-6 py-4 text-sm text-white align-top">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($group['mataKuliahs'] as $mk)
                                            <li>{{ $mk->nama_matkul }}</li>
                                        @endforeach
                                    </ul>
                                </td>

                                <!-- Kode MK -->
                                <td class="px-6 py-4 text-sm text-white align-top">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($group['mataKuliahs'] as $mk)
                                            <li>{{ $mk->kode_matkul }}</li>
                                        @endforeach
                                    </ul>
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4 text-sm text-white align-top">
                                    <div class="flex flex-col space-y-2">
                                        <a href="{{ route('mapping.edit', $group['cpl']->id) }}" class="glass-button-warning text-center">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-300">
                                    <i class="fas fa-exclamation-circle me-2"></i> Belum ada mapping CPL → CPMK → MK.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
