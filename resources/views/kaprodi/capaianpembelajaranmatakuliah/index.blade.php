@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Capaian Pembelajaran Mata Kuliah (CPMK)</h1>
                    <p class="mt-2 text-sm text-gray-600">Lihat capaian pembelajaran untuk setiap mata kuliah di program studi Anda</p>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            
            <!-- Toolbar -->
            <div class="px-6 py-5 border-b border-gray-200 bg-white">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between space-y-4 lg:space-y-0 gap-4">
                    
                    <!-- Filter -->
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kurikulum</label>
                        <select id="tahun" name="id_tahun" onchange="updateFilter()"
                            class="block w-full max-w-xs px-4 py-2.5 border border-gray-300 rounded-lg 
                                   focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="" {{ empty($id_tahun) ? 'selected' : '' }}>Semua Tahun</option>
                            @foreach ($tahun_tersedia as $thn)
                                <option value="{{ $thn->id_tahun }}" {{ $id_tahun == $thn->id_tahun ? 'selected' : '' }}>
                                    {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                                </option>
                            @endforeach
                        </select>
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
                @if ($id_tahun)
                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-sm text-blue-800 font-medium">Filter aktif:</span>
                        @php
                            $selected_tahun = $tahun_tersedia->where('id_tahun', $id_tahun)->first();
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                            Tahun: {{ $selected_tahun ? $selected_tahun->nama_kurikulum . ' - ' . $selected_tahun->tahun : $id_tahun }}
                        </span>
                        <a href="{{ route('kaprodi.capaianpembelajaranmatakuliah.index') }}" 
                           class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-medium">
                            Reset filter
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Content -->
            @if($capaianpembelajaranmatakuliahs->isEmpty())
                <!-- Empty State -->
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Data CPMK</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Belum ada Capaian Pembelajaran Mata Kuliah untuk program studi Anda.
                        Hubungi Tim Penyusun Kurikulum untuk menambahkan data CPMK.
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
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($capaianpembelajaranmatakuliahs as $index => $cpmk)
                            <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $cpmk->kode_cpmk }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">
                                    {{ Str::limit($cpmk->deskripsi_cpmk, 150) }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('kaprodi.capaianpembelajaranmatakuliah.detail', $cpmk->id_cpmk) }}" 
                                           class="inline-flex items-center px-3 py-1.5 text-sm bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-all duration-200"
                                           title="Detail">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Detail
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
    const tahunSelect = document.getElementById('tahun');
    const idTahun = tahunSelect.value;

    let url = "{{ route('kaprodi.capaianpembelajaranmatakuliah.index') }}";
    
    if (idTahun) {
        url += '?id_tahun=' + encodeURIComponent(idTahun);
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
</script>
@endpush
@endsection
