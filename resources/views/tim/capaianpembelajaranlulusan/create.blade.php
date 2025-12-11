@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('tim.capaianpembelajaranlulusan.index', ['id_tahun' => request('id_tahun')]) }}" 
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <span class="mr-2 text-base leading-none">&larr;</span>
                Kembali
            </a>
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-check-square text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Tambah Capaian Profil Lulusan (CPL)</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Tambahkan CPL baru untuk program studi Anda pada tahun kurikulum yang dipilih.
                    </p>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-plus-circle mr-2 text-sm"></i>
                    Formulir Tambah CPL
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

                <form action="{{ route('tim.capaianpembelajaranlulusan.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Program Studi (readonly untuk admin prodi) -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-800">
                                Program Studi
                            </label>
                            <input type="text"
                                   value="{{ Auth::user()->prodi->nama_prodi ?? '-' }}"
                                   readonly
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 bg-gray-50">
                        </div>

                        <!-- Tahun Kurikulum (readonly jika datang dari filter) -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-800">
                                Tahun Kurikulum
                            </label>
                            @if(isset($selectedYear))
                                <input type="text"
                                       value="{{ $selectedYear->tahun }}"
                                       readonly
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 bg-gray-50">
                                <input type="hidden" name="id_tahun" value="{{ $selectedYear->id_tahun }}">
                            @else
                                <select name="id_tahun"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                    <option value="" disabled {{ old('id_tahun') ? '' : 'selected' }}>Pilih Tahun Kurikulum</option>
                                    @foreach ($tahun_tersedia as $tahun)
                                        <option value="{{ $tahun->id_tahun }}" {{ old('id_tahun') == $tahun->id_tahun ? 'selected' : '' }}>
                                            {{ $tahun->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <!-- Kode CPL -->
                        <div class="space-y-2">
                            <label for="kode_cpl" class="block text-sm font-semibold text-gray-800">
                                Kode CPL
                            </label>
                            <input type="text" id="kode_cpl" name="kode_cpl"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Contoh: CPL01"
                                   value="{{ old('kode_cpl') }}"
                                   required>
                        </div>

                        <!-- Status CPL -->
                        <div class="space-y-2">
                            <label for="status_cpl" class="block text-sm font-semibold text-gray-800">
                                Status CPL
                            </label>
                            <select id="status_cpl" name="status_cpl"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="" disabled {{ old('status_cpl') ? '' : 'selected' }}>Pilih Status CPL (opsional)</option>
                                <option value="Kompetensi Utama Bidang" {{ old('status_cpl') === 'Kompetensi Utama Bidang' ? 'selected' : '' }}>
                                    Kompetensi Utama Bidang
                                </option>
                                <option value="Kompetensi Tambahan" {{ old('status_cpl') === 'Kompetensi Tambahan' ? 'selected' : '' }}>
                                    Kompetensi Tambahan
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Deskripsi CPL -->
                    <div class="space-y-2">
                        <label for="deskripsi_cpl" class="block text-sm font-semibold text-gray-800">
                            Deskripsi CPL
                        </label>
                        <textarea id="deskripsi_cpl" name="deskripsi_cpl" rows="4"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Tuliskan deskripsi capaian profil lulusan secara ringkas dan jelas..."
                                  required>{{ old('deskripsi_cpl') }}</textarea>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('tim.capaianpembelajaranlulusan.index') }}" 
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
