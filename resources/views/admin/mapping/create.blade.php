@extends('layouts.app')

@section('title', 'Tambah Mapping CPL → CPMK → MK')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <div class="flex justify-between mb-6 border-b border-white/20 pb-3">
            <h1 class="text-2xl font-bold text-white">Tambah Mapping CPL → CPMK → MK</h1>
            <a href="{{ route('mapping.index') }}" class="glass-button">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('mapping.store') }}" class="space-y-6">
            @csrf

            <!-- Pilih CPL -->
            <div>
                <label class="block text-sm font-medium text-white mb-1">Pilih CPL</label>
                <select name="cpl_id" class="glass-input w-full" required>
                    <option value="">-- Pilih CPL --</option>
                    @foreach ($cpls as $cpl)
                        <option value="{{ $cpl->id }}">
                            {{ $cpl->kode_cpl }} - {{ Str::limit($cpl->deskripsi, 80) }}
                        </option>
                    @endforeach
                </select>
                @error('cpl_id')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pilih CPMK -->
            <div>
                <label class="block text-sm font-medium text-white mb-1">Pilih CPMK (bisa banyak)</label>
                <div class="bg-white/5 border border-white/10 rounded-lg p-3 max-h-64 overflow-y-auto text-white">
                    @forelse ($cpmks as $cpmk)
                        <label class="flex items-start mb-2 space-x-2">
                            <input type="checkbox" name="cpmk_ids[]" value="{{ $cpmk->id }}" class="accent-blue-500 mt-1">
                            <div>
                                <strong>{{ $cpmk->kode_cpmk }}</strong> - {{ Str::limit($cpmk->deskripsi, 100) }}
                            </div>
                        </label>
                    @empty
                        <p class="text-gray-400 italic">Belum ada CPMK tersedia untuk digabungkan.</p>
                    @endforelse
                </div>
                @error('cpmk_ids')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end border-t border-white/20 pt-4">
                <button type="submit" class="glass-button px-6 py-2">
                    <i class="fas fa-save me-2"></i> Simpan Mapping
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
