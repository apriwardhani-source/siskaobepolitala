@extends('layouts.app')

@section('title', 'Edit Mata Kuliah')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">

            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
                <div>
                    <h1 class="text-2xl font-bold text-white">Edit Mata Kuliah</h1>
                    <p class="text-sm text-gray-300 mt-1">Perbarui data mata kuliah berikut.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.manage.matkul') }}" 
                       class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Form Edit -->
            <form method="POST" action="{{ route('admin.update.matkul', $matkul->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode Mata Kuliah -->
                    <div>
                        <label for="kode_matkul" class="block text-sm font-medium text-white mb-1">Kode Mata Kuliah <span class="text-red-400">*</span></label>
                        <input type="text" name="kode_matkul" id="kode_matkul" value="{{ old('kode_matkul', $matkul->kode_matkul) }}" required
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 @error('kode_matkul') !border-red-500 @enderror">
                        @error('kode_matkul')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Mata Kuliah -->
                    <div>
                        <label for="nama_matkul" class="block text-sm font-medium text-white mb-1">Nama Mata Kuliah <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_matkul" id="nama_matkul" value="{{ old('nama_matkul', $matkul->nama_matkul) }}" required
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 @error('nama_matkul') !border-red-500 @enderror">
                        @error('nama_matkul')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SKS -->
                    <div>
                        <label for="sks" class="block text-sm font-medium text-white mb-1">Jumlah SKS <span class="text-red-400">*</span></label>
                        <input type="number" name="sks" id="sks" value="{{ old('sks', $matkul->sks) }}" required min="1" max="6"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 @error('sks') !border-red-500 @enderror">
                        @error('sks')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prodi -->
                    <div>
                        <label for="prodi_id" class="block text-sm font-medium text-white mb-1">Program Studi <span class="text-red-400">*</span></label>
                        <select name="prodi_id" id="prodi_id" required
                                class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 @error('prodi_id') !border-red-500 @enderror">
                            <option value="" disabled>Pilih Prodi</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}" {{ old('prodi_id', $matkul->prodi_id) == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 border-t border-white/20">
                    <a href="{{ route('admin.manage.matkul') }}" 
                       class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                    <button type="submit" 
                            class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center inline-flex items-center justify-center">
                        <i class="fas fa-save me-2"></i> Update Mata Kuliah
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
