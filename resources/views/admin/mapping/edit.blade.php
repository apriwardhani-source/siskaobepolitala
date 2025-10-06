@extends('layouts.app')

@section('title', 'Edit Mapping CPMK → CPL')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">Edit Mapping CPMK → CPL</h1>
                <p class="text-sm text-gray-300 mt-1">Perbarui informasi mapping di bawah ini.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('mapping.index') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="glass-card rounded-lg p-4 mb-4 text-red-200 border border-red-400">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Terjadi kesalahan input:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('mapping.update', $mapping->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- CPL -->
                <div>
                    <label class="block text-sm font-medium text-white mb-1">CPL</label>
                    <select name="cpl_id" class="glass-input w-full py-2 px-4 rounded-lg">
                        @foreach($cpls as $cpl)
                            <option value="{{ $cpl->id }}" {{ $mapping->cpl_id == $cpl->id ? 'selected' : '' }}>
                                {{ $cpl->kode_cpl }} - {{ Str::limit($cpl->deskripsi, 50) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- CPMK -->
                <div>
                    <label class="block text-sm font-medium text-white mb-1">CPMK</label>
                    <select name="cpmk_id" class="glass-input w-full py-2 px-4 rounded-lg">
                        @foreach($cpmks as $cpmk)
                            <option value="{{ $cpmk->id }}" {{ $mapping->cpmk_id == $cpmk->id ? 'selected' : '' }}>
                                {{ $cpmk->kode_cpmk }} - {{ Str::limit($cpmk->deskripsi, 50) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Mata Kuliah (Checkbox Vertikal) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-white mb-2">Mata Kuliah (bisa pilih banyak)</label>
                    <div class="bg-white/5 border border-white/10 rounded-lg p-4 max-h-64 overflow-y-auto">
                        @foreach($mataKuliahs as $mk)
                            <div class="flex items-center mb-2 text-white hover:bg-white/10 rounded-lg px-2 py-1 transition">
                                <input type="checkbox"
                                       name="mata_kuliah_ids[]"
                                       value="{{ $mk->id }}"
                                       class="w-4 h-4 accent-blue-500 rounded mr-2"
                                       {{ in_array($mk->id, $selectedMataKuliahs ?? []) ? 'checked' : '' }}>
                                <label>{{ $mk->kode_matkul }} - {{ $mk->nama_matkul }}</label>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Centang semua mata kuliah yang relevan.</p>
                </div>

                <!-- Bobot -->
                <div class="md:col-span-2">
                    <label for="bobot" class="block text-sm font-medium text-white mb-1">Bobot (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="bobot"
                           value="{{ old('bobot', $mapping->bobot) }}"
                           class="glass-input w-full py-2 px-4 rounded-lg"
                           placeholder="Contoh: 25.00">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-white/20">
                <button type="submit" class="glass-button text-white font-medium py-2 px-6 rounded-lg">
                    <i class="fas fa-save me-2"></i> Update Mapping
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
