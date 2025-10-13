@extends('layouts.app')

@section('title', 'Edit Mapping CPL → CPMK → MK')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <div class="flex justify-between mb-6 border-b border-white/20 pb-3">
            <h1 class="text-2xl font-bold text-white">
                Edit Mapping: {{ $cpl->kode_cpl }}
            </h1>
            <a href="{{ route('mapping.index') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('mapping.update.cpl', $cpl->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- CPL -->
            <div>
                <label class="block text-sm font-medium text-white mb-1">Capaian Pembelajaran Lulusan (CPL)</label>
                <input type="text" class="glass-input w-full bg-white/10 text-gray-300" 
                       value="{{ $cpl->kode_cpl }} - {{ $cpl->deskripsi }}" readonly>
            </div>

            <!-- CPMK -->
            <div>
                <label class="block text-sm font-medium text-white mb-1">Pilih CPMK yang tergabung dalam CPL ini</label>
                <div class="bg-white/5 border border-white/10 rounded-lg p-3 max-h-64 overflow-y-auto text-white">
                    @foreach ($allCpmks as $cpmk)
                        <label class="flex items-start mb-2 space-x-2">
                            <input type="checkbox" name="cpmk_ids[]" value="{{ $cpmk->id }}"
                                   class="accent-blue-500 mt-1"
                                   {{ in_array($cpmk->id, $selectedCpmks) ? 'checked' : '' }}>
                            <span><strong>{{ $cpmk->kode_cpmk }}</strong> – {!! nl2br(e($cpmk->deskripsi)) !!}</span>
                        </label>
                    @endforeach
                </div>
                @error('cpmk_ids')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Daftar MK -->
            <div>
                <label class="block text-sm font-medium text-white mb-1">Mata Kuliah Terkait</label>
                <div class="bg-white/5 border border-white/10 rounded-lg p-3 text-white">
                    @foreach ($cpl->cpmks as $cpmk)
                        @if($cpmk->mataKuliahs->isNotEmpty())
                            <p class="font-semibold text-blue-300 mt-2">{{ $cpmk->kode_cpmk }}:</p>
                            <ul class="list-disc list-inside text-sm mb-2">
                                @foreach ($cpmk->mataKuliahs as $mk)
                                    <li>{{ $mk->kode_matkul }} - {{ $mk->nama_matkul }}</li>
                                @endforeach
                            </ul>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-white/20">
                <a href="{{ route('mapping.index') }}" class="glass-button text-white font-medium py-2 px-6 rounded-lg">
                    <i class="fas fa-times me-2"></i> Batal
                </a>
                <button type="submit" class="glass-button text-white font-medium py-2 px-6 rounded-lg">
                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
