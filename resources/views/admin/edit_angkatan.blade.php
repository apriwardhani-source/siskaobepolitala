@extends('layouts.app')

@section('title', 'Edit Angkatan')

@section('content')
<div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-white mb-6">Edit Angkatan</h1>

    <form method="POST" action="{{ route('angkatan.update', $angkatan->id) }}">
        @csrf
        @method('PUT')

        <!-- Tahun Kurikulum -->
        <div class="mb-4">
            <label for="tahun_kurikulum" class="block text-sm font-medium text-white mb-1">Tahun Kurikulum *</label>
            <input type="text" name="tahun_kurikulum" id="tahun_kurikulum"
                   value="{{ old('tahun_kurikulum', $angkatan->tahun_kurikulum) }}" required
                   class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white">
        </div>

        <!-- Prodi -->
        <div class="mb-4">
            <label for="prodi_id" class="block text-sm font-medium text-white mb-1">Program Studi *</label>
            <select name="prodi_id" id="prodi_id" required
                    class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white">
                @foreach($prodis as $prodi)
                    <option value="{{ $prodi->id }}" {{ $angkatan->prodi_id == $prodi->id ? 'selected' : '' }}>
                        {{ $prodi->nama_prodi }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.manage.angkatan') }}" class="glass-button-warning">Batal</a>
            <button type="submit" class="glass-button">Update</button>
        </div>
    </form>
</div>
@endsection
