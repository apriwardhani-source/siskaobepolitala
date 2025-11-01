@extends('layouts.app')
@section('title', 'CPL - Wadir 1')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">

    <!-- Header ala Hasil OBE -->
    <div class="mb-8">
      <div class="flex items-center space-x-4">
        <div class="flex-shrink-0">
          <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
            <i class="fas fa-check-square text-white text-2xl"></i>
          </div>
        </div>
        <div>
          <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Capaian Pembelajaran Lulusan (CPL)</h1>
          <p class="mt-1 text-sm text-gray-600">Pantau daftar CPL per program studi dan tahun kurikulum</p>
        </div>
      </div>
    </div>

    <!-- Kartu Filter -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
      <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
        <h2 class="text-xl font-bold text-white flex items-center">
          <i class="fas fa-filter mr-2"></i>
          Filter CPL
        </h2>
      </div>
      <div class="p-6">
        <form method="GET" action="{{ route('wadir1.capaianpembelajaranlulusan.index') }}" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Prodi -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2"><i class="fas fa-university text-blue-500 mr-1"></i>Program Studi</label>
              <select name="kode_prodi" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="">Semua Prodi</option>
                @foreach(($prodis ?? []) as $p)
                  <option value="{{ $p->kode_prodi }}" {{ ($kode_prodi ?? '') == $p->kode_prodi ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                @endforeach
              </select>
            </div>
            <!-- Tahun -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2"><i class="fas fa-calendar text-green-500 mr-1"></i>Tahun Kurikulum</label>
              <select name="id_tahun" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="">Semua</option>
                @foreach(($tahun_tersedia ?? []) as $t)
                  <option value="{{ $t->id_tahun }}" {{ ($id_tahun ?? '') == $t->id_tahun ? 'selected' : '' }}>{{ $t->tahun }}</option>
                @endforeach
              </select>
            </div>
            <div class="self-end flex gap-2">
              <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-search mr-2"></i> Tampilkan Data
              </button>
              <a href="{{ route('wadir1.export.cpl', ['kode_prodi'=>($kode_prodi ?? request('kode_prodi')), 'id_tahun'=>($id_tahun ?? request('id_tahun'))]) }}" class="inline-flex items-center px-4 py-2.5 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
              </a>
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

    @if(!$isFiltered)
      <!-- Empty state sebelum filter -->
      <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center mb-8">
        <div class="flex justify-center mb-4">
          <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 text-white flex items-center justify-center shadow-lg">
            <i class="fas fa-filter text-3xl"></i>
          </div>
        </div>
        <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
        <p class="text-gray-600 mt-1">Silakan pilih program studi dan tahun untuk menampilkan data CPL.</p>
      </div>
    @else
      <!-- Filter Aktif -->
      <div class="bg-white rounded-xl shadow border border-gray-200 p-4 mb-6">
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
          <a href="{{ route('wadir1.capaianpembelajaranlulusan.index') }}" class="text-red-600 text-sm ml-2"><i class="fas fa-times mr-1"></i>Reset</a>
        </div>
      </div>

      <!-- Summary Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-blue-500">
          <div class="p-6 flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600 uppercase">Total CPL</p>
              <p class="mt-2 text-3xl font-bold text-gray-900">{{ ($capaianprofillulusans ?? collect())->count() }}</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center text-white"><i class="fas fa-check-square text-2xl"></i></div>
          </div>
        </div>
      <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-green-500">
        <div class="p-6 flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600 uppercase">Angkatan</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $selectedYear->tahun ?? '-' }}</p>
          </div>
          <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center text-white"><i class="fas fa-calendar text-2xl"></i></div>
        </div>
      </div>
      <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-purple-500">
        <div class="p-6 flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600 uppercase">Program Studi</p>
            <p class="mt-2 text-xl font-bold text-gray-900">{{ $selectedProdi->nama_prodi ?? '-' }}</p>
          </div>
          <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center text-white"><i class="fas fa-graduation-cap text-2xl"></i></div>
        </div>
      </div>
      </div>
    @endif

    @if(isset($kode_prodi) && $kode_prodi!=='' && ($capaianprofillulusans ?? collect())->isEmpty())
      <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
        <div class="text-sm text-yellow-800">Data kosong untuk filter yang dipilih.</div>
      </div>
    @endif

    <!-- Tabel Hasil -->
    @if(($capaianprofillulusans ?? collect())->isNotEmpty())
      <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
          <h2 class="text-lg font-semibold text-gray-800">Daftar CPL</h2>
          <div class="relative">
            <input id="searchCpl" type="text" class="pl-9 pr-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Cari CPL...">
            <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400"></i>
          </div>
        </div>
        <div class="overflow-x-auto">
          <table id="tableCpl" class="min-w-full text-sm">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-6 py-3 text-left font-semibold text-gray-700">Kode CPL</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-700">Deskripsi</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              @foreach($capaianprofillulusans as $cpl)
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-3">{{ $cpl->kode_cpl }}</td>
                  <td class="px-6 py-3">{{ $cpl->deskripsi_cpl }}</td>
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
  const searchInput = document.getElementById('searchCpl');
  const table = document.getElementById('tableCpl');
  if (searchInput && table) {
    searchInput.addEventListener('input', function () {
      const q = this.value.toLowerCase();
      for (const tr of table.querySelectorAll('tbody tr')) {
        const text = tr.innerText.toLowerCase();
        tr.style.display = text.includes(q) ? '' : 'none';
      }
    });
  }
</script>
@endpush
@endsection
