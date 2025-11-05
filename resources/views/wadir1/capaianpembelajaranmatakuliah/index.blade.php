@extends('layouts.app')
@section('title', 'CPMK - Wadir 1')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <div class="mb-8">
      <div class="flex items-center space-x-4">
        <div class="flex-shrink-0">
          <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
            <i class="fas fa-bullseye text-white text-2xl"></i>
          </div>
        </div>
        <div>
          <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Capaian Pembelajaran Mata Kuliah (CPMK)</h1>
          <p class="mt-1 text-sm text-gray-600">Daftar CPMK per program studi dan tahun</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
      <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
        <h2 class="text-xl font-bold text-white flex items-center"><i class="fas fa-filter mr-2"></i>Filter CPMK</h2>
      </div>
      <div class="p-6">
        <form method="GET" action="{{ route('wadir1.capaianpembelajaranmatakuliah.index') }}" class="space-y-4">
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
              <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200"><i class="fas fa-search mr-2"></i>Tampilkan Data</button>
              <a href="{{ route('wadir1.export.cpmk', ['kode_prodi'=>($kode_prodi ?? request('kode_prodi')), 'id_tahun'=>($id_tahun ?? request('id_tahun'))]) }}" class="inline-flex items-center px-4 py-2.5 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>

    @php 
      $isFiltered = !empty($kode_prodi) || !empty($id_tahun);
      $cpmkCollection = collect($cpmks ?? []);
    @endphp

    @if(!$isFiltered)
      <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center mb-8">
        <div class="flex justify-center mb-4">
          <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 text-white flex items-center justify-center shadow-lg">
            <i class="fas fa-filter text-3xl"></i>
          </div>
        </div>
        <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
        <p class="text-gray-600 mt-1">Silakan pilih program studi dan tahun untuk menampilkan data CPMK.</p>
      </div>
    @elseif($cpmkCollection->isNotEmpty())
      <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="px-6 py-4 border-b bg-gray-50"><h2 class="text-lg font-semibold text-gray-800">Daftar CPMK</h2></div>
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-6 py-3 text-left font-semibold text-gray-700">Kode CPMK</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-700">Deskripsi</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              @foreach($cpmkCollection as $row)
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-3">{{ $row->kode_cpmk }}</td>
                  <td class="px-6 py-3">{{ $row->deskripsi_cpmk }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @elseif(!empty($kode_prodi))
      <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded"><div class="text-sm text-yellow-800">Data kosong untuk filter yang dipilih.</div></div>
    @endif
  </div>
</div>
@endsection
