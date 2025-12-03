@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header ala Wadir1 -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check-square text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Capaian Profil Lulusan (CPL)</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Kelola dan pantau daftar CPL per program studi dan tahun kurikulum.
                    </p>
                </div>
            </div>
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

        <!-- Kartu Filter -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
            <div class="bg-blue-600 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter CPL
                </h2>
                @if($kode_prodi)
                <div class="flex gap-2">
                    <a href="{{ route('admin.capaianprofillulusan.import') }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-file-excel mr-2 text-xs"></i>
                        Import Excel
                    </a>
                    <a href="{{ route('admin.capaianprofillulusan.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-white text-blue-700 hover:text-blue-800 hover:bg-blue-50 text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-plus mr-2 text-xs"></i>
                        Tambah CPL
                    </a>
                </div>
                @endif
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('admin.capaianprofillulusan.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Program Studi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-university text-blue-500 mr-1"></i>
                                Program Studi
                            </label>
                            <select name="kode_prodi"
                                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">Semua Prodi</option>
                                @foreach(($prodis ?? []) as $prodi)
                                    <option value="{{ $prodi->kode_prodi }}" {{ ($kode_prodi ?? '') == $prodi->kode_prodi ? 'selected' : '' }}>
                                        {{ $prodi->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tahun Kurikulum -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar text-green-500 mr-1"></i>
                                Tahun Kurikulum
                            </label>
                            <select name="id_tahun"
                                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">Semua</option>
                                @foreach(($tahun_tersedia ?? []) as $th)
                                    <option value="{{ $th->id_tahun }}" {{ ($id_tahun ?? '') == $th->id_tahun ? 'selected' : '' }}>
                                        {{ $th->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Actions -->
                        <div class="self-end flex gap-2">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Tampilkan Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @php
            $selectedYear = collect($tahun_tersedia ?? [])->firstWhere('id_tahun', $id_tahun);
            $selectedProdi = collect($prodis ?? [])->firstWhere('kode_prodi', $kode_prodi);
            $isFiltered = !empty($kode_prodi) || !empty($id_tahun);
        @endphp

        @if($isFiltered)
            <!-- Filter aktif dan statistik (diselaraskan dengan Wadir1) -->
            <div class="mb-6 space-y-4">
                <!-- Filter aktif -->
                <div class="bg-white rounded-xl shadow border border-gray-200 p-4">
                    <div class="text-sm text-gray-600 mb-2">Filter aktif:</div>
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Angkatan: {{ $selectedYear->tahun ?? 'Semua' }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">
                            <i class="fas fa-university mr-2"></i>
                            {{ $selectedProdi->nama_prodi ?? 'Semua Program Studi' }}
                        </span>
                        <a href="{{ route('admin.capaianprofillulusan.index') }}" 
                           class="text-red-600 text-sm ml-2">
                            <i class="fas fa-times mr-1"></i>Reset
                        </a>
                    </div>
                </div>

                <!-- Statistik singkat -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-500">
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase">Total CPL</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">
                                    {{ ($capaianprofillulusans ?? collect())->count() }}
                                </p>
                            </div>
                            <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center text-white">
                                <i class="fas fa-check-square text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-green-500">
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase">Angkatan</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">
                                    {{ $selectedYear->tahun ?? '-' }}
                                </p>
                            </div>
                            <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center text-white">
                                <i class="fas fa-calendar text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-purple-500">
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase">Program Studi</p>
                                <p class="mt-2 text-xl font-bold text-gray-900">
                                    {{ $selectedProdi->nama_prodi ?? '-' }}
                                </p>
                            </div>
                            <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center text-white">
                                <i class="fas fa-graduation-cap text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(!$isFiltered)
            <!-- Empty state sebelum filter -->
            <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="w-20 h-20 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                        <i class="fas fa-filter text-3xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
                <p class="text-gray-600 mt-1">Silakan pilih program studi dan tahun untuk menampilkan data CPL.</p>
            </div>
        @elseif(isset($dataKosong) && $dataKosong)
            <!-- Empty state jika data kosong -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded mb-8 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-800">
                            Data CPL belum tersedia untuk kombinasi filter yang dipilih.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($isFiltered && ($capaianprofillulusans ?? collect())->isNotEmpty())
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Daftar CPL</h2>
                        <p class="text-xs text-gray-500 mt-1">
                            @if($selectedProdi)
                                Program Studi: <span class="font-semibold">{{ $selectedProdi->nama_prodi }}</span>
                            @endif
                            @if($selectedYear)
                                &middot; Tahun Kurikulum: <span class="font-semibold">{{ $selectedYear->tahun }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative">
                        <input id="searchCpl" type="text" 
                               class="pl-9 pr-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Cari CPL...">
                        <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table id="tableCpl" class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-16">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-32">Kode CPL</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Deskripsi</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-40">Program Studi</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-28">Tahun</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-40">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($capaianprofillulusans as $index => $cpl)
                                <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            {{ $cpl->kode_cpl }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ Str::limit($cpl->deskripsi_cpl, 100) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                        {{ $cpl->nama_prodi ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                        {{ $cpl->tahun ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @php
                                            $status = $cpl->status_cpl;
                                            $statusLabel = $status === 'Kompetensi Utama Bidang'
                                                ? 'Utama'
                                                : ($status === 'Kompetensi Tambahan' ? 'Tambahan' : '-');
                                            $statusClass = $status === 'Kompetensi Utama Bidang'
                                                ? 'bg-green-100 text-green-800'
                                                : ($status === 'Kompetensi Tambahan' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-600');
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.capaianprofillulusan.detail', $cpl->id_cpl) }}" 
                                               class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all duration-200"
                                               title="Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.capaianprofillulusan.edit', $cpl->id_cpl) }}" 
                                               class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                               title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.capaianprofillulusan.destroy', $cpl->id_cpl) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Yakin ingin menghapus CPL ini?')"
                                                        class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-all duration-200"
                                                        title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
// Auto-hide alerts
setTimeout(function() {
    ['alert-success', 'alert-sukses'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('animate-fade-out');
            setTimeout(function() { el.remove(); }, 300);
        }
    });
}, 5000);

// Search CPL
const searchInput = document.getElementById('searchCpl');
const table = document.getElementById('tableCpl');
if (searchInput && table) {
    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase();
        table.querySelectorAll('tbody tr').forEach(function(tr) {
            const text = tr.innerText.toLowerCase();
            tr.style.display = text.includes(q) ? '' : 'none';
        });
    });
}
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
