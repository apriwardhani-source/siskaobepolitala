@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-arrow-left mr-2 text-xs"></i>
                kembali
            </a>
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-graduate text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                        Edit Mahasiswa
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Perbarui data mahasiswa program studi Anda.
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-edit mr-2 text-sm"></i>
                    Formulir Edit Mahasiswa
                </h2>
            </div>

            <div class="px-6 py-6 space-y-6">
                @if ($errors->any())
                <div class="mb-5 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-red-800 mb-1">Terdapat kesalahan!</h3>
                            <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('tim.mahasiswa.update', $mahasiswa->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Pertama -->
                    <div class="space-y-5">
                        <div>
                            <label for="nim" class="block text-sm font-medium text-gray-700 mb-2">
                                NIM <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                placeholder="Masukkan NIM">
                        </div>

                        <div>
                            <label for="nama_mahasiswa" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Mahasiswa <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ old('nama_mahasiswa', $mahasiswa->nama_mahasiswa) }}" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <div>
                            <label for="id_tahun_kurikulum" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Kurikulum <span class="text-red-500">*</span>
                            </label>
                            <select id="id_tahun_kurikulum" name="id_tahun_kurikulum" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <option value="" selected disabled>Pilih Tahun Kurikulum</option>
                                @foreach ($tahun_angkatans as $tahun)
                                    <option value="{{ $tahun->id_tahun }}" {{ old('id_tahun_kurikulum', $mahasiswa->id_tahun_kurikulum) == $tahun->id_tahun ? 'selected' : '' }}>
                                        {{ $tahun->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Kolom Kedua -->
                    <div class="space-y-5">
                        <div>
                            <label for="kode_prodi" class="block text-sm font-medium text-gray-700 mb-2">
                                Program Studi
                            </label>
                            <input type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed"
                                value="{{ $prodis->first()->nama_prodi }}" readonly>
                            <input type="hidden" name="kode_prodi" value="{{ $mahasiswa->kode_prodi }}">
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status
                            </label>
                            <select id="status" name="status"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <option value="aktif" {{ old('status', $mahasiswa->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="lulus" {{ old('status', $mahasiswa->status) == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                <option value="cuti" {{ old('status', $mahasiswa->status) == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="keluar" {{ old('status', $mahasiswa->status) == 'keluar' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('tim.mahasiswa.index') }}"
                        class="inline-flex items-center px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-times mr-2 text-xs"></i>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                        <i class="fas fa-save mr-2 text-xs"></i>
                        Perbarui Data
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection
