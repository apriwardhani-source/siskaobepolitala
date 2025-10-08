@extends('layouts.app')

@section('title', 'Edit CPMK')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg max-w-2xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">Edit CPMK</h1>
                <p class="text-sm text-gray-300 mt-1">Perbarui informasi CPMK di bawah ini.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('cpmk.index') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('cpmk.update', $cpmk->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="kode_cpmk" class="block text-sm font-medium text-white mb-1">Kode CPMK</label>
                    <input type="text" name="kode_cpmk" id="kode_cpmk" value="{{ old('kode_cpmk', $cpmk->kode_cpmk) }}" required
                           class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-white mb-1">Deskripsi CPMK</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" required
                              class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400">{{ old('deskripsi', $cpmk->deskripsi) }}</textarea>
                </div>

                <!-- Pilihan Mata Kuliah -->
                <div>
                    <label class="block text-sm font-medium text-white mb-2">Pilih Mata Kuliah Terkait <span class="text-red-400">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($matkuls as $matkul)
                            <label class="flex items-center space-x-2 bg-white/10 p-2 rounded-lg">
                                <input type="checkbox" name="mata_kuliahs[]" value="{{ $matkul->id }}"
                                       {{ in_array($matkul->id, $selected) ? 'checked' : '' }}
                                       class="rounded text-blue-500 focus:ring-blue-400">
                                <span class="text-white text-sm">{{ $matkul->kode_matkul }} - {{ $matkul->nama_matkul }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-white/20">
                <a href="{{ route('cpmk.index') }}" class="glass-button text-white font-medium py-2 px-6 rounded-lg">
                    <i class="fas fa-times me-2"></i> Batal
                </a>
                <button type="submit" class="glass-button text-white font-medium py-2 px-6 rounded-lg">
                    <i class="fas fa-save me-2"></i> Update CPMK
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
