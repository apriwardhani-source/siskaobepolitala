@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Manajemen Pengguna</h1>
                    <p class="mt-2 text-sm text-gray-600">Kelola data pengguna sistem SISKA OBE</p>
                </div>
                
                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 
                          hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-lg 
                          shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200
                          focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                    Tambah Pengguna
                </a>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success'))
        <div id="alert-success" class="mb-6 rounded-lg bg-green-50 border-l-4 border-green-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-green-800">Berhasil!</h3>
                    <p class="mt-1 text-sm text-green-700">{{ session('success') }}</p>
                </div>
                <button onclick="this.closest('#alert-success').remove()" 
                        class="ml-4 text-green-500 hover:text-green-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if (session('sukses'))
        <div id="alert-sukses" class="mb-6 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-800">Perhatian!</h3>
                    <p class="mt-1 text-sm text-red-700">{{ session('sukses') }}</p>
                </div>
                <button onclick="this.closest('#alert-sukses').remove()" 
                        class="ml-4 text-red-500 hover:text-red-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if (session('warning'))
        <div id="alert-warning" class="mb-6 rounded-lg bg-amber-50 border-l-4 border-amber-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-amber-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-amber-800">Peringatan!</h3>
                    <p class="mt-1 text-sm text-amber-700">{{ session('warning') }}</p>
                </div>
                <button onclick="this.closest('#alert-warning').remove()" 
                        class="ml-4 text-amber-500 hover:text-amber-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if (session('error'))
        <div id="alert-error" class="mb-6 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-800">Terjadi Kesalahan</h3>
                    <p class="mt-1 text-sm text-red-700">{{ session('error') }}</p>
                </div>
                <button onclick="this.closest('#alert-error').remove()" 
                        class="ml-4 text-red-500 hover:text-red-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            
            <!-- Tab Filter -->
            <div class="border-b border-gray-200 bg-gray-50">
                <nav class="flex space-x-2 px-6 py-4 overflow-x-auto" aria-label="Tabs">
                    <a href="{{ route('admin.users.index', ['role' => 'all']) }}" 
                       class="group relative min-w-max px-5 py-3 text-sm font-medium rounded-lg transition-all duration-200
                              {{ $role == 'all' ? 'bg-white text-blue-700 shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-white/50' }}">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-users {{ $role == 'all' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                            <span>Semua</span>
                            <span class="inline-flex items-center justify-center min-w-[24px] h-6 px-2 text-xs font-semibold rounded-full
                                         {{ $role == 'all' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-600 group-hover:bg-gray-300' }}">
                                {{ $roleCounts['all'] }}
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" 
                       class="group relative min-w-max px-5 py-3 text-sm font-medium rounded-lg transition-all duration-200
                              {{ $role == 'admin' ? 'bg-white text-blue-700 shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-white/50' }}">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-shield-alt {{ $role == 'admin' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                            <span>Admin</span>
                            <span class="inline-flex items-center justify-center min-w-[24px] h-6 px-2 text-xs font-semibold rounded-full
                                         {{ $role == 'admin' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-600 group-hover:bg-gray-300' }}">
                                {{ $roleCounts['admin'] }}
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('admin.users.index', ['role' => 'wadir1']) }}" 
                       class="group relative min-w-max px-5 py-3 text-sm font-medium rounded-lg transition-all duration-200
                              {{ $role == 'wadir1' ? 'bg-white text-blue-700 shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-white/50' }}">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-briefcase {{ $role == 'wadir1' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                            <span>Wadir1</span>
                            <span class="inline-flex items-center justify-center min-w-[24px] h-6 px-2 text-xs font-semibold rounded-full
                                         {{ $role == 'wadir1' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-600 group-hover:bg-gray-300' }}">
                                {{ $roleCounts['wadir1'] }}
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('admin.users.index', ['role' => 'kaprodi']) }}" 
                       class="group relative min-w-max px-5 py-3 text-sm font-medium rounded-lg transition-all duration-200
                              {{ $role == 'kaprodi' ? 'bg-white text-blue-700 shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-white/50' }}">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-user-tie {{ $role == 'kaprodi' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                            <span>Kaprodi</span>
                            <span class="inline-flex items-center justify-center min-w-[24px] h-6 px-2 text-xs font-semibold rounded-full
                                         {{ $role == 'kaprodi' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-600 group-hover:bg-gray-300' }}">
                                {{ $roleCounts['kaprodi'] }}
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('admin.users.index', ['role' => 'tim']) }}" 
                       class="group relative min-w-max px-5 py-3 text-sm font-medium rounded-lg transition-all duration-200
                              {{ $role == 'tim' ? 'bg-white text-blue-700 shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-white/50' }}">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-user-friends {{ $role == 'tim' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                            <span>Admin Prodi</span>
                            <span class="inline-flex items-center justify-center min-w-[24px] h-6 px-2 text-xs font-semibold rounded-full
                                         {{ $role == 'tim' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-600 group-hover:bg-gray-300' }}">
                                {{ $roleCounts['tim'] }}
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('admin.users.index', ['role' => 'dosen']) }}" 
                       class="group relative min-w-max px-5 py-3 text-sm font-medium rounded-lg transition-all duration-200
                              {{ $role == 'dosen' ? 'bg-white text-blue-700 shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-white/50' }}">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-chalkboard-teacher {{ $role == 'dosen' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                            <span>Dosen</span>
                            <span class="inline-flex items-center justify-center min-w-[24px] h-6 px-2 text-xs font-semibold rounded-full
                                         {{ $role == 'dosen' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-600 group-hover:bg-gray-300' }}">
                                {{ $roleCounts['dosen'] }}
                            </span>
                        </div>
                    </a>
                </nav>
            </div>

            <!-- Toolbar -->
            <div class="px-6 py-5 border-b border-gray-200 bg-white">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    
                    <!-- Actions -->
                    <div class="flex flex-wrap items-center gap-3">
                        @if($role === 'dosen')
                            <button onclick="toggleImportModal()" 
                                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 
                                           text-white font-medium rounded-lg shadow-sm hover:shadow-md 
                                           transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                Import Excel
                            </button>

                            <a href="{{ route('admin.users.downloadTemplate') }}"
                               class="inline-flex items-center px-5 py-2.5 bg-amber-500 hover:bg-amber-600 
                                      text-white font-medium rounded-lg shadow-sm hover:shadow-md 
                                      transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download Template
                            </a>
                        @endif
                    </div>

                    <!-- Search -->
                    <div class="relative w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               id="search" 
                               placeholder="Cari nama, NIP, email..." 
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg 
                                      focus:ring-2 focus:ring-blue-500 focus:border-transparent 
                                      placeholder-gray-400 text-sm transition-all duration-200">
                    </div>
                </div>
            </div>

            <!-- Table -->
            @if ($users->isEmpty())
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">
                        {{ $role === 'all' ? 'Belum Ada Data Pengguna' : 'Tidak Ada Pengguna dengan Role ' . ucfirst($role) }}
                    </h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        {{ $role === 'dosen' 
                           ? 'Mulai dengan menambahkan dosen secara manual atau import dari file Excel.' 
                           : 'Klik tombol "Tambah Pengguna" untuk menambahkan pengguna baru ke sistem.' }}
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('admin.users.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 
                                  text-white font-medium rounded-lg shadow-sm hover:shadow-md 
                                  transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Pengguna Pertama
                        </a>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                            <tr>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider w-16">No</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">NIP</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Nama</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">No HP</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider w-40">Prodi</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider w-28">Role</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider w-24">Status</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $index => $user)
                            <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 font-mono">
                                    {{ $user->nip }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 
                                                        flex items-center justify-center text-white font-semibold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $user->nohp ?? '-' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $user->email }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $user->prodi->nama_prodi ?? '-' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                 {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                                    ($user->role === 'dosen' ? 'bg-blue-100 text-blue-800' : 
                                                    ($user->role === 'tim' ? 'bg-green-100 text-green-800' : 
                                                    'bg-gray-100 text-gray-800')) }}">
                                        {{ $user->role === 'tim' ? 'Admin Prodi' : ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                 {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full {{ $user->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.users.detail', $user->id) }}" 
                                           class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all duration-200"
                                           title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                           title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Yakin ingin menghapus pengguna ini?')"
                                                    class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-all duration-200"
                                                    title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="toggleImportModal()"></div>
        
        <div class="inline-block align-middle bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Import Data Dosen
                    </h3>
                    <button onclick="toggleImportModal()" class="text-white hover:text-gray-200 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data" class="px-6 py-6">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih File Excel</label>
                    <input type="file" 
                           name="file" 
                           accept=".xlsx,.xls,.csv" 
                           required
                           class="block w-full text-sm text-gray-700 
                                  file:mr-4 file:py-2.5 file:px-4 
                                  file:rounded-lg file:border-0 
                                  file:text-sm file:font-semibold 
                                  file:bg-blue-50 file:text-blue-700 
                                  hover:file:bg-blue-100 
                                  border border-gray-300 rounded-lg 
                                  cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="mt-2 text-xs text-gray-500">Format: .xlsx, .xls, .csv (Max: 2MB)</p>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-5 rounded-r-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-blue-700">
                            <p class="font-semibold mb-1">Format Excel yang benar:</p>
                            <p class="text-xs">Kolom: nama, nip, nohp, email, password, kode_prodi</p>
                            <a href="{{ route('admin.users.downloadTemplate') }}" 
                               class="inline-flex items-center mt-2 text-blue-700 hover:text-blue-900 font-medium underline">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download Template
                            </a>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="toggleImportModal()"
                            class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all duration-200">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 
                                   text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                        Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleImportModal() {
    const modal = document.getElementById('importModal');
    modal.classList.toggle('hidden');
}

document.getElementById('search').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

setTimeout(function() {
    ['alert-success', 'alert-error', 'alert-warning', 'alert-sukses'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('animate-fade-out');
            setTimeout(() => el.remove(), 300);
        }
    });
}, 5000);
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fade-out {
    from { opacity: 1; }
    to { opacity: 0; }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

.animate-fade-out {
    animation: fade-out 0.3s ease-out;
}
</style>
@endpush
@endsection
