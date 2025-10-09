@extends('layouts.app')

@section('title', 'Tambah Mata Kuliah Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">

        <!-- Header form -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">Tambah Mata Kuliah Baru</h1>
                <p class="text-sm text-gray-300 mt-1">Isi formulir di bawah ini untuk menambahkan mata kuliah baru.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('admin.manage.matkul') }}" class="glass-button inline-flex items-center">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="glass-card rounded-lg p-4 mb-4 text-red-200 border border-red-400">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Terjadi kesalahan pada input. Mohon periksa kembali:
                <ul class="mb-0 mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('admin.create.matkul') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kode_matkul" class="block text-sm font-medium text-white mb-1">Kode Mata Kuliah <span class="text-red-400">*</span></label>
                    <input type="text" name="kode_matkul" id="kode_matkul" value="{{ old('kode_matkul') }}" required
                           placeholder="Contoh: IF101"
                           class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label for="nama_matkul" class="block text-sm font-medium text-white mb-1">Nama Mata Kuliah <span class="text-red-400">*</span></label>
                    <input type="text" name="nama_matkul" id="nama_matkul" value="{{ old('nama_matkul') }}" required
                           placeholder="Contoh: Pemrograman Web Lanjut"
                           class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label for="sks" class="block text-sm font-medium text-white mb-1">Jumlah SKS <span class="text-red-400">*</span></label>
                    <input type="number" name="sks" id="sks" value="{{ old('sks') }}" required min="1" max="6"
                           placeholder="Contoh: 3"
                           class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
            </div>

            <!-- Relasi tunggal: pilih CPL (yang sudah punya CPMK), tambah Uraian, SUB-CPMK, dan Bobot -->
            <div class="mt-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-white mb-1">Pilih CPL (yang sudah memiliki CPMK)</label>
                    <select name="cpl_id" class="glass-input w-full py-2 px-3 select-cpl" required>
                        <option value="">-- Pilih CPL --</option>
                        @foreach($cpls as $cpl)
                            <option value="{{ $cpl->id }}">{{ $cpl->kode_cpl }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white mb-1">Uraian CPMK</label>
                    <textarea name="uraian_cpmk" rows="3" class="glass-input w-full py-2 px-3" placeholder="Uraian CPMK" required>{{ old('uraian_cpmk') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white mb-1">SUB-CPMK (satu poin per baris)</label>
                    <textarea name="sub_cpmk" rows="3" class="glass-input w-full py-2 px-3" placeholder="Contoh:\n- Mahasiswa mampu ...\n- Mahasiswa mampu ...">{{ old('sub_cpmk') }}</textarea>
                </div>
                <div class="md:w-48">
                    <label class="block text-sm font-medium text-white mb-1">Bobot (opsional)</label>
                    <input type="number" name="bobot" class="glass-input w-full py-2 px-3" min="0" max="100" step="1" placeholder="0-100" value="{{ old('bobot') }}">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-white/20">
                <a href="{{ route('admin.manage.matkul') }}" class="glass-button">
                    <i class="fas fa-times me-2"></i> Batal
                </a>
                <button type="submit" class="glass-button inline-flex items-center">
                    <i class="fas fa-save me-2"></i> Simpan Mata Kuliah
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
