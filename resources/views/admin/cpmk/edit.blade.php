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
                    <label for="cpl_id" class="block text-sm font-medium text-white mb-1">CPL Terkait</label>
                    <select name="cpl_id" id="cpl_id" class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400" required>
                        @foreach($cpls as $cpl)
                            <option value="{{ $cpl->id }}" {{ (old('cpl_id', $cpmk->cpl_id) == $cpl->id) ? 'selected' : '' }}>
                                {{ $cpl->kode_cpl }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-white mb-1">Deskripsi CPMK</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" required
                              class="w-full glass-input py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400">{{ old('deskripsi', $cpmk->deskripsi) }}</textarea>
                </div>

                <!-- SUB-CPMK Dinamis -->
                <div>
                    <label class="block text-sm font-medium text-white mb-1">SUB-CPMK</label>
                    <div id="subList" class="space-y-2">
                        @forelse($cpmk->subCpmks as $sub)
                            <div class="flex gap-2 sub-item">
                                <input type="text" name="sub_cpmk[]" class="glass-input flex-1 py-2 px-3" value="{{ $sub->uraian }}">
                                <button type="button" class="glass-button-danger px-3" onclick="this.parentElement.remove()">Hapus</button>
                            </div>
                        @empty
                            <div class="flex gap-2 sub-item">
                                <input type="text" name="sub_cpmk[]" class="glass-input flex-1 py-2 px-3" placeholder="Masukkan SUB-CPMK">
                                <button type="button" class="glass-button-danger px-3" onclick="this.parentElement.remove()">Hapus</button>
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-2">
                        <button type="button" class="glass-button-warning px-4" onclick="addSubCpmk()">+ Tambah SUB-CPMK</button>
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

<script>
function addSubCpmk() {
    const list = document.getElementById('subList');
    const row = document.createElement('div');
    row.className = 'flex gap-2 sub-item';
    row.innerHTML = `
        <input type="text" name="sub_cpmk[]" class="glass-input flex-1 py-2 px-3" placeholder="Masukkan SUB-CPMK">
        <button type="button" class="glass-button-danger px-3" onclick="this.parentElement.remove()">Hapus</button>
    `;
    list.appendChild(row);
}
</script>
