<!-- resources/views/admin/cpl/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit CPL')

@section('content')
    <div class="max-w-4xl mx-auto"> <!-- Batasi lebar maksimum untuk tampilan lebih baik -->
        <!-- Gunakan glass-card untuk wrapper utama konten -->
        <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
                <div>
                    <h1 class="text-2xl font-bold text-white">Edit CPL</h1>
                    <p class="text-sm text-gray-300 mt-1">Perbarui informasi CPL di bawah ini.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('cpl.index') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
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

            <form method="POST" action="{{ route('cpl.update', $cpl->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Grid untuk field-field utama -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode CPL -->
                    <div>
                        <label for="kode_cpl" class="block text-sm font-medium text-white mb-1">Kode CPL <span class="text-red-400">*</span></label>
                        <input type="text" name="kode_cpl" id="kode_cpl" value="{{ old('kode_cpl', $cpl->kode_cpl) }}" required
                               placeholder="Contoh: CPL1, CPL_TI_01"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('kode_cpl') !border-red-500 @enderror">
                        @error('kode_cpl')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Threshold -->
                    <div>
                        <label for="threshold" class="block text-sm font-medium text-white mb-1">Threshold (%) <span class="text-red-400">*</span></label>
                        <input type="number" name="threshold" id="threshold" value="{{ old('threshold', $cpl->threshold) }}" required min="0" max="100" step="0.01"
                               placeholder="Contoh: 70.00"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('threshold') !border-red-500 @enderror">
                        @error('threshold')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prodi -->
                    <div class="md:col-span-2">
                        <label for="prodi_id" class="block text-sm font-medium text-white mb-1">Program Studi <span class="text-red-400">*</span></label>
                        <select name="prodi_id" id="prodi_id" required
                                class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('prodi_id') !border-red-500 @enderror">
                            <option value="" disabled>-- Pilih Program Studi --</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}" {{ old('prodi_id', $cpl->prodi_id) == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->kode_prodi }} - {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block text-sm font-medium text-white mb-1">Deskripsi CPL <span class="text-red-400">*</span></label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" required
                                  placeholder="Deskripsikan CPL secara lengkap..."
                                  class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('deskripsi') !border-red-500 @enderror">{{ old('deskripsi', $cpl->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 border-t border-white/20">
                    <a href="{{ route('cpl.index') }}" class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                    <button type="submit" class="
                        backdrop-filter backdrop-blur-lg
                        bg-gradient-to-r from-green-400 to-blue-500 hover:from-pink-500 hover:to-yellow-500
                        text-white font-bold py-2 px-6 rounded-xl
                        shadow-xl transform transition hover:scale-105 duration-300 ease-in-out
                        focus:outline-none focus:ring-2 focus:ring-white/50 focus:ring-opacity-50
                        inline-flex items-center justify-center
                    ">
                        <i class="fas fa-save me-2"></i> Update CPL
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection