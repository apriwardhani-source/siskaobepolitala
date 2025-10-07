<!-- resources/views/admin/cpl/create.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah CPL Baru')

@section('content')
    <div class="max-w-4xl mx-auto"> <!-- Batasi lebar maksimum untuk tampilan lebih baik -->
        <!-- Gunakan glass-card untuk wrapper utama konten -->
        <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
                <div>
                    <h1 class="text-2xl font-bold text-white">Tambah CPL Baru</h1>
                    <p class="text-sm text-gray-300 mt-1">Isi formulir di bawah ini untuk menambahkan CPL baru.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('cpl.index') }}"
                        class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="glass-card rounded-lg p-4 mb-4 text-red-200 border border-red-400">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Terjadi kesalahan input:
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('cpl.store') }}" class="space-y-6">
                @csrf

                <!-- Grid untuk field-field utama -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode CPL -->
                    <div>
                        <label for="kode_cpl" class="block text-sm font-medium text-white mb-1">
                            Kode CPL <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="kode_cpl" id="kode_cpl" value="{{ old('kode_cpl') }}" required autofocus
                            maxlength="50" placeholder="Contoh: CPL1, CPL_TI_01"
                            class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('kode_cpl') !border-red-500 @enderror">
                        @error('kode_cpl')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- (kolom kanan dibiarkan kosong agar grid tetap rapi di md+) -->
                    <div class="hidden md:block"></div>

                    <!-- Threshold -->
                    <div>
                        <label for="threshold" class="block text-sm font-medium text-white mb-1">Threshold (%) <span class="text-red-400">*</span></label>
                        <input type="number" name="threshold" id="threshold" value="{{ old('threshold', 70.00) }}" required min="0" max="100" step="0.01"
                               placeholder="Contoh: 70.00"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('threshold') !border-red-500 @enderror">
                        @error('threshold')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block text-sm font-medium text-white mb-1">
                            Deskripsi CPL <span class="text-red-400">*</span>
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="6" required
                            placeholder="Deskripsikan CPL secara lengkap..."
                            class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('deskripsi') !border-red-500 @enderror"
                            style="
                                    white-space: pre-wrap;
                                    overflow-wrap: break-word;
                                    word-break: break-word;
                                    resize: vertical;
                                    line-height: 1.5;
                                ">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 border-t border-white/20">
                    <a href="{{ route('cpl.index') }}"
                        class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                    <button type="submit" class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center">
                        <i class="fas fa-save me-2"></i> Simpan CPL
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection