@extends('layouts.app')

@section('title', 'Edit Prodi')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">

            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
                <div>
                    <h1 class="text-2xl font-bold text-white">Edit Program Studi</h1>
                    <p class="text-sm text-gray-300 mt-1">Perbarui data program studi di bawah ini.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.manage.prodi') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Form Edit -->
            <form method="POST" action="{{ route('admin.update.prodi', $prodi->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode Prodi -->
                    <div>
                        <label for="kode_prodi" class="block text-sm font-medium text-white mb-1">Kode Prodi <span class="text-red-400">*</span></label>
                        <input type="text" name="kode_prodi" id="kode_prodi" value="{{ old('kode_prodi', $prodi->kode_prodi) }}" required
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 @error('kode_prodi') !border-red-500 @enderror">
                        @error('kode_prodi')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Prodi -->
                    <div>
                        <label for="nama_prodi" class="block text-sm font-medium text-white mb-1">Nama Prodi <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_prodi" id="nama_prodi" value="{{ old('nama_prodi', $prodi->nama_prodi) }}" required
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 @error('nama_prodi') !border-red-500 @enderror">
                        @error('nama_prodi')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenjang -->
                    <div class="md:col-span-2">
                        <label for="jenjang" class="block text-sm font-medium text-white mb-1">Jenjang <span class="text-red-400">*</span></label>
                        <select name="jenjang" id="jenjang" required
                                class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 @error('jenjang') !border-red-500 @enderror">
                            <option value="" disabled>Pilih Jenjang</option>
                            <option value="Diploma" {{ old('jenjang', $prodi->jenjang) == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                            <option value="S1" {{ old('jenjang', $prodi->jenjang) == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('jenjang', $prodi->jenjang) == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('jenjang', $prodi->jenjang) == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                        @error('jenjang')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 border-t border-white/20">
                    <a href="{{ route('admin.manage.prodi') }}" class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                    <button type="submit" class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center inline-flex items-center justify-center">
                        <i class="fas fa-save me-2"></i> Update Prodi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
