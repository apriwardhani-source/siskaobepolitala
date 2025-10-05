@extends('layouts.app')

@section('title', 'Edit Kurikulum')

@section('content')
<div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-white mb-6">Edit Kurikulum</h1>

    <form method="POST" action="{{ route('angkatan.update', $angkatan->id) }}">
        @csrf
        @method('PUT')

        <!-- Tahun Kurikulum -->
        <div class="mb-4">
            <label for="tahun_kurikulum" class="block text-sm font-medium text-white mb-1">
                Tahun Kurikulum *
            </label>
            <input type="text" name="tahun_kurikulum" id="tahun_kurikulum"
                   value="{{ old('tahun_kurikulum', $angkatan->tahun_kurikulum) }}" required
                   class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white
                          focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
            @error('tahun_kurikulum')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Mata Kuliah -->
        <div class="mb-4">
            <label for="matkul_id" class="block text-sm font-medium text-white mb-1">
                Mata Kuliah *
            </label>
            <select name="matkul_id" id="matkul_id" required
                    class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white
                           focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                @foreach($matkuls as $matkul)
                    <option value="{{ $matkul->id }}" {{ $angkatan->matkul_id == $matkul->id ? 'selected' : '' }}>
                        {{ $matkul->nama_matkul }}
                    </option>
                @endforeach
            </select>
            @error('matkul_id')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('admin.manage.angkatan') }}" 
               class="glass-button text-white font-medium py-2 px-4 rounded-lg">
                Batal
            </a>
            <button type="submit" class="glass-button-warning text-white font-medium py-2 px-4 rounded-lg">
                <i class="fas fa-save me-2"></i> Update Kurikulum
            </button>
        </div>
    </form>
</div>
@endsection
