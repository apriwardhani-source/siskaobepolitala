@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Sub CPMK</h1>
            <p class="mt-2 text-sm text-gray-600">Kelola sub capaian pembelajaran mata kuliah</p>
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

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            
            <!-- Toolbar -->
            <div class="px-6 py-5 border-b border-gray-200 bg-white">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Sub CPMK</h2>
                    
                    <!-- Filters & Search -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <select id="prodi" name="kode_prodi" onchange="updateFilter()"
                                class="w-full sm:w-64 px-4 py-2.5 border border-gray-300 rounded-lg 
                                       focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="" {{ empty($kode_prodi) ? 'selected' : '' }} disabled>Pilih Prodi</option>
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi->kode_prodi }}" {{ $kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>

                        <select id="tahun" name="id_tahun" onchange="updateFilter()"
                                class="w-full sm:w-64 px-4 py-2.5 border border-gray-300 rounded-lg 
                                       focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="" {{ empty($id_tahun) ? 'selected' : '' }}>Semua Tahun</option>
                            @if ($tahun_tersedia->isNotEmpty())
                                @foreach ($tahun_tersedia as $thn)
                                    <option value="{{ $thn->id_tahun }}" {{ $id_tahun == $thn->id_tahun ? 'selected' : '' }}>
                                        {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                                    </option>
                                @endforeach
                            @endif
                        </select>

                        <div class="relative w-full sm:w-80">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search" placeholder="Cari sub CPMK..." 
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
                        <a href="{{ route('admin.subcpmk.index') }}" 
                           class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-medium">
                            Reset filter
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Content -->
            @if (empty($kode_prodi))
                <!-- Empty State - No Prodi Selected -->
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Pilih Program Studi</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Silakan pilih program studi terlebih dahulu untuk menampilkan data Sub CPMK.
                    </p>
                </div>
            @elseif ($subcpmks->isEmpty())
                <!-- Empty State - No Data -->
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Data Sub CPMK</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Tidak ada data Sub CPMK untuk program studi yang dipilih.
                    </p>
                </div>
            @else
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                            <tr>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-16">No</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Kode CPMK</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Deskripsi CPMK</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Sub CPMK</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Uraian Sub CPMK</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($subcpmks as $index => $subcpmk)
                            <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $subcpmk->kode_cpmk }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">
                                    {{ $subcpmk->deskripsi_cpmk ?? '-' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                        {{ $subcpmk->sub_cpmk }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">
                                    {{ $subcpmk->uraian_cpmk }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                    <a href="{{ route('admin.subcpmk.detail', $subcpmk->id_sub_cpmk) }}"
                                       class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all duration-200 inline-block"
                                       title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </a>
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
    const urlParams = new URLSearchParams(window.location.search);

    const kodeProdi = prodiSelect.value;
    const idTahun = tahunSelect.value;

    if (kodeProdi) {
        urlParams.set('kode_prodi', kodeProdi);
    }

    if (idTahun) {
        urlParams.set('id_tahun', idTahun);
    }

    const newUrl = `{{ route('admin.subcpmk.index') }}?${urlParams.toString()}`;
    window.location.href = newUrl;
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
    const el = document.getElementById('alert-success');
    if (el) {
        el.classList.add('animate-fade-out');
        setTimeout(() => el.remove(), 300);
    }
}, 5000);
</script>
@endpush
@endsection
