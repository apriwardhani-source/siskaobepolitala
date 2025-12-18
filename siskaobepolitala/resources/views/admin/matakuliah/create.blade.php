@extends('layouts.admin.app')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header -->
        <div class="mb-6">
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <span class="mr-2 text-base leading-none">&larr;</span>
                Kembali
            </a>
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-book text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Tambah Mata Kuliah</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Tambahkan mata kuliah baru beserta CPL yang terkait.
                    </p>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-plus-circle mr-2 text-sm"></i>
                    Formulir Tambah Mata Kuliah
                </h2>
            </div>

            <div class="px-6 py-6">
                @if ($errors->any())
                    <div class="mb-5 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-red-800 mb-1">Terjadi kesalahan</h3>
                                <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.matakuliah.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- CPL terkait -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">CPL Terkait</label>
                        <div class="border border-gray-200 p-4 rounded-lg max-h-64 overflow-y-auto bg-gray-50 space-y-2">
                            @forelse ($capaianProfilLulusans as $cpl)
                                <label class="flex items-start p-2 hover:bg-blue-50 rounded cursor-pointer text-sm text-gray-800">
                                    <input type="checkbox" name="id_cpls[]" value="{{ $cpl->id_cpl }}"
                                           class="mr-3 mt-1 h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span>
                                        <strong>{{ $cpl->kode_cpl }}</strong> - {{ $cpl->deskripsi_cpl }}
                                    </span>
                                </label>
                            @empty
                                <p class="text-gray-500 italic text-sm">Belum ada CPL tersedia.</p>
                            @endforelse
                        </div>
                        <p class="italic text-red-700 text-xs mt-2">*Pilih minimal 1 CPL</p>
                    </div>

                    <!-- Field Utama -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="space-y-1">
                                <label for="kode_mk" class="block text-sm font-semibold text-gray-800">Kode Mata Kuliah</label>
                                <input type="text" name="kode_mk" id="kode_mk"
                                       value="{{ old('kode_mk') }}"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div class="space-y-1">
                                <label for="nama_mk" class="block text-sm font-semibold text-gray-800">Nama Mata Kuliah</label>
                                <input type="text" name="nama_mk" id="nama_mk"
                                       value="{{ old('nama_mk') }}"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div class="space-y-1">
                                <label for="jenis_mk" class="block text-sm font-semibold text-gray-800">Jenis Mata Kuliah</label>
                                <input type="text" name="jenis_mk" id="jenis_mk"
                                       value="{{ old('jenis_mk') }}"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="space-y-1">
                                <label for="sks_mk" class="block text-sm font-semibold text-gray-800">SKS Mata Kuliah</label>
                                <input type="number" name="sks_mk" id="sks_mk"
                                       value="{{ old('sks_mk') }}"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div class="space-y-1">
                                <label for="semester_mk" class="block text-sm font-semibold text-gray-800">Semester Mata Kuliah</label>
                                <select name="semester_mk" id="semester_mk"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="" disabled {{ old('semester_mk') ? '' : 'selected' }}>Pilih Semester</option>
                                    @for ($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}" {{ old('semester_mk') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label for="kompetensi_mk" class="block text-sm font-semibold text-gray-800">Kompetensi Mata Kuliah</label>
                                <select name="kompetensi_mk" id="kompetensi_mk"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="" disabled {{ old('kompetensi_mk') ? '' : 'selected' }}>Pilih Kompetensi MK</option>
                                    <option value="pendukung" {{ old('kompetensi_mk') === 'pendukung' ? 'selected' : '' }}>Pendukung</option>
                                    <option value="utama" {{ old('kompetensi_mk') === 'utama' ? 'selected' : '' }}>Utama</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ url()->previous() }}"
                           class="inline-flex items-center px-5 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            <i class="fas fa-times mr-2 text-xs"></i>
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                            <i class="fas fa-save mr-2 text-xs"></i>
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection

