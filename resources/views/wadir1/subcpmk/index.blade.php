@extends('layouts.wadir1.app')
@section('title', 'Sub CPMK - Wadir 1')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
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

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
      <div class="bg-blue-600 px-6 py-4 flex items-center justify-between text-white">
        <h2 class="text-xl font-bold flex items-center">
          <i class="fas fa-filter mr-2"></i>
          Filter Sub CPMK
        </h2>
      </div>
      <div class="p-6 border-b border-gray-200 bg-white">
        <form method="GET" action="{{ route('wadir1.subcpmk.index') }}" class="space-y-4">
          <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between space-y-4 lg:space-y-0 gap-4">
            <div class="flex-1">
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-university text-blue-500 mr-1"></i>
                Program Studi
              </label>
              <select name="kode_prodi" required
                      class="block w-full max-w-xs px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="" disabled {{ empty($kode_prodi ?? '') ? 'selected' : '' }}>Pilih Program Studi</option>
                @foreach(($prodis ?? []) as $p)
                  <option value="{{ $p->kode_prodi }}" {{ ($kode_prodi ?? '')==$p->kode_prodi ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                @endforeach
              </select>
            </div>
            <div class="flex-1">
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-calendar text-green-500 mr-1"></i>
                Tahun Kurikulum
              </label>
              <select name="id_tahun" required
                      class="block w-full max-w-xs px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="" disabled {{ empty($id_tahun ?? '') ? 'selected' : '' }}>Pilih Tahun Kurikulum</option>
                @foreach(($tahun_tersedia ?? []) as $t)
                  <option value="{{ $t->id_tahun }}" {{ ($id_tahun ?? '')==$t->id_tahun ? 'selected' : '' }}>{{ $t->tahun }}</option>
                @endforeach
              </select>
            </div>
            <div class="flex gap-3">
              <button type="submit"
                      class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-search mr-2"></i>
                Tampilkan Data
              </button>
              <a href="{{ route('wadir1.export.subcpmk', ['kode_prodi'=>($kode_prodi ?? request('kode_prodi')), 'id_tahun'=>($id_tahun ?? request('id_tahun'))]) }}"
                 class="inline-flex items-center px-4 py-2.5 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>

    @php $isFiltered = !empty($kode_prodi) && !empty($id_tahun); @endphp

    @if(!$isFiltered)
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
        <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
          <h2 class="text-lg font-semibold text-gray-800">Daftar Sub CPMK</h2>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-700 to-gray-800 text-white">
              <tr>
                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider w-16">No</th>
                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider w-32">Kode CPMK</th>
                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider w-32">Sub CPMK</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Uraian</th>
                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider w-32">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($subcpmks as $index => $row)
                <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                  <td class="px-4 py-3 text-center text-sm text-gray-700 font-medium">
                    {{ $index + 1 }}
                  </td>
                  <td class="px-4 py-3 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                      {{ $row->kode_cpmk }}
                    </span>
                  </td>
                  <td class="px-4 py-3 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                      {{ $row->sub_cpmk }}
                    </span>
                  </td>
                  <td class="px-4 py-3 text-sm text-gray-700">
                    {{ \Illuminate\Support\Str::limit($row->uraian_cpmk, 150) }}
                  </td>
                  <td class="px-4 py-3 text-center">
                    <a href="{{ route('wadir1.subcpmk.detail', $row->id_sub_cpmk) }}"
                       class="inline-flex items-center justify-center p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all duration-200"
                       title="Detail">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                      </svg>
                    </a>
                  </td>
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
@endsection
