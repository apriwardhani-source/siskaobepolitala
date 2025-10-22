@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Tambah Mahasiswa</h1>
            <p class="mt-2 text-sm text-gray-600">Tambahkan data mahasiswa baru</p>
        </div>

        <!-- Alerts -->
        @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-800">Terdapat kesalahan!</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-700 to-gray-800">
                <h2 class="text-lg font-semibold text-white">Informasi Mahasiswa</h2>
            </div>

            <form action="{{ route('tim.mahasiswa.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Pertama -->
                    <div class="space-y-5">
                        <div>
                            <label for="nim" class="block text-sm font-medium text-gray-700 mb-2">
                                NIM <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nim" name="nim" value="{{ old('nim') }}" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                placeholder="Masukkan NIM">
                        </div>

                        <div>
                            <label for="nama_mahasiswa" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Mahasiswa <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" required
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
                                    <option value="{{ $tahun->id_tahun }}" {{ old('id_tahun_kurikulum') == $tahun->id_tahun ? 'selected' : '' }}>
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
                            <input type="hidden" name="kode_prodi" value="{{ $prodis->first()->kode_prodi }}">
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status
                            </label>
                            <select id="status" name="status"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="lulus" {{ old('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                <option value="cuti" {{ old('status') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="keluar" {{ old('status') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('tim.mahasiswa.index') }}"
                        class="px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection