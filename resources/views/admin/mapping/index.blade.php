@extends('layouts.app')

@section('title', 'Kelola Mapping CPL → CPMK → MK')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">Kelola Mapping CPL → CPMK → MK</h1>
                <p class="text-sm text-gray-300 mt-1">
                    Daftar hubungan MK dengan CPL & CPMK dalam format bertingkat.
                </p>
            </div>
            <a href="{{ route('mapping.create') }}" class="glass-button text-lg">
                <i class="fas fa-plus-circle me-2"></i> Tambah Mapping Baru
            </a>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="glass-card rounded-lg p-4 mb-4 text-green-200 border border-green-400">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel -->
        <div class="glass-card rounded-lg overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full text-white border border-white/30 border-collapse">
                    <thead class="bg-white/10 border-b border-white/30">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">MK</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">CPL</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">CPMK</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider border border-white/30">Total</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white/5">
                        @forelse ($grouped as $item)
                            @php
                                $count = count($item['rows']);
                            @endphp
                            @foreach ($item['rows'] as $index => $row)
                                <tr class="hover:bg-white/5">
                                    <!-- MK hanya muncul sekali di atas -->
                                    @if ($index == 0)
                                        <td class="px-6 py-4 font-semibold align-top border border-white/30" rowspan="{{ $count }}">
                                            {{ $item['mk']->kode_matkul }}
                                        </td>
                                    @endif

                                    <!-- CPL -->
                                    <td class="px-6 py-4 border border-white/20">
                                        {{ $row['cpl'] }}
                                    </td>

                                    <!-- CPMK -->
                                    <td class="px-6 py-4 border border-white/20">
                                        {{ $row['cpmk'] }}
                                    </td>

                                    <!-- Total -->
                                    <td class="px-6 py-4 text-center font-bold text-blue-300 border border-white/20">
                                        {{ $row['total'] }}
                                    </td>
                                </tr>
                            @endforeach
                            
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-300">
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
