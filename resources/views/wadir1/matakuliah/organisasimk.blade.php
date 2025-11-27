@extends('layouts.wadir1.app')
@section('title', 'Organisasi MK - Wadir 1')
@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center space-x-4">
        <div class="flex-shrink-0">
          <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
            <i class="fas fa-project-diagram text-white text-2xl"></i>
          </div>
        </div>
        <div>
          <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Organisasi Mata Kuliah</h1>
          <p class="mt-1 text-sm text-gray-600">Distribusi MK per semester, total SKS, dan jumlah MK</p>
        </div>
      </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
      <div class="bg-blue-600 px-6 py-4">
        <h2 class="text-xl font-bold text-white"><i class="fas fa-filter mr-2"></i>Filter Organisasi MK</h2>
      </div>
      <div class="p-6">
        <form method="GET" action="{{ route('wadir1.matakuliah.organisasimk') }}" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Program Studi</label>
              <select name="kode_prodi" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="">Semua Prodi</option>
                @foreach(($prodis ?? []) as $p)
                  <option value="{{ $p->kode_prodi }}" {{ ($kode_prodi ?? '')==$p->kode_prodi ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kurikulum</label>
              <select name="id_tahun" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="">Semua</option>
                @foreach(($tahun_tersedia ?? []) as $t)
                  <option value="{{ $t->id_tahun }}" {{ ($id_tahun ?? '')==$t->id_tahun ? 'selected' : '' }}>{{ $t->tahun }}</option>
                @endforeach
              </select>
            </div>
            <div class="self-end flex gap-2">
              <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-search mr-2"></i>Tampilkan Data
              </button>
              <a href="{{ route('wadir1.export.mk', ['kode_prodi'=>($kode_prodi ?? request('kode_prodi')), 'id_tahun'=>($id_tahun ?? request('id_tahun'))]) }}" class="inline-flex items-center px-4 py-2.5 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>

    @php $isFiltered = !empty($kode_prodi) || !empty($id_tahun); @endphp
    @if(!$isFiltered)
      <!-- Empty Prompt When No Filter -->
      <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center mb-8">
        <div class="flex justify-center mb-4">
          <div class="w-20 h-20 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
            <i class="fas fa-filter text-3xl"></i>
          </div>
        </div>
        <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
        <p class="text-gray-600 mt-1">Silakan pilih program studi dan tahun untuk menampilkan organisasi mata kuliah.</p>
      </div>
    @endif

    @if($isFiltered)
      <!-- Result: Grouped by Semester -->
      <div class="space-y-6">
        @forelse(($organisasiMK ?? collect()) as $row)
          <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
              <h2 class="text-lg font-semibold text-gray-800">Semester {{ $row['semester_mk'] }}</h2>
              <div class="text-sm text-gray-600">Total SKS: <span class="font-semibold">{{ $row['sks_mk'] }}</span> · Jumlah MK: <span class="font-semibold">{{ $row['jumlah_mk'] }}</span></div>
            </div>
            <div class="p-6">
              <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 list-none">
                @foreach(($row['nama_mk'] ?? []) as $nm)
                  <li class="px-4 py-3 rounded-md border border-gray-200 hover:border-blue-400 bg-white flex items-center gap-2">
                    <i class="fas fa-book text-blue-600"></i>
                    <span class="text-gray-800">{{ $nm }}</span>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        @empty
          <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center">
            <div class="flex justify-center mb-4">
              <div class="w-20 h-20 rounded-2xl bg-gray-200 text-gray-500 flex items-center justify-center">
                <i class="far fa-folder-open text-3xl"></i>
              </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Tidak ada data</h3>
            <p class="text-gray-600 mt-1">Data organisasi mata kuliah tidak ditemukan untuk filter yang dipilih.</p>
          </div>
        @endforelse
      </div>
    @endif
  </div>
  </div>
@endsection
