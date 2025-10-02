<!-- resources/views/admin/create_prodi.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Prodi Baru')

@section('content')
    <div class="max-w-4xl mx-auto"> <!-- Batasi lebar maksimum untuk tampilan lebih baik -->
        <!-- Gunakan glass-card untuk wrapper utama konten -->
        <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto"> 
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
                <div>
                    <h1 class="text-2xl font-bold text-white">Tambah Program Studi Baru</h1>
                    <p class="text-sm text-gray-300 mt-1">Isi formulir di bawah ini untuk menambahkan program studi baru.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('prodi.index') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('prodi.store') }}" class="space-y-6">
                @csrf

                <!-- Grid untuk field-field utama -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode Prodi -->
                    <div>
                        <label for="kode_prodi" class="block text-sm font-medium text-white mb-1">Kode Prodi <span class="text-red-400">*</span></label>
                        <input type="text" name="kode_prodi" id="kode_prodi" value="{{ old('kode_prodi') }}" required
                               placeholder="Contoh: TI, SI"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('kode_prodi') !border-red-500 @enderror">
                        @error('kode_prodi')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Prodi -->
                    <div>
                        <label for="nama_prodi" class="block text-sm font-medium text-white mb-1">Nama Prodi <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_prodi" id="nama_prodi" value="{{ old('nama_prodi') }}" required
                               placeholder="Contoh: Teknik Informatika"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('nama_prodi') !border-red-500 @enderror">
                        @error('nama_prodi')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenjang (Opsional, bisa ditambahkan jika ada di migrasi/model) -->
                  
                    <div>
                        <label for="jenjang" class="block text-sm font-medium text-white mb-1">Jenjang</label>
                        <select name="jenjang" id="jenjang"
                                class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('jenjang') !border-red-500 @enderror">
                            <option value="" disabled selected>Pilih Jenjang</option>
                            <option value="Diploma 3" {{ old('jenjang') === 'Diploma 3' ? 'selected' : '' }}>Diploma 3</option>
                            <option value="Diploma 4" {{ old('jenjang') === 'Diploma 4' ? 'selected' : '' }}>Diploma 4</option>
                        </select>
                        @error('jenjang')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                

                    <!-- Deskripsi (Opsional, bisa ditambahkan jika ada di migrasi/model) -->
                    <!--
                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block text-sm font-medium text-white mb-1">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                                  placeholder="Deskripsi singkat tentang program studi ini..."
                                  class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('deskripsi') !border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    -->
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 border-t border-white/20">
                    <a href="{{ route('prodi.index') }}" class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                    <button type="submit" class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center inline-flex items-center justify-center">
                        <i class="fas fa-save me-2"></i> Simpan Prodi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection