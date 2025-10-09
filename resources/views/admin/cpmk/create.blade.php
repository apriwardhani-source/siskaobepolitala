@extends('layouts.app')

@section('title', 'Tambah Beberapa CPMK untuk Satu CPL')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">Tambah Beberapa CPMK untuk Satu CPL</h1>
                <p class="text-sm text-gray-300 mt-1">Pilih satu CPL dan tambahkan beberapa CPMK sekaligus.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('cpmk.index') }}" class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

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

        <form method="POST" action="{{ route('cpmk.store') }}" class="space-y-6">
            @csrf
            <div>
                <label for="cpl_id" class="block text-sm font-medium text-white mb-1">
                    Pilih CPL <span class="text-red-400">*</span>
                </label>
                <select name="cpl_id" id="cpl_id" required
                        class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                    <option value="">Pilih CPL...</option>
                    @foreach ($cpls as $cpl)
                        <option value="{{ $cpl->id }}"{{ old('cpl_id') == $cpl->id ? ' selected' : '' }}>{{ $cpl->kode_cpl }} - {{ $cpl->deskripsi }}</option>
                    @endforeach
                </select>
            </div>

            <div id="cpmk-container">
                <!-- CPMK 1 -->
                <div class="cpmk-item bg-white/5 p-4 rounded-lg mb-4 border border-white/20">
                    <h3 class="font-medium text-white mb-3">CPMK #1</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="kode_cpmk_1" class="block text-sm font-medium text-white mb-1">Kode CPMK</label>
                            <input type="text" name="kode_cpmk[]" id="kode_cpmk_1" value="{{ old('kode_cpmk.0') }}" required placeholder="Contoh: CPMK001"
                                   class="w-full glass-input py-2 px-4 rounded-lg">
                        </div>
                        <div>
                            <label for="deskripsi_1" class="block text-sm font-medium text-white mb-1">Deskripsi CPMK</label>
                            <textarea name="deskripsi[]" id="deskripsi_1" rows="3" required placeholder="Deskripsikan CPMK..."
                                      class="w-full glass-input py-2 px-4 rounded-lg">{{ old('deskripsi.0') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between gap-3">
                <button type="button" id="add-cpmk" class="glass-button text-white font-medium py-2 px-4 rounded-lg">
                    <i class="fas fa-plus me-2"></i> Tambah CPMK Lagi
                </button>
                <button type="submit" class="glass-button text-white font-medium py-2 px-6 rounded-lg">
                    <i class="fas fa-save me-2"></i> Simpan Semua CPMK
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('cpmk-container');
    const addButton = document.getElementById('add-cpmk');
    let cpmkCount = 1;

    addButton.addEventListener('click', function() {
        cpmkCount++;
        const newCpmk = document.createElement('div');
        newCpmk.className = 'cpmk-item bg-white/5 p-4 rounded-lg mb-4 border border-white/20 relative';
        newCpmk.innerHTML = `
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-medium text-white">CPMK #${cpmkCount}</h3>
                <button type="button" class="remove-cpmk text-red-400 hover:text-red-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="kode_cpmk_${cpmkCount}" class="block text-sm font-medium text-white mb-1">Kode CPMK</label>
                    <input type="text" name="kode_cpmk[]" id="kode_cpmk_${cpmkCount}" required placeholder="Contoh: CPMK001"
                           class="w-full glass-input py-2 px-4 rounded-lg">
                </div>
                <div>
                    <label for="deskripsi_${cpmkCount}" class="block text-sm font-medium text-white mb-1">Deskripsi CPMK</label>
                    <textarea name="deskripsi[]" id="deskripsi_${cpmkCount}" rows="3" required placeholder="Deskripsikan CPMK..."
                              class="w-full glass-input py-2 px-4 rounded-lg"></textarea>
                </div>
            </div>
        `;
        
        container.appendChild(newCpmk);
        
        // Tambahkan event listener untuk tombol hapus
        newCpmk.querySelector('.remove-cpmk').addEventListener('click', function() {
            if (container.children.length > 1) {
                newCpmk.remove();
            } else {
                alert('Minimal harus ada satu CPMK.');
            }
        });
    });
    
    // Tambahkan event listener untuk tombol hapus pada CPMK pertama jika perlu
    document.querySelector('.remove-cpmk')?.addEventListener('click', function() {
        if (container.children.length > 1) {
            this.closest('.cpmk-item').remove();
        } else {
            alert('Minimal harus ada satu CPMK.');
        }
    });
});
</script>
@endsection
