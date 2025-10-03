<!-- resources/views/admin/create_mahasiswa.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Mahasiswa Baru')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
                <div>
                    <h1 class="text-2xl font-bold text-white">Tambah Mahasiswa Baru</h1>
                    <p class="text-sm text-gray-300 mt-1">Isi formulir di bawah ini untuk menambahkan mahasiswa baru.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.manage.mahasiswa') }}" 
                       class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.create.mahasiswa') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIM -->
                    <div>
                        <label for="nim" class="block text-sm font-medium text-white mb-1">NIM <span class="text-red-400">*</span></label>
                        <input type="text" name="nim" id="nim" value="{{ old('nim') }}" required
                               placeholder="Contoh: 2411010059"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 
                                      focus:border-transparent @error('nim') !border-red-500 @enderror">
                        @error('nim')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Mahasiswa -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-white mb-1">Nama Mahasiswa <span class="text-red-400">*</span></label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                               placeholder="Masukkan nama lengkap mahasiswa"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 
                                      focus:border-transparent @error('nama') !border-red-500 @enderror">
                        @error('nama')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tahun Kurikulum (Dropdown dari tabel Angkatan) -->
                    <div>
                        <label for="tahun_kurikulum" class="block text-sm font-medium text-white mb-1">Tahun Kurikulum <span class="text-red-400">*</span></label>
                        <select name="tahun_kurikulum" id="tahun_kurikulum" required
                                class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 
                                       focus:border-transparent @error('tahun_kurikulum') !border-red-500 @enderror">
                            <option value="">-- Pilih Tahun Kurikulum --</option>
                            @foreach($kurikulums as $item)
                                <option value="{{ $item->tahun_kurikulum }}" {{ old('tahun_kurikulum') == $item->tahun_kurikulum ? 'selected' : '' }}>
                                    {{ $item->tahun_kurikulum }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_kurikulum')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Program Studi -->
                    <div>
                        <label for="prodi_id" class="block text-sm font-medium text-white mb-1">Program Studi <span class="text-red-400">*</span></label>
                        <select name="prodi_id" id="prodi_id" required
                                class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 
                                       focus:border-transparent @error('prodi_id') !border-red-500 @enderror">
                            <option value="" disabled selected>-- Pilih Prodi --</option>
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
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 border-t border-white/20">
                    <a href="{{ route('admin.manage.mahasiswa') }}" 
                       class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                    <button type="submit" 
                            class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center inline-flex items-center justify-center">
                        <i class="fas fa-save me-2"></i> Simpan Mahasiswa
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
