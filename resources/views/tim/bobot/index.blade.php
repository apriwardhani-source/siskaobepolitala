@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Bobot MK - CPL</h1>
                    <p class="mt-2 text-sm text-gray-600">Kelola bobot mata kuliah terhadap capaian profil lulusan</p>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success') || session('sukses'))
        <div id="alert-success" class="mb-6 rounded-lg bg-green-50 border-l-4 border-green-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-green-800">Berhasil!</h3>
                    <p class="mt-1 text-sm text-green-700">{{ session('success') ?? session('sukses') }}</p>
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

        <!-- Filter Card ala Wadir1 -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
            <div class="bg-blue-600 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter Bobot MK - CPL
                </h2>
                @if(!empty($id_tahun ?? null))
                <a href="{{ route('tim.bobot.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-white text-blue-700 hover:text-blue-800 hover:bg-blue-50 text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-plus mr-2 text-xs"></i>
                    Tambah Bobot
                </a>
                @endif
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('tim.bobot.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Program Studi</label>
                            <select disabled
                                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-sm">
                                <option>{{ $prodi->nama_prodi ?? '-' }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kurikulum</label>
                            <select name="id_tahun"
                                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                    required>
                                <option value="" {{ empty($id_tahun ?? '') ? 'selected disabled' : 'disabled' }}>Pilih Tahun Kurikulum</option>
                                @foreach(($tahun_tersedia ?? []) as $thn)
                                    <option value="{{ $thn->id_tahun }}" {{ ($id_tahun ?? '') == $thn->id_tahun ? 'selected' : '' }}>
                                        {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="self-end flex gap-2">
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Tampilkan Data
                            </button>
                            {{-- Tombol Export Excel khusus tim bisa ditambahkan jika route sudah tersedia --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @php
            $isFiltered = !empty($id_tahun);
        @endphp

        @if(!$isFiltered)
            {{-- Empty state sebelum memilih tahun (mirip halaman Mata Kuliah) --}}
            <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center">
                <div class="flex justify-center mb-4">
                    <div class="w-20 h-20 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                        <i class="fas fa-filter text-3xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
                <p class="text-gray-600 mt-1">
                    Silakan pilih tahun kurikulum untuk menampilkan data bobot MK-CPL program studi Anda.
                </p>
            </div>
        @else
        <!-- Main Card: Tabel Bobot -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            @if($bobots->isEmpty())
                <!-- Empty State -->
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Data Bobot</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Belum ada bobot MK-CPL. Klik tombol "Tambah Bobot" untuk menambahkan data baru.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('tim.bobot.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700
                                  text-white font-medium rounded-lg shadow-sm hover:shadow-md
                                  transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Bobot Pertama
                        </a>
                    </div>
                </div>
            @else
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Bobot</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                            <tr>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-16">No</th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-28">Kode MK</th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-28">Kode CPL</th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-24">Bobot</th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach(($bobots ?? []) as $index => $b)
                                <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700 font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                            {{ $b->kode_mk }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            {{ $b->kode_cpl ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-semibold text-gray-900">
                                        {{ $b->bobot }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('tim.bobot.detail', $b->id_cpl) }}"
                                               class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-all duration-200"
                                               title="Detail Bobot CPL-MK">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Detail
                                            </a>
                                            <a href="{{ route('tim.bobot.edit', $b->id_bobot) }}"
                                               class="inline-flex items-center px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-gray-900 text-xs font-medium rounded-lg transition-all duration-200"
                                               title="Edit Bobot">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('tim.bobot.destroy', $b->id_bobot) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus data bobot ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition-all duration-200"
                                                        title="Hapus Bobot">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-3h4m-6 0a1 1 0 011-1h4a1 1 0 011 1m-6 0h6m-7 4h8m-6 4v4m4-4v4"/>
                                                    </svg>
                                                    Hapus
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
        @endif

    </div>
</div>

@push('scripts')
<script>
// Auto-hide alerts
setTimeout(function() {
    const el = document.getElementById('alert-success');
    if (el) {
        el.classList.add('animate-fade-out');
        setTimeout(() => el.remove(), 300);
    }
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
