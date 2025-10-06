@extends('layouts.app')

@section('title', 'Tambah Mapping CPMK → CPL')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">Tambah Mapping CPMK → CPL Baru</h1>
                <p class="text-sm text-gray-300 mt-1">Isi formulir di bawah ini untuk menambahkan mapping baru.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('mapping.index') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('mapping.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- CPL -->
                <div>
                    <label class="block text-sm font-medium text-white mb-1">CPL</label>
                    <select name="cpl_id" class="glass-input w-full py-2 px-4 rounded-lg">
                        <option value="">-- Pilih CPL --</option>
                        @foreach($cpls as $cpl)
                            <option value="{{ $cpl->id }}">{{ $cpl->kode_cpl }} - {{ Str::limit($cpl->deskripsi, 40) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- CPMK -->
                <div>
                    <label class="block text-sm font-medium text-white mb-1">CPMK</label>
                    <select name="cpmk_id" class="glass-input w-full py-2 px-4 rounded-lg">
                        <option value="">-- Pilih CPMK --</option>
                        @foreach($cpmks as $cpmk)
                            <option value="{{ $cpmk->id }}">{{ $cpmk->kode_cpmk }} - {{ Str::limit($cpmk->deskripsi, 40) }}</option>
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
                                       class="w-4 h-4 accent-blue-500 rounded mr-2">
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
                           class="glass-input w-full py-2 px-4 rounded-lg"
                           placeholder="Contoh: 25.00">
                </div>
            </div>
@error('bobot')
    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
@enderror

            <div class="flex justify-end gap-3 pt-4 border-t border-white/20">
                <button type="submit" class="glass-button text-white font-medium py-2 px-6 rounded-lg">
                    <i class="fas fa-save me-2"></i> Simpan Mapping
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
