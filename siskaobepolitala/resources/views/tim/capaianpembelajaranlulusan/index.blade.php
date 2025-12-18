@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header: ikon + judul (mirip admin) -->
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
                        Kelola dan pantau daftar CPL untuk program studi Anda berdasarkan tahun kurikulum.
                    </p>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div id="alert-success"
                 class="mb-6 rounded-lg bg-green-50 border-l-4 border-green-500 p-4 shadow-sm animate-fade-in">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-green-800">Berhasil!</h3>
                        <p class="mt-1 text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.closest('#alert-success').remove()"
                            class="ml-4 text-green-500 hover:text-green-700 focus:outline-none">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if (session('sukses'))
            <div id="alert-sukses"
                 class="mb-6 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm animate-fade-in">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-red-800">Perhatian!</h3>
                        <p class="mt-1 text-sm text-red-700">{{ session('sukses') }}</p>
                    </div>
                    <button onclick="this.closest('#alert-sukses').remove()"
                            class="ml-4 text-red-500 hover:text-red-700 focus:outline-none">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Kartu Filter CPL (mirip admin, disesuaikan admin prodi) -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
            <div class="bg-blue-600 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter CPL
                </h2>
                <div class="flex gap-2">
                    <a href="{{ route('tim.capaianpembelajaranlulusan.import') }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-file-excel mr-2 text-xs"></i>
                        Import Excel
                    </a>

                    @if(!empty($id_tahun ?? null))
                        <a href="{{ route('tim.capaianpembelajaranlulusan.create', ['id_tahun' => $id_tahun ?? null]) }}"
                           class="inline-flex items-center px-4 py-2 bg-white text-blue-700 hover:text-blue-800 hover:bg-blue-50 text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-plus mr-2 text-xs"></i>
                            Tambah CPL
                        </a>
                    @endif
                </div>
            </div>

            <div class="p-6">
                <form method="GET" action="{{ route('tim.capaianpembelajaranlulusan.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Program Studi (readonly select ala Wadir1) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-university text-blue-500 mr-1"></i>
                                Program Studi
                            </label>
                            <select disabled
                                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-sm text-gray-800">
                                <option>{{ $prodiName ?? '-' }}</option>
                            </select>
                        </div>

                        <!-- Tahun Kurikulum -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar text-green-500 mr-1"></i>
                                Tahun Kurikulum
                            </label>
                            <select name="id_tahun"
                                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                    required>
                                <option value="" {{ empty($id_tahun ?? '') ? 'selected disabled' : 'disabled' }}>Pilih Tahun Kurikulum</option>
                                @foreach(($tahun_tersedia ?? []) as $th)
                                    <option value="{{ $th->id_tahun }}" {{ ($id_tahun ?? '') == $th->id_tahun ? 'selected' : '' }}>
                                        {{ $th->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Actions (Tampilkan Data ala Wadir1 Organisasi MK) -->
                        <div class="self-end flex flex-wrap gap-2">
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Tampilkan Data
                            </button>

                            @if(!empty($id_tahun ?? null))
                                <a href="{{ route('tim.capaianpembelajaranlulusan.index') }}"
                                   class="inline-flex items-center px-4 py-2 text-sm text-red-600 hover:text-red-800">
                                    <i class="fas fa-times mr-1"></i>Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @php
            $selectedYear = collect($tahun_tersedia ?? [])->firstWhere('id_tahun', $id_tahun ?? null);
            $isFiltered = !empty($id_tahun ?? null);
            $dataKosong = $isFiltered && ($capaianpembelajaranlulusans ?? collect())->isEmpty();
        @endphp

        @if(!$isFiltered)
            <!-- Empty state sebelum filter -->
            <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="w-20 h-20 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                        <i class="fas fa-filter text-3xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-800">Pilih Tahun Kurikulum</h3>
                <p class="text-gray-600 mt-1">
                    Silakan pilih tahun kurikulum di atas untuk menampilkan data CPL program studi Anda.
                </p>
            </div>
        @elseif($dataKosong)
            <!-- Empty state jika data kosong -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded mb-8 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-800">
                            Data CPL belum tersedia untuk tahun kurikulum yang dipilih.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <!-- Filter aktif + statistik singkat (mirip admin) -->
            <div class="mb-6 space-y-4">
                <div class="bg-white rounded-xl shadow border border-gray-200 p-4">
                    <div class="text-sm text-gray-600 mb-2">Filter aktif:</div>
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Angkatan: {{ $selectedYear->tahun ?? 'Semua' }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">
                            <i class="fas fa-university mr-2"></i>
                            {{ $prodiName ?? '-' }}
                        </span>
                        <a href="{{ route('tim.capaianpembelajaranlulusan.index') }}"
                           class="text-red-600 text-sm ml-2">
                            <i class="fas fa-times mr-1"></i>Reset
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-500">
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase">Total CPL</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">
                                    {{ ($capaianpembelajaranlulusans ?? collect())->count() }}
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
                                    {{ $prodiName ?? '-' }}
                                </p>
                            </div>
                            <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center text-white">
                                <i class="fas fa-graduation-cap text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar CPL Program Studi -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Daftar CPL Program Studi</h2>
                        <p class="text-xs text-gray-500 mt-1">
                            Program Studi: <span class="font-semibold">{{ $prodiName ?? '-' }}</span>
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
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                            <tr>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-16">
                                    No
                                </th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">
                                    Kode CPL
                                </th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">
                                    Deskripsi CPL
                                </th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-40">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @foreach ($capaianpembelajaranlulusans as $index => $cpl)
                                <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700 font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            {{ $cpl->kode_cpl }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        {{ $cpl->deskripsi_cpl }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('tim.capaianpembelajaranlulusan.detail', $cpl->id_cpl) }}"
                                               class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all duration-200"
                                               title="Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('tim.capaianpembelajaranlulusan.edit', $cpl->id_cpl) }}"
                                               class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                               title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('tim.capaianpembelajaranlulusan.destroy', $cpl->id_cpl) }}"
                                                  method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Yakin ingin menghapus CPL ini?')"
                                                        class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-all duration-200"
                                                        title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
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
// Search functionality untuk input cari CPL di kartu daftar
const searchInput = document.getElementById('searchCpl');
if (searchInput) {
    searchInput.addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });
}

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
