@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8 px-4">
    <div class="container-fluid max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.settings.index') }}" class="text-gray-500 hover:text-indigo-600 transition-colors">
                            <i class="fas fa-arrow-left text-2xl"></i>
                        </a>
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-cyan-600 rounded-2xl blur opacity-75"></div>
                            <div class="relative bg-gradient-to-br from-blue-500 to-cyan-600 text-white p-4 rounded-2xl">
                                <i class="fas fa-user-circle text-4xl"></i>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-700 bg-clip-text text-transparent mb-1">Profil Akun</h1>
                            <p class="text-gray-600 text-sm">Kelola informasi profil Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 flex items-center gap-3 animate-fade-in">
            <i class="fas fa-check-circle text-green-500 text-2xl"></i>
            <div>
                <h4 class="font-bold text-green-800">Berhasil!</h4>
                <p class="text-green-700 text-sm">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Profile Content -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="p-8">
                <div class="text-center mb-8">
                    <div class="inline-block relative">
                        <div class="w-32 h-32 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex items-center justify-center text-white text-5xl font-bold shadow-2xl">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mt-4">{{ $user->name ?? 'User' }}</h2>
                    <p class="text-gray-500">{{ $user->email ?? 'user@example.com' }}</p>
                    <span class="inline-block mt-2 px-4 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                        <i class="fas fa-shield-alt mr-1"></i>{{ ucfirst($user->role ?? 'admin') }}
                    </span>
                </div>

                <!-- Update Profile Form -->
                <form action="{{ route('admin.settings.profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fas fa-user text-blue-500 mr-2"></i>Nama Lengkap
                            </label>
                            <input type="text" 
                                   name="name"
                                   class="w-full px-4 py-3 border-2 @error('name') border-red-500 @else border-gray-200 @enderror rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all" 
                                   value="{{ old('name', $user->name ?? '') }}" 
                                   placeholder="Nama Lengkap"
                                   required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fas fa-envelope text-blue-500 mr-2"></i>Email
                            </label>
                            <input type="email" 
                                   name="email"
                                   class="w-full px-4 py-3 border-2 @error('email') border-red-500 @else border-gray-200 @enderror rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all" 
                                   value="{{ old('email', $user->email ?? '') }}" 
                                   placeholder="email@example.com"
                                   required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.settings.index') }}" 
                           class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-600 hover:to-cyan-700 text-white rounded-xl font-semibold shadow-lg transition-all transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>Simpan Profil
                        </button>
                    </div>
                </form>

                <!-- Update Password Form (Separate) -->
                <form action="{{ route('admin.settings.password.update') }}" method="POST" class="mt-8 pt-8 border-t border-gray-200">
                    @csrf
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-lock text-purple-500 mr-2"></i>Ubah Password
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Password Lama</label>
                            <input type="password" 
                                   name="current_password"
                                   class="w-full px-4 py-3 border-2 @error('current_password') border-red-500 @else border-gray-200 @enderror rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all" 
                                   placeholder="••••••••">
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                                <input type="password" 
                                       name="password"
                                       class="w-full px-4 py-3 border-2 @error('password') border-red-500 @else border-gray-200 @enderror rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all" 
                                       placeholder="••••••••">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password</label>
                                <input type="password" 
                                       name="password_confirmation"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all" 
                                       placeholder="••••••••">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Password minimal 8 karakter
                        </p>
                    </div>

                    <div class="flex justify-end gap-4 pt-6">
                        <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white rounded-xl font-semibold shadow-lg transition-all transform hover:scale-105">
                            <i class="fas fa-key mr-2"></i>Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
