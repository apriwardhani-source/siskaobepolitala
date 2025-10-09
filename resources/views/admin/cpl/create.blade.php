@extends('layouts.app')

@section('title', 'Tambah CPL Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6 border-b border-white/20 pb-4">
            <h1 class="text-2xl font-bold text-white">Tambah CPL Baru</h1>
            <a href="{{ route('cpl.index') }}" class="glass-button">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="glass-card rounded-lg p-4 mb-4 text-red-200 border border-red-400">
                <ul class="list-disc list-inside mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('cpl.store') }}" class="space-y-6">
            @csrf
            <div>
                <label for="kode_cpl" class="block text-sm font-medium text-white mb-1">Kode CPL</label>
                <input type="text" name="kode_cpl" id="kode_cpl" value="{{ old('kode_cpl') }}" required placeholder="Contoh: CPL01"
                       class="w-full glass-input py-2 px-4 rounded-lg">
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-white mb-1">Deskripsi CPL</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" required placeholder="Deskripsikan CPL..."
                          class="w-full glass-input py-2 px-4 rounded-lg">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-white/20">
                <a href="{{ route('cpl.index') }}" class="glass-button">
                    <i class="fas fa-times me-2"></i> Batal
                </a>
                <button type="submit" class="glass-button">
                    <i class="fas fa-save me-2"></i> Simpan CPL
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
