<!-- resources/views/admin/edit_user.blade.php -->
@extends('layouts.app')

@section('title', 'Edit User: ' . $user->name)

@section('content')
    <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-white mb-6">Edit User: {{ $user->name }}</h1>

        <form method="POST" action="{{ route('admin.update.user', $user->id) }}"> <!-- Perhatikan action -->
            @csrf
            @method('PUT') <!-- Gunakan method PUT untuk update -->

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-white mb-1">Nama *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                       class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                @error('name')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-white mb-1">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                       class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                @error('email')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-white mb-1">Role *</label>
                <select name="role" id="role" required
                        class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="dosen" {{ old('role', $user->role) === 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="akademik" {{ old('role', $user->role) === 'akademik' ? 'selected' : '' }}>Akademik Prodi</option>
                    <option value="kaprodi" {{ old('role', $user->role) === 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                    <option value="wadir" {{ old('role', $user->role) === 'wadir' ? 'selected' : '' }}>Wadir I</option>
                </select>
                @error('role')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Optional: Kolom password jika ingin diubah -->
            <!--
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-white mb-1">Password (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password" id="password"
                       class="w-full bg-white/20 border border-white/30 rounded-lg py-2 px-4 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                @error('password')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            -->

            <div class="flex items-center justify-end space-x-3 mt-6">
                <a href="{{ route('admin.manage.users') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="glass-button text-white font-medium px-4 py-2">
                    <i class="fas fa-save me-2"></i>
                    Update User
                </button>
            </div>
        </form>
    </div>
@endsection