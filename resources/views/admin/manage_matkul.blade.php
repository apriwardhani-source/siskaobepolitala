@extends('layouts.app')

@section('title', 'Kelola Mata Kuliah')

@section('content')
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <h1 class="text-2xl font-bold text-white mb-6">Kelola Data Mata Kuliah</h1>

        {{-- Alert sukses --}}
        @if(session('success'))
            <div class="glass-card rounded-lg p-4 mb-4 text-green-200 border border-green-400">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tombol Tambah Mata Kuliah --}}
        <div class="mb-4">
            <a href="{{ route('admin.create.matkul.form') }}" class="glass-button text-lg">
                <i class="fas fa-plus-circle me-2"></i>
                Tambah Mata Kuliah
            </a>
        </div>

        {{-- Tabel Data Mata Kuliah --}}
        <div class="glass-card rounded-lg overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full text-white border border-white/30 border-collapse">
                    <thead class="bg-white/10 border-b border-white/30">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border border-white/30">MK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border border-white/30">Nama MK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border border-white/30">CPL</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border border-white/30">CPMK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border border-white/30">Uraian CPMK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border border-white/30">SUB-CPMK</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/5">
                        @forelse($matakuliahs as $mk)
                            @php
                                $cpmk = $mk->cpmks->first();
                                $cpl = optional($cpmk?->cpl)->kode_cpl ?? '-';
                                $subList = $cpmk ? $cpmk->subCpmks->pluck('uraian')->implode("\n") : '';
                            @endphp
                            <tr class="hover:bg-white/5">
                                <td class="px-6 py-4 text-sm border border-white/20 align-top">{{ $mk->kode_matkul }}</td>
                                <td class="px-6 py-4 text-sm border border-white/20 align-top">{{ $mk->nama_matkul }}</td>
                                <td class="px-6 py-4 text-sm border border-white/20 align-top">{{ $cpl }}</td>
                                <td class="px-6 py-4 text-sm border border-white/20 align-top">{{ $cpmk->kode_cpmk ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm border border-white/20 align-top">{{ $cpmk->deskripsi ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm border border-white/20 align-top">{!! nl2br(e($subList ?: '-')) !!}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-sm text-gray-300 text-center border border-white/20">
                                    Tidak ada data mata kuliah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
