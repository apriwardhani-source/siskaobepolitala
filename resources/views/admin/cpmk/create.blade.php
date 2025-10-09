@extends('layouts.app')

@section('title', 'Tambah CPMK')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">Tambah CPMK Baru</h1>
                <p class="text-sm text-gray-300 mt-1">
                    Isi formulir di bawah ini untuk menambahkan CPMK baru beserta Mata Kuliah yang terkait.
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('cpmk.index') }}"
                   class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Notifikasi Error -->
        @if ($errors->any())
            <div class="glass-card rounded-lg p-4 mb-4 text-red-200 border border-red-400">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Terjadi kesalahan input:
                <ul class="mb-0 mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('cpmk.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-6">

                <!-- Kode CPMK -->
                <div>
                    <label for="kode_cpmk" class="block text-sm font-medium text-white mb-1">
                        Kode CPMK <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="kode_cpmk" id="kode_cpmk"
                           value="{{ old('kode_cpmk') }}" required
                           placeholder="Contoh: CPMK011"
                           class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-white mb-1">
                        Deskripsi CPMK <span class="text-red-400">*</span>
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" required
                              placeholder="Deskripsikan CPMK secara lengkap..."
                              class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent">{{ old('deskripsi') }}</textarea>
                </div>

                <!-- Pilihan Mata Kuliah -->
                <div>
                    <label class="block text-sm font-medium text-white mb-2">
                        Pilih Mata Kuliah Terkait <span class="text-red-400">*</span>
                    </label>

                    @if ($matkuls->isEmpty())
                        <p class="text-gray-300 text-sm italic">Belum ada data mata kuliah.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach($matkuls as $matkul)
                                <label class="flex items-start space-x-2 bg-white/10 p-2 rounded-lg">
                                    <input type="checkbox" name="mata_kuliahs[]" value="{{ $matkul->id }}"
                                           class="mt-1 rounded text-blue-500 focus:ring-blue-400">
                                    <span class="text-white text-sm leading-tight">
                                        <strong>{{ $matkul->kode_matkul }}</strong> - {{ $matkul->nama_matkul }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-3 pt-4 border-t border-white/20">
                <a href="{{ route('cpmk.index') }}"
                   class="glass-button text-white font-medium py-2 px-6 rounded-lg">
                    <i class="fas fa-times me-2"></i> Batal
                </a>
                <button type="submit"
                        class="glass-button text-white font-medium py-2 px-6 rounded-lg">
                    <i class="fas fa-save me-2"></i> Simpan CPMK
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
