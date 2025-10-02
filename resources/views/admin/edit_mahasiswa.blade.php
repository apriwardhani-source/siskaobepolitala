@extends('layouts.app')

@section('title', 'Edit Mahasiswa')

@section('content')
<div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-white mb-6">Edit Mahasiswa</h1>

    <form method="POST" action="{{ route('admin.update.mahasiswa', $mahasiswa->id) }}">
        @csrf
        @method('PUT')

        <!-- NIM -->
        <div class="mb-4">
            <label for="nim" class="block text-sm font-medium text-white mb-1">NIM</label>
            <input type="text" name="nim" id="nim" value="{{ old('nim', $mahasiswa->nim) }}" required
                class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white">
        </div>

        <!-- Nama -->
        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-white mb-1">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $mahasiswa->nama) }}" required
                class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white">
        </div>

        <!-- Tahun Kurikulum -->
        <div class="mb-4">
    <label for="tahun_kurikulum" class="block text-sm font-medium text-white mb-1">Tahun Kurikulum *</label>
    <select name="tahun_kurikulum" id="tahun_kurikulum" required
            class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white">
        <option value="">-- Pilih Tahun Kurikulum --</option>
        @foreach($angkatans as $angkatan)
            <option value="{{ $angkatan->tahun_kurikulum }}" 
                {{ old('tahun_kurikulum', $mahasiswa->tahun_kurikulum ?? '') == $angkatan->tahun_kurikulum ? 'selected' : '' }}>
                {{ $angkatan->tahun_kurikulum }}
            </option>
        @endforeach
    </select>
    @error('tahun_kurikulum')
        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
    @enderror
</div>


        <!-- Prodi -->
        <div class="mb-4">
            <label for="prodi_id" class="block text-sm font-medium text-white mb-1">Program Studi</label>
            <select name="prodi_id" id="prodi_id" required
                class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white">
                @foreach($prodis as $prodi)
                    <option value="{{ $prodi->id }}" {{ $mahasiswa->prodi_id == $prodi->id ? 'selected' : '' }}>
                        {{ $prodi->nama_prodi }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end space-x-3">
    <!-- Tombol Batal -->
    <a href="{{ route('admin.manage.mahasiswa') }}" 
       class="glass-button text-sm font-medium px-4 py-2">
        <i class="fas fa-times me-1"></i>
        Batal
    </a>

    <!-- Tombol Simpan -->
    <button type="submit" 
        class="glass-button text-white font-medium px-4 py-2">
        <i class="fas fa-save me-2"></i>
        Simpan Mahasiswa
    </button>
</div>

    </form>
</div>
@endsection
