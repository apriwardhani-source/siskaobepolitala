@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Ranking Mahasiswa (SAW)</h1>
            <p class="mt-2 text-sm text-gray-600">Upload data nilai mahasiswa dan sistem akan menghitung ranking menggunakan metode Simple Additive Weighting (SAW)</p>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div id="alert-success" class="mb-6 rounded-lg bg-green-50 border-l-4 border-green-500 p-4 shadow-sm">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-green-800">Berhasil!</h3>
                    <p class="mt-1 text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div id="alert-error" class="mb-6 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-800">Error!</h3>
                    @foreach($errors->all() as $error)
                        <p class="mt-1 text-sm text-red-700">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Form Pilih Kriteria Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Pilih Kriteria untuk Ranking SAW
                </h2>
            </div>
            
            <form action="{{ route('admin.ranking.hitung') }}" method="POST" class="p-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul/Keterangan <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" required 
                               value="{{ old('judul') }}"
                               placeholder="Contoh: Ranking Semester Gasal 2024/2025"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Program Studi <span class="text-red-500">*</span></label>
                        <select name="kode_prodi" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">- Pilih Prodi -</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->kode_prodi }}" {{ old('kode_prodi') == $prodi->kode_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Akademik <span class="text-red-500">*</span></label>
                        <select name="id_tahun" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">- Pilih Tahun -</option>
                            @foreach($tahuns as $thn)
                                <option value="{{ $thn->id_tahun }}" {{ old('id_tahun') == $thn->id_tahun ? 'selected' : '' }}>
                                    {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Pilih Mata Kuliah sebagai Kriteria <span class="text-red-500">*</span>
                        <span class="text-xs text-gray-500 font-normal">(Minimal 2 mata kuliah)</span>
                    </label>
                    
                    <div class="border border-gray-300 rounded-lg p-4 max-h-96 overflow-y-auto bg-gray-50">
                        @if($mataKuliahs->isEmpty())
                            <p class="text-gray-500 text-sm">Tidak ada mata kuliah tersedia untuk prodi Anda</p>
                        @else
                            <div class="space-y-3">
                                @php
                                    $groupedMK = $mataKuliahs->groupBy('semester_mk');
                                @endphp
                                
                                @foreach($groupedMK as $semester => $mks)
                                    <div class="mb-4">
                                        <h4 class="font-semibold text-gray-700 mb-2 text-sm">Semester {{ $semester }}</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            @foreach($mks as $mk)
                                                <label class="mk-item flex items-start p-3 border border-gray-200 rounded-lg hover:bg-white hover:border-blue-300 cursor-pointer transition-all" data-prodi="{{ $mk->kode_prodi }}">
                                                    <input type="checkbox" name="mata_kuliah[]" value="{{ $mk->kode_mk }}" 
                                                           {{ in_array($mk->kode_mk, old('mata_kuliah', [])) ? 'checked' : '' }}
                                                           class="mt-1 mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <div class="flex-1">
                                                        <span class="font-medium text-sm text-gray-900">{{ $mk->nama_mk }}</span>
                                                        <span class="block text-xs text-gray-500">({{ $mk->kode_prodi }})</span>
                                                        <span class="block text-xs mt-1 
                                                            {{ $mk->kompetensi_mk == 'utama' ? 'text-purple-600 font-semibold' : 'text-blue-600' }}">
                                                            {{ ucfirst($mk->kompetensi_mk) }} (Bobot: {{ $mk->kompetensi_mk == 'utama' ? '2' : '1' }})
                                                        </span>
                                                        <span class="text-xs text-gray-500">{{ $mk->sks_mk }} SKS</span>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-blue-900">Informasi Penting:</p>
                            <ul class="mt-2 text-xs text-blue-700 list-disc list-inside space-y-1">
                                <li>Sistem akan mengambil <strong>nilai mahasiswa dari database</strong> yang sudah diinput oleh dosen</li>
                                <li>Bobot kriteria otomatis dari <strong>kompetensi MK</strong> (Utama = 2, Pendukung = 1)</li>
                                <li>Hanya mahasiswa dengan <strong>status aktif</strong> yang akan diproses</li>
                                <li>Sistem akan menghitung ranking menggunakan <strong>metode SAW</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Hitung Ranking SAW
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Session -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Riwayat Ranking</h2>
            </div>
            
            <div class="overflow-x-auto">
                @if($sessions->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Mahasiswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diupload Oleh</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sessions as $session)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $session->judul }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $session->tahun ? $session->tahun->nama_kurikulum . ' - ' . $session->tahun->tahun : '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $session->total_mahasiswa }} mahasiswa</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $session->uploader->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $session->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.ranking.hasil', $session->id_session) }}" 
                                           class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 text-xs font-medium">
                                            Lihat Hasil
                                        </a>
                                        <form action="{{ route('admin.ranking.destroy', $session->id_session) }}" method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus session ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 text-xs font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $sessions->links() }}
                    </div>
                @else
                    <div class="px-6 py-16 text-center">
                        <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Data</h3>
                        <p class="mt-2 text-sm text-gray-500">Upload file Excel untuk memulai perhitungan ranking</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const prodiSelect = document.querySelector('select[name="kode_prodi"]');
    const mkItems = document.querySelectorAll('.mk-item');
    const mkCheckboxes = document.querySelectorAll('input[name="mata_kuliah[]"]');
    
    function filterMataKuliah() {
        const selectedProdi = prodiSelect.value;
        
        if (!selectedProdi) {
            // Jika prodi belum dipilih, sembunyikan semua MK dan tampilkan peringatan
            mkItems.forEach(item => {
                item.style.display = 'none';
                item.querySelector('input').checked = false;
            });
            
            // Tampilkan pesan
            const container = document.querySelector('.mk-item').closest('.space-y-3');
            if (container && !document.getElementById('prodi-warning')) {
                container.innerHTML = '<div id="prodi-warning" class="text-center py-8"><p class="text-gray-500">Silakan pilih Program Studi terlebih dahulu</p></div>';
            }
        } else {
            // Restore container jika ada warning
            const warning = document.getElementById('prodi-warning');
            if (warning) {
                location.reload(); // Reload untuk restore original content
                return;
            }
            
            // Filter MK berdasarkan prodi
            let visibleCount = 0;
            mkItems.forEach(item => {
                const itemProdi = item.getAttribute('data-prodi');
                if (itemProdi === selectedProdi) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                    item.querySelector('input').checked = false; // Uncheck jika disembunyikan
                }
            });
            
            // Jika tidak ada MK untuk prodi ini
            if (visibleCount === 0) {
                const container = document.querySelector('.mk-item').closest('.space-y-3');
                if (container) {
                    container.innerHTML = '<div class="text-center py-8"><p class="text-red-500">Tidak ada mata kuliah untuk prodi yang dipilih</p></div>';
                }
            }
        }
    }
    
    // Filter saat prodi dipilih
    prodiSelect.addEventListener('change', filterMataKuliah);
    
    // Filter saat page load (untuk old input)
    if (prodiSelect.value) {
        filterMataKuliah();
    } else {
        // Hide semua MK di awal
        filterMataKuliah();
    }
});
</script>
@endpush
