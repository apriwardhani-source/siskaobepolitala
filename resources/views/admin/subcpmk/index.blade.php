@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header ala Wadir1 -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-list-check text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Sub CPMK</h1>
                    <p class="mt-1 text-sm text-gray-600">Daftar indikator pencapaian per CPMK</p>
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

        <!-- Kartu Filter -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </h2>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('admin.subcpmk.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Program Studi</label>
                            <select name="kode_prodi" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">Semua Prodi</option>
                                @foreach(($prodis ?? []) as $p)
                                  <option value="{{ $p->kode_prodi }}" {{ ($kode_prodi ?? '')==$p->kode_prodi ? 'selected' : '' }}>
                                      {{ $p->nama_prodi }}
                                  </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kurikulum</label>
                            <select name="id_tahun" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">Semua</option>
                                @foreach(($tahun_tersedia ?? []) as $t)
                                  <option value="{{ $t->id_tahun }}" {{ ($id_tahun ?? '')==$t->id_tahun ? 'selected' : '' }}>
                                      {{ $t->tahun }}
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
                            <a href="{{ route('admin.export.subcpmk', ['kode_prodi'=>($kode_prodi ?? request('kode_prodi')), 'id_tahun'=>($id_tahun ?? request('id_tahun'))]) }}" 
                               class="inline-flex items-center px-4 py-2.5 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                                <i class="fas fa-file-excel mr-2"></i> Export Excel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @php $isFiltered = !empty($kode_prodi) || !empty($id_tahun); @endphp

        @if(!$isFiltered)
            <!-- Empty state sebelum filter -->
            <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="w-20 h-20 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                        <i class="fas fa-filter text-3xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
                <p class="text-gray-600 mt-1">Silakan pilih program studi dan tahun untuk menampilkan data Sub CPMK.</p>
            </div>
        @elseif(($subcpmks ?? collect())->isNotEmpty())
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Sub CPMK</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Kode CPMK</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Sub CPMK</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Uraian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($subcpmks as $row)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-3">{{ $row->kode_cpmk }}</td>
                                    <td class="px-6 py-3">{{ $row->sub_cpmk }}</td>
                                    <td class="px-6 py-3">{{ $row->uraian_cpmk }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif(!empty($kode_prodi))
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                <div class="text-sm text-yellow-800">Data kosong untuk filter yang dipilih.</div>
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
@endpush
@endsection
