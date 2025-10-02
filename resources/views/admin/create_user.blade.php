<!-- resources/views/admin/create_user.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Akun Pengguna')

@section('content')
    <div class="max-w-4xl mx-auto"> <!-- Batasi lebar maksimum untuk tampilan lebih baik -->
        <!-- Gunakan glass-card untuk wrapper utama konten -->
         <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto"> 
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
                <div>
                    <h1 class="text-2xl font-bold text-white">Tambah Akun Pengguna Baru</h1>
                    <p class="text-sm text-gray-300 mt-1">Isi formulir di bawah ini untuk menambahkan akun pengguna baru.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.manage.users') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.create.user') }}" class="space-y-6">
                @csrf

                <!-- Grid untuk field-field utama -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-white mb-1">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               placeholder="Masukkan nama lengkap pengguna"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('name') !border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-white mb-1">Alamat Email <span class="text-red-400">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               placeholder="user@example.com"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('email') !border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-white mb-1">Peran <span class="text-red-400">*</span></label>
                        <select name="role" id="role" required
                                class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('role') !border-red-500 @enderror">
                            <option value="" disabled selected>Pilih Peran</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="dosen" {{ old('role') === 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="akademik" {{ old('role') === 'akademik' ? 'selected' : '' }}>Akademik Prodi</option>
                            <option value="kaprodi" {{ old('role') === 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                            <option value="wadir" {{ old('role') === 'wadir' ? 'selected' : '' }}>Wadir I</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-white mb-1">Kata Sandi <span class="text-red-400">*</span></label>
                        <input type="password" name="password" id="password" required
                               placeholder="Minimal 8 karakter"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('password') !border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-white mb-1">Konfirmasi Kata Sandi <span class="text-red-400">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               placeholder="Ulangi kata sandi"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 border-t border-white/20">
                    <a href="{{ route('admin.manage.users') }}" class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                    <button type="submit" class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center inline-flex items-center justify-center">
                        <i class="fas fa-user-plus me-2"></i> Tambahkan User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
<!-- Akhir dari resources/views/admin/create_user.blade.php -->