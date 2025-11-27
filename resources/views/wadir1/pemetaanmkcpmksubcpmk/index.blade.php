@extends('layouts.wadir1.app')
@section('title', 'Pemetaan MK-CPMK-SubCPMK - Wadir 1')
@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <div class="mb-8">
      <div class="flex items-center space-x-4">
        <div class="flex-shrink-0">
          <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
            <i class="fas fa-sitemap text-white text-2xl"></i>
          </div>
        </div>
        <div>
          <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pemetaan MK - CPMK - SubCPMK</h1>
          <p class="mt-1 text-sm text-gray-600">Hubungan MK terhadap CPMK dan indikator SubCPMK</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
      <div class="bg-blue-600 px-6 py-4"><h2 class="text-xl font-bold text-white"><i class="fas fa-filter mr-2"></i>Filter</h2></div>
      <div class="p-6">
        <form method="GET" action="{{ route('wadir1.pemetaanmkcpmksubcpmk.index') }}" class="space-y-4">
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
            <div class="self-end">
              <button type="submit" class="w-full px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200"><i class="fas fa-search mr-2"></i>Tampilkan Data</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    @php $isFiltered = !empty($kode_prodi) || !empty($id_tahun); @endphp
    @if(!$isFiltered)
      <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center mb-8">
        <div class="flex justify-center mb-4">
          <div class="w-20 h-20 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
            <i class="fas fa-filter text-3xl"></i>
          </div>
        </div>
        <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
        <p class="text-gray-600 mt-1">Silakan pilih program studi dan tahun untuk menampilkan data pemetaan MK-CPMK-SubCPMK.</p>
      </div>
    @elseif(($query ?? collect())->isNotEmpty())
      <div class="space-y-6">
        @php
          $group = ($query ?? collect())->groupBy('kode_mk');
        @endphp
        @foreach($group as $kode_mk => $rows)
          <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-4 border-b bg-gray-50">
              <h2 class="text-lg font-semibold text-gray-800">{{ $kode_mk }} — {{ $rows->first()->nama_mk ?? '' }}</h2>
            </div>
            <div class="p-6 space-y-3">
              @foreach($rows->groupBy('kode_cpmk') as $kode_cpmk => $items)
                <div class="border rounded-lg p-4">
                  <div class="text-sm font-semibold text-gray-800">CPMK {{ $kode_cpmk }}</div>
                  <div class="text-sm text-gray-600 mb-2">{{ $items->first()->deskripsi_cpmk ?? '-' }}</div>
                  <ul class="list-disc pl-5">
                    @foreach($items as $it)
                      <li>{{ $it->sub_cpmk }} — {{ $it->uraian_cpmk }}</li>
                    @endforeach
                  </ul>
                </div>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
    @elseif(!empty($kode_prodi))
      <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded"><div class="text-sm text-yellow-800">Data kosong untuk filter yang dipilih.</div></div>
    @endif
  </div>
</div>
@endsection
