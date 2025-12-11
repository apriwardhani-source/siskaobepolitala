@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <span class="mr-2 text-base leading-none">&larr;</span>
                Kembali
            </a>
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-user text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Detail Pengguna</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Informasi lengkap mengenai akun pengguna terpilih.
                    </p>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-id-card-alt mr-2 text-sm"></i>
                    Informasi Pengguna
                </h2>
            </div>

            <div class="px-6 py-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Pertama -->
                    <div class="space-y-4">
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-800">Nama</label>
                            <input type="text" value="{{ $user->name }}" readonly
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 text-sm text-gray-800">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-800">NIP</label>
                            <input type="text" value="{{ $user->nip }}" readonly
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 text-sm text-gray-800">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-800">No. HP</label>
                            <input type="text" value="{{ $user->nohp }}" readonly
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 text-sm text-gray-800">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-800">Email</label>
                            <input type="text" value="{{ $user->email }}" readonly
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 text-sm text-gray-800">
                        </div>
                    </div>

                    <!-- Kolom Kedua -->
                    <div class="space-y-4">
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-800">Role</label>
                            <input type="text" value="{{ $user->role }}" readonly
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 text-sm text-gray-800">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-800">Program Studi</label>
                            <input type="text" value="{{ $user->prodi->nama_prodi ?? '-' }}" readonly
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 text-sm text-gray-800">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-800">Status User</label>
                            <input type="text" value="{{ $user->status }}" readonly
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 text-sm text-gray-800">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

