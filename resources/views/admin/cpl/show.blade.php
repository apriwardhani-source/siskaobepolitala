@extends('layouts.app')

@section('title', 'Detail CPL: ' . $cpl->kode_cpl)

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">{{ $cpl->kode_cpl }}</h1>
                <p class="text-sm text-gray-300 mt-1">{{ $cpl->deskripsi }}</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('cpl.index') }}" class="glass-button">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
                <a href="{{ route('cpmk.create') }}" class="glass-button text-lg">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Banyak CPMK
                </a>
            </div>
        </div>

        @if($cpl->cpmks->count() > 0)
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-white mb-2">Ringkasan:</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="glass-card p-4 rounded-lg">
                        <h3 class="font-medium text-white">Jumlah CPMK</h3>
                        <p class="text-2xl font-bold text-blue-300">{{ $cpl->cpmks->count() }}</p>
                    </div>
                    <div class="glass-card p-4 rounded-lg">
                        <h3 class="font-medium text-white">Jumlah MK Terkait</h3>
                        <p class="text-2xl font-bold text-green-300">{{ $cpl->cpmks->sum(function($cpmk) { return $cpmk->mataKuliahs->count(); }) }}</p>
                    </div>
                    <div class="glass-card p-4 rounded-lg">
                        <h3 class="font-medium text-white">Rata-rata MK per CPMK</h3>
                        <p class="text-2xl font-bold text-yellow-300">{{ $cpl->cpmks->count() > 0 ? number_format($cpl->cpmks->sum(function($cpmk) { return $cpmk->mataKuliahs->count(); }) / $cpl->cpmks->count(), 1) : 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <h2 class="text-xl font-semibold text-white mb-4">Daftar CPMK terkait:</h2>
                <table class="min-w-full text-sm text-white border border-white/30 border-collapse">
                    <thead class="bg-white/10 border-b border-white/30">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Kode CPMK</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Deskripsi CPMK</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Jumlah MK</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/5">
                        @foreach($cpl->cpmks as $index => $cpmk)
                        <tr class="hover:bg-white/5">
                            <td class="px-4 py-3 align-top border border-white/20">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 align-top font-semibold border border-white/20">{{ $cpmk->kode_cpmk }}</td>
                            <td class="px-4 py-3 align-top border border-white/20">{!! nl2br(e($cpmk->deskripsi)) !!}</td>
                            <td class="px-4 py-3 align-top border border-white/20">{{ $cpmk->mataKuliahs->count() }}</td>
                            <td class="px-4 py-3 align-top border border-white/20">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('cpmk.edit', $cpmk->id) }}" class="glass-button-warning">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-300">Belum ada CPMK terkait dengan CPL ini.</p>
                <a href="{{ route('cpmk.create') }}" class="glass-button mt-4">
                    <i class="fas fa-plus me-2"></i> Tambah Banyak CPMK Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection