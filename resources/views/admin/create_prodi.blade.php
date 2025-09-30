<!-- resources/views/admin/create_prodi.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Prodi Baru')

@section('content')
    <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-white mb-6">Tambah Prodi Baru</h1>

        <form method="POST" action="{{ route('prodi.store') }}"> <!-- Sekarang route 'prodi.store' akan ditemukan -->
            @csrf

            <div class="mb-4">
                <label for="kode_prodi" class="block text-sm font-medium text-white mb-1">Kode Prodi *</label>
                <input type="text" name="kode_prodi" id="kode_prodi" value="{{ old('kode_prodi') }}" required
                       class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                @error('kode_prodi')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nama_prodi" class="block text-sm font-medium text-white mb-1">Nama Prodi *</label>
                <input type="text" name="nama_prodi" id="nama_prodi" value="{{ old('nama_prodi') }}" required
                       class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                @error('nama_prodi')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-3 mt-6">
                <a href="{{ route('prodi.index') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg"> <!-- Tombol Batal ke index -->
                    Batal
                </a>
                <button type="submit" class="glass-button text-white font-medium py-2 px-4 rounded-lg">
                    <i class="fas fa-save me-2"></i>
                    Simpan Prodi
                </button>
            </div>
        </form>
    </div>
@endsection