<!-- resources/views/admin/create_mahasiswa.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Mahasiswa Baru')

@section('content')
    <div class="max-w-4xl mx-auto"> <!-- Batasi lebar maksimum untuk tampilan lebih baik -->
        <!-- Gunakan glass-card untuk wrapper utama konten -->
        <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
                <div>
                    <h1 class="text-2xl font-bold text-white">Tambah Mahasiswa Baru</h1>
                    <p class="text-sm text-gray-300 mt-1">Isi formulir di bawah ini untuk menambahkan mahasiswa baru.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.manage.mahasiswa') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('mahasiswa.store') }}" class="space-y-6">
                @csrf

                <!-- Grid untuk field-field utama -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIM -->
                    <div>
                        <label for="nim" class="block text-sm font-medium text-white mb-1">NIM <span class="text-red-400">*</span></label>
                        <input type="text" name="nim" id="nim" value="{{ old('nim') }}" required
                               placeholder="Contoh: 2411010059"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('nim') !border-red-500 @enderror">
                        @error('nim')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Mahasiswa -->
                    <div>
                        <label for="nama_mahasiswa" class="block text-sm font-medium text-white mb-1">Nama Mahasiswa <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" required
                               placeholder="Masukkan nama lengkap mahasiswa"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('nama_mahasiswa') !border-red-500 @enderror">
                        @error('nama_mahasiswa')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email (Opsional, tambahkan jika ada di model/migrasi) -->
                    <!--
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-white mb-1">Alamat Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               placeholder="mahasiswa@example.com"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('email') !border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    -->

                    <!-- Jenis Kelamin (Opsional, tambahkan jika ada di model/migrasi) -->
                    <!--
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-white mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin"
                                class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('jenis_kelamin') !border-red-500 @enderror">
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    -->

            <!-- Angkatan -->
            <div class="mb-4">
                <label for="angkatan_id" class="block text-sm font-medium text-white mb-1">Angkatan *</label>
                <select name="angkatan_id" id="angkatan_id" required
                        class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('angkatan_id') !border-red-500 @enderror">
                    <option value="">-- Pilih Angkatan --</option>
                    @foreach($angkatans as $angkatan)
                        <option value="{{ $angkatan->id }}" {{ old('angkatan_id') == $angkatan->id ? 'selected' : '' }}>
                            {{ $angkatan->tahun_angkatan }} - {{ $angkatan->prodi->nama_prodi }}
                        </option>
                    @endforeach
                </select>
                @error('angkatan_id')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

                    <!-- Prodi -->
                    <div>
                        <label for="prodi_id" class="block text-sm font-medium text-white mb-1">Program Studi <span class="text-red-400">*</span></label>
                        <select name="prodi_id" id="prodi_id" required
                                class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('prodi_id') !border-red-500 @enderror">
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

                    <!-- Tanggal Lahir (Opsional, tambahkan jika ada di model/migrasi) -->
                    <!--
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-white mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('tanggal_lahir') !border-red-500 @enderror">
                        @error('tanggal_lahir')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    -->

                    <!-- Telepon (Opsional, tambahkan jika ada di model/migrasi) -->
                    <!--
                    <div>
                        <label for="telepon" class="block text-sm font-medium text-white mb-1">Nomor Telepon</label>
                        <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}"
                               placeholder="Contoh: 081234567890"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('telepon') !border-red-500 @enderror">
                        @error('telepon')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    -->

                    <!-- Alamat (Opsional, tambahkan jika ada di model/migrasi) -->
                    <!--
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-white mb-1">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3"
                                  placeholder="Alamat lengkap mahasiswa..."
                                  class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('alamat') !border-red-500 @enderror">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    -->
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 border-t border-white/20">
                    <a href="{{ route('admin.manage.mahasiswa') }}" class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                    <button type="submit" class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center inline-flex items-center justify-center">
                        <i class="fas fa-save me-2"></i> Simpan Mahasiswa
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection