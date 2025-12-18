@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header (ikon + judul seperti Kaprodi, dengan aksi TIM di kanan) -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-book-open text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Daftar Mata Kuliah</h1>
                    <p class="mt-2 text-sm text-gray-600">Kelola mata kuliah dan kurikulum program studi</p>
                </div>
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

        @if (session('sukses') || session('error'))
        <div id="alert-error" class="mb-6 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-800">Perhatian!</h3>
                    <p class="mt-1 text-sm text-red-700">{{ session('sukses') ?? session('error') }}</p>
                </div>
                <button onclick="this.closest('#alert-error').remove()" 
                        class="ml-4 text-red-500 hover:text-red-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        <!-- Filter Card: gaya Wadir1 Organisasi MK -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
            <div class="bg-blue-600 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter Mata Kuliah
                </h2>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('tim.matakuliah.download-template') }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 
                              text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg 
                              transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Template
                    </a>
                    <button type="button"
                            onclick="document.getElementById('importModal').classList.remove('hidden')"
                            class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 
                                   text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg 
                                   transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Import
                    </button>
                    <a href="{{ route('tim.matakuliah.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-white text-blue-700 hover:text-blue-800 hover:bg-blue-50 text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah MK
                    </a>
                </div>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('tim.matakuliah.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Program Studi</label>
                            <select disabled class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                                <option>{{ $prodiName ?? '-' }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kurikulum</label>
                            <select name="id_tahun" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" required>
                                <option value="" {{ empty($id_tahun ?? '') ? 'selected disabled' : 'disabled' }}>Pilih Tahun Kurikulum</option>
                                @foreach(($tahun_tersedia ?? []) as $t)
                                    <option value="{{ $t->id_tahun }}" {{ ($id_tahun ?? '') == $t->id_tahun ? 'selected' : '' }}>
                                        {{ $t->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="self-end flex gap-2">
                            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                <i class="fas fa-search mr-2"></i>Tampilkan Data
                            </button>
                            <a href="{{ route('tim.export.excel', ['id_tahun' => ($id_tahun ?? request('id_tahun'))]) }}" class="inline-flex items-center px-4 py-2.5 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                                <i class="fas fa-file-excel mr-2"></i> Export Excel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @php
            $isFiltered = !empty($id_tahun);
            $selected_tahun = ($tahun_tersedia ?? collect())->firstWhere('id_tahun', $id_tahun);
        @endphp

        <!-- Main Card - Langsung ditampilkan tanpa harus filter -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            
            <!-- Toolbar -->
            <div class="px-6 py-5 border-b border-gray-200 bg-white">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between space-y-4 lg:space-y-0 gap-4">
                    <!-- Search -->
                    <div class="lg:w-80">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Mata Kuliah</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search" placeholder="Cari mata kuliah..." 
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg 
                                          focus:ring-2 focus:ring-blue-500 focus:border-transparent 
                                          placeholder-gray-400 text-sm transition-all duration-200">
                        </div>
                    </div>
                </div>

                <!-- Filter Info + ringkasan -->
                @if ($isFiltered)
                    <div class="mt-4 space-y-4">
                        <div class="bg-white rounded-xl shadow border border-gray-200 p-4">
                            <div class="text-sm text-gray-600 mb-2">Filter aktif:</div>
                            <div class="flex flex-wrap gap-2 items-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    Angkatan: {{ $selected_tahun->tahun ?? 'Semua' }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">
                                    <i class="fas fa-university mr-2"></i>
                                    {{ $prodiName ?? '-' }}
                                </span>
                                <a href="{{ route('tim.matakuliah.index') }}" 
                                   class="text-red-600 text-sm ml-2">
                                    <i class="fas fa-times mr-1"></i>Reset
                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-500">
                                <div class="p-6 flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 uppercase">Total MK</p>
                                        <p class="mt-2 text-3xl font-bold text-gray-900">
                                            {{ ($mata_kuliahs ?? collect())->count() }}
                                        </p>
                                    </div>
                                    <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center text-white">
                                        <i class="fas fa-book-open text-2xl"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-green-500">
                                <div class="p-6 flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 uppercase">Angkatan</p>
                                        <p class="mt-2 text-3xl font-bold text-gray-900">
                                            {{ $selected_tahun->tahun ?? '-' }}
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
                @endif
            </div>

            <!-- Content -->
            @if(isset($dataKosong) && $dataKosong)
                <!-- Empty State -->
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Mata Kuliah</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Belum ada mata kuliah untuk program studi ini. Klik tombol "Tambah MK" untuk menambahkan data baru.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('tim.matakuliah.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 
                                  text-white font-medium rounded-lg shadow-sm hover:shadow-md 
                                  transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Mata Kuliah Pertama
                        </a>
                    </div>
                </div>
            @else
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                            <tr>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-16">No</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-28">Kode MK</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Nama Mata Kuliah</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-20">SKS</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-24">Semester</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($mata_kuliahs as $index => $mk)
                            <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                        {{ $mk->kode_mk }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900">
                                    {{ $mk->nama_mk }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-semibold text-gray-900">
                                    {{ $mk->sks_mk }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                                    {{ $mk->semester_mk }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('tim.matakuliah.detail', $mk->kode_mk) }}" 
                                           class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all duration-200"
                                           title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('tim.matakuliah.edit', $mk->kode_mk) }}" 
                                           class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                           title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('tim.matakuliah.destroy', $mk->kode_mk) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Yakin ingin menghapus Mata Kuliah ini?')"
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
            @endif

        </div>
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-8 border w-full max-w-md shadow-2xl rounded-xl bg-white">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Import Mata Kuliah</h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <p class="text-sm text-gray-600">Upload file Excel untuk import mata kuliah secara massal</p>
        </div>

        <!-- Form -->
        <form action="{{ route('tim.matakuliah.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">File Excel</label>
                <input type="file" name="file" accept=".xlsx,.xls" required
                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer 
                              bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 p-2.5">
                <p class="mt-2 text-xs text-gray-500">Format: .xlsx atau .xls</p>
            </div>

            <div class="flex items-center justify-end space-x-3">
                <button type="button" 
                        onclick="document.getElementById('importModal').classList.add('hidden')"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 
                               rounded-lg transition-colors duration-200">
                    Batal
                </button>
                <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 
                               rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                    Import
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
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
    ['alert-success', 'alert-error'].forEach(id => {
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
