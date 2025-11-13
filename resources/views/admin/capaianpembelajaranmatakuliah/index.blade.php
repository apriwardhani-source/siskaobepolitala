@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Capaian Pembelajaran Mata Kuliah (CPMK)</h1>
            <p class="mt-2 text-sm text-gray-600">Kelola capaian pembelajaran untuk setiap mata kuliah</p>
        </div>

        <!-- Alerts -->
        @if (session('success'))
        <div id="alert-success" class="mb-6 rounded-lg bg-green-50 border-l-4 border-green-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-green-800">Berhasil!</h3>
                    <p class="mt-1 text-sm text-green-700">{{ session('success') }}</p>
                </div>
                <button onclick="this.closest('#alert-success').remove()" 
                        class="ml-4 text-green-500 hover:text-green-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if (session('sukses'))
        <div id="alert-sukses" class="mb-6 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-800">Perhatian!</h3>
                    <p class="mt-1 text-sm text-red-700">{{ session('sukses') }}</p>
                </div>
                <button onclick="this.closest('#alert-sukses').remove()" 
                        class="ml-4 text-red-500 hover:text-red-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            
            <!-- Toolbar -->
            <div class="px-6 py-5 border-b border-gray-200 bg-white">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between space-y-4 lg:space-y-0 gap-4">
                    
                    <!-- Filters -->
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Program Studi</label>
                            <select id="prodi" name="kode_prodi" onchange="updateFilter()"
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg 
                                       focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="" disabled {{ empty($kode_prodi) ? 'selected' : '' }}>Pilih Prodi</option>
                                @foreach ($prodis as $prodi)
                                    <option value="{{ $prodi->kode_prodi }}" {{ $kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                                        {{ $prodi->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kurikulum</label>
                            <select id="tahun" name="id_tahun" onchange="updateFilter()"
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg 
                                       focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="" {{ empty($id_tahun) ? 'selected' : '' }}>Semua Tahun</option>
                                @if (isset($tahun_tersedia))
                                    @foreach ($tahun_tersedia as $thn)
                                        <option value="{{ $thn->id_tahun }}" {{ $id_tahun == $thn->id_tahun ? 'selected' : '' }}>
                                            {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="lg:w-80">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cari CPMK</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search" placeholder="Cari CPMK..." 
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg 
                                          focus:ring-2 focus:ring-blue-500 focus:border-transparent 
                                          placeholder-gray-400 text-sm transition-all duration-200">
                        </div>
                    </div>
                </div>

                <!-- Filter Info -->
                @if ($kode_prodi || $id_tahun)
                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-sm text-blue-800 font-medium">Filter aktif:</span>
                        @if ($kode_prodi)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                Prodi: {{ $prodis->where('kode_prodi', $kode_prodi)->first()->nama_prodi ?? $kode_prodi }}
                            </span>
                        @endif
                        @if ($id_tahun)
                            @php
                                $selected_tahun = $tahun_tersedia->where('id_tahun', $id_tahun)->first();
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                Tahun: {{ $selected_tahun ? $selected_tahun->nama_kurikulum . ' - ' . $selected_tahun->tahun : $id_tahun }}
                            </span>
                        @endif
                        <a href="{{ route('admin.capaianpembelajaranmatakuliah.index') }}" 
                           class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-medium">
                            Reset filter
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Content -->
            @if (!$kode_prodi)
                <!-- Empty State - No Prodi Selected -->
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Pilih Program Studi</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Silakan pilih program studi di atas untuk menampilkan data Capaian Pembelajaran Mata Kuliah (CPMK).
                    </p>
                </div>
            @elseif(isset($dataKosong) && $dataKosong)
                <!-- Empty State - No Data -->
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Data CPMK</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Belum ada Capaian Pembelajaran Mata Kuliah untuk program studi ini.
                    </p>
                </div>
            @else
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                            <tr>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-16">No</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Kode MK</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Nama MK</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-28">Kode CPMK</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Deskripsi CPMK</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($cpmks as $index => $cpmk)
                            <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                        {{ $cpmk->kode_mk }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900">
                                    {{ $cpmk->nama_mk ?? '-' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $cpmk->kode_cpmk }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">
                                    {{ Str::limit($cpmk->deskripsi_cpmk, 100) }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.capaianpembelajaranmatakuliah.detail', $cpmk->id_cpmk) }}" 
                                           class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all duration-200"
                                           title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>

@push('scripts')
<script>
function updateFilter() {
    const prodiSelect = document.getElementById('prodi');
    const tahunSelect = document.getElementById('tahun');

    const kodeProdi = prodiSelect.value;
    const idTahun = tahunSelect.value;

    let url = "{{ route('admin.capaianpembelajaranmatakuliah.index') }}";
    let params = [];

    if (kodeProdi) {
        params.push('kode_prodi=' + encodeURIComponent(kodeProdi));
    }

    if (idTahun) {
        params.push('id_tahun=' + encodeURIComponent(idTahun));
    }

    if (params.length > 0) {
        url += '?' + params.join('&');
    }

    window.location.href = url;
}

// Search functionality
document.getElementById('search').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

// Auto-hide alerts
setTimeout(function() {
    ['alert-success', 'alert-sukses'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('animate-fade-out');
            setTimeout(() => el.remove(), 300);
        }
    });
}, 5000);
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fade-out {
    from { opacity: 1; }
    to { opacity: 0; }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

.animate-fade-out {
    animation: fade-out 0.3s ease-out;
}
</style>
@endpush
@endsection
