<!-- resources/views/admin/mapping/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Mapping CPMK → CPL')

@section('content')
    <div class="max-w-4xl mx-auto"> <!-- Batasi lebar maksimum untuk tampilan lebih baik -->
        <!-- Gunakan glass-card untuk wrapper utama konten -->
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

                <!-- Grid untuk field-field utama -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- CPL -->
                    <div>
                        <label for="cpl_id" class="block text-sm font-medium text-white mb-1">CPL <span class="text-red-400">*</span></label>
                        <select name="cpl_id" id="cpl_id" required
                                class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('cpl_id') !border-red-500 @enderror">
                            <option value="" disabled>-- Pilih CPL --</option>
                            @foreach($cpls as $cpl)
                                <option value="{{ $cpl->id }}" {{ old('cpl_id', $mapping->cpl_id) == $cpl->id ? 'selected' : '' }}>
                                    {{ $cpl->kode_cpl }} - {{ Str::limit($cpl->deskripsi, 50) }}
                                </option>
                            @endforeach
                        </select>
                        @error('cpl_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CPMK -->
                    <div>
                        <label for="cpmk_id" class="block text-sm font-medium text-white mb-1">CPMK <span class="text-red-400">*</span></label>
                        <select name="cpmk_id" id="cpmk_id" required
                                class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('cpmk_id') !border-red-500 @enderror">
                            <option value="" disabled>-- Pilih CPMK --</option>
                            @foreach($cpmks as $cpmk)
                                <option value="{{ $cpmk->id }}" {{ old('cpmk_id', $mapping->cpmk_id) == $cpmk->id ? 'selected' : '' }}>
                                    {{ $cpmk->kode_cpmk }} - {{ $cpmk->mataKuliah->nama_mk ?? 'Mata Kuliah Tidak Diketahui' }} ({{ $cpmk->mataKuliah->prodi->kode_prodi ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        @error('cpmk_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bobot -->
                    <div class="md:col-span-2">
                        <label for="bobot" class="block text-sm font-medium text-white mb-1">Bobot Kontribusi (%) <span class="text-red-400">*</span></label>
                        <input type="number" name="bobot" id="bobot" value="{{ old('bobot', $mapping->bobot) }}" required min="0" max="100" step="0.01"
                               placeholder="Contoh: 25.00"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('bobot') !border-red-500 @enderror">
                        @error('bobot')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-300">Catatan: Total bobot mapping untuk satu CPMK tidak boleh melebihi 100%.</p>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 border-t border-white/20">
                    <a href="{{ route('mapping.index') }}" class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                    <button type="submit" class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center">
                        <i class="fas fa-save me-2"></i> Update Mapping
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection