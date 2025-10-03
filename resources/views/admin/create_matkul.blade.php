@extends('layouts.app')

@section('title', 'Tambah Mata Kuliah Baru')

@section('content')
    <div class="max-w-4xl mx-auto"> <!-- Batasi lebar maksimum -->
        <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto"> <!-- Wrapper utama -->
            
            <!-- Header form -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
                <div>
                    <h1 class="text-2xl font-bold text-white">Tambah Mata Kuliah Baru</h1>
                    <p class="text-sm text-gray-300 mt-1">Isi formulir di bawah ini untuk menambahkan mata kuliah baru.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.manage.matkul') }}" 
                       class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Form input -->
            <form method="POST" action="{{ route('admin.create.matkul') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode Mata Kuliah -->
                    <div>
                        <label for="kode_matkul" class="block text-sm font-medium text-white mb-1">Kode Mata Kuliah <span class="text-red-400">*</span></label>
                        <input type="text" name="kode_matkul" id="kode_matkul" value="{{ old('kode_matkul') }}" required
                               placeholder="Contoh: IF101"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('kode_matkul') !border-red-500 @enderror">
                        @error('kode_matkul')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Mata Kuliah -->
                    <div>
                        <label for="nama_matkul" class="block text-sm font-medium text-white mb-1">Nama Mata Kuliah <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_matkul" id="nama_matkul" value="{{ old('nama_matkul') }}" required
                               placeholder="Contoh: Pemrograman Web Lanjut"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('nama_matkul') !border-red-500 @enderror">
                        @error('nama_matkul')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah SKS -->
                    <div>
                        <label for="sks" class="block text-sm font-medium text-white mb-1">Jumlah SKS <span class="text-red-400">*</span></label>
                        <input type="number" name="sks" id="sks" value="{{ old('sks') }}" required min="1" max="6"
                               placeholder="Contoh: 3"
                               class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('sks') !border-red-500 @enderror">
                        @error('sks')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prodi -->
                    <div>
                        <label for="prodi_id" class="block text-sm font-medium text-white mb-1">Program Studi <span class="text-red-400">*</span></label>
                        <select name="prodi_id" id="prodi_id" required
                                class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent @error('prodi_id') !border-red-500 @enderror">
                            <option value="" disabled selected>Pilih Prodi</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}" {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 border-t border-white/20">
                    <a href="{{ route('admin.manage.matkul') }}" 
                       class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                    <button type="submit" 
                            class="glass-button text-white font-medium py-2 px-6 rounded-lg text-center inline-flex items-center justify-center">
                        <i class="fas fa-save me-2"></i> Simpan Mata Kuliah
                    </button>
                </div>
            </form>
        </div> <!-- ✅ tutup glass-card -->
    </div> <!-- ✅ tutup max-w-4xl -->
@endsection
