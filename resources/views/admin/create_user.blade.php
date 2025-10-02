<!-- resources/views/admin/create_user.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Akun Pengguna')

@section('content')
    <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-white mb-6">Tambah Akun Pengguna Baru</h1>

        <form method="POST" action="{{ route('admin.create.user') }}"> <!-- Gunakan route yang sesuai -->
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-white mb-1">Nama Lengkap *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                @error('name')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-white mb-1">Alamat Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                @error('email')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-white mb-1">Kata Sandi *</label>
                <input type="password" name="password" id="password" required
                       class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                @error('password')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-white mb-1">Konfirmasi Kata Sandi *</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                <!-- Tidak perlu @error untuk konfirmasi password, validasi biasanya dilakukan di controller -->
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-white mb-1">Peran *</label>
                <select name="role" id="role" required
                        class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
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

            <div class="flex items-center justify-end space-x-3 mt-6">
                <a href="{{ route('admin.manage.users') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="
                    backdrop-filter backdrop-blur-lg
                    bg-gradient-to-r from-green-400 to-blue-500 hover:from-pink-500 hover:to-yellow-500
                    text-white font-bold py-2 px-6 rounded-xl
                    shadow-xl transform transition hover:scale-105 duration-300 ease-in-out
                    focus:outline-none focus:ring-2 focus:ring-white/50 focus:ring-opacity-50
                ">
                    <i class="fas fa-user-plus me-2"></i>
                    Tambahkan User
                </button>
            </div>
        </form>
    </div>
@endsection