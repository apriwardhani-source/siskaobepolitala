@extends('layouts.app')

@section('title', 'Detail CPMK')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">Detail CPMK</h1>
                <p class="text-sm text-gray-300 mt-1">Informasi lengkap tentang CPMK {{ $cpmk->kode_cpmk }}.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('cpmk.index') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <p class="text-sm font-medium text-white mb-1">Kode CPMK:</p>
                <p class="text-white">{{ $cpmk->kode_cpmk }}</p>
            </div>

            <div>
                <p class="text-sm font-medium text-white mb-1">Deskripsi CPMK:</p>
                <p class="text-white">{{ $cpmk->deskripsi }}</p>
            </div>

            <div>
                <p class="text-sm font-medium text-white mb-1">Dibuat pada:</p>
                <p class="text-white">{{ $cpmk->created_at->format('d M Y H:i') }}</p>
            </div>

            <div>
                <p class="text-sm font-medium text-white mb-1">Diperbarui pada:</p>
                <p class="text-white">{{ $cpmk->updated_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-white/20 mt-6">
            <a href="{{ route('cpmk.edit', $cpmk->id) }}" class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection
