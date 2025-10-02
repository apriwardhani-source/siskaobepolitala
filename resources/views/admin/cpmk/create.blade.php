<!-- resources/views/admin/cpmk/create.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah CPMK Baru')

@section('content')
    <div class="max-w-4xl mx-auto"> <!-- Batasi lebar maksimum untuk tampilan lebih baik -->
        <!-- Gunakan glass-card untuk wrapper utama konten -->
        <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
                <div>
                    <h1 class="text-2xl font-bold text-white">Tambah CPMK Baru</h1>
                    <p class="text-sm text-gray-300 mt-1">Isi formulir di bawah ini untuk menambahkan CPMK baru.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('cpmk.index') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
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

            <form method="POST" action="{{ route('cpmk.store') }}" class="space-y-6">
                @csrf

                <!-- Grid untuk field-field utama -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode CPMK -->
                    <div>
                        <label for="kode_cpmk" class="block text-sm font-medium text-white mb-1">Kode CPMK <span class="text-red-400">*</span></label>
                        <input type="text" name="kode_cpmk" id="kode_cpmk" value="{{ old('kode_cpmk') }}" required
                               placeholder="Contoh: CPMK1, CPMK_TI_MK01"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('kode_cpmk') !border-red-500 @enderror">
                        @error('kode_cpmk')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mata Kuliah -->
                    <div>
                        <label for="mata_kuliah_id" class="block text-sm font-medium text-white mb-1">Mata Kuliah <span class="text-red-400">*</span></label>
                        <select name="mata_kuliah_id" id="mata_kuliah_id" required
                                class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('mata_kuliah_id') !border-red-500 @enderror">
                            <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                            @foreach($mataKuliahs as $mk)
                                <option value="{{ $mk->id }}" {{ old('mata_kuliah_id') == $mk->id ? 'selected' : '' }}>
                                    {{ $mk->kode_mk }} - {{ $mk->nama_mk }} ({{ $mk->prodi->kode_prodi }})
                                </option>
                            @endforeach
                        </select>
                        @error('mata_kuliah_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block text-sm font-medium text-white mb-1">Deskripsi CPMK <span class="text-red-400">*</span></label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" required
                                  placeholder="Deskripsikan CPMK secara lengkap..."
                                  class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('deskripsi') !border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bobot (Opsional, tambahkan jika ada di model/migrasi) -->
                    <!--
                    <div>
                        <label for="bobot" class="block text-sm font-medium text-white mb-1">Bobot CPMK (%)</label>
                        <input type="number" name="bobot" id="bobot" value="{{ old('bobot') }}" min="0" max="100"
                               placeholder="Contoh: 25"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('bobot') !border-red-500 @enderror">
                        @error('bobot')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    -->
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 border-t border-white/20">
                    <a href="{{ route('cpmk.index') }}" class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center">
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
                        <i class="fas fa-save me-2"></i> Simpan CPMK
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection