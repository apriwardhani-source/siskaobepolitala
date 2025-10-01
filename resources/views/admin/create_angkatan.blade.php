<!-- resources/views/admin/create_angkatan.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Kurikulum Baru')

@section('content')
    <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-white mb-6">Tambah Kurikulum Baru</h1>

        <form method="POST" action="{{ route('angkatan.store') }}">
            @csrf

            <!-- Tahun Kurikulum -->
            <div class="mb-4">
                <label for="tahun_kurikulum" class="block text-sm font-medium text-white mb-1">Tahun Kurikulum *</label>
                <input type="text" name="tahun_kurikulum" id="tahun_kurikulum" value="{{ old('tahun_kurikulum') }}" required
                       class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white 
                              placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent"
                       placeholder="contoh: 2023">
                @error('tahun_kurikulum')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Prodi -->
            <div class="mb-4">
                <label for="prodi_id" class="block text-sm font-medium text-white mb-1">Program Studi *</label>
                <select name="prodi_id" id="prodi_id" required
                        class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white
                               focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                    <option value="">-- Pilih Prodi --</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id }}" {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>
                            {{ $prodi->nama_prodi }}
                        </option>
                    @endforeach
                </select>
                @error('prodi_id')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex items-center justify-end space-x-3 mt-6">
                <a href="{{ route('admin.manage.angkatan') }}" 
                   class="glass-button text-white font-medium py-2 px-4 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="glass-button text-white font-medium py-2 px-4 rounded-lg">
                    <i class="fas fa-save me-2"></i>
                    Simpan Kurikulum
                </button>
            </div>
        </form>
    </div>
@endsection
