@extends('layouts.kaprodi.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center space-x-4">
        <div class="flex-shrink-0">
          <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
            <i class="fas fa-sitemap text-white text-2xl"></i>
          </div>
        </div>
        <div>
          <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pemetaan MK - CPMK - SubCPMK</h1>
          <p class="mt-1 text-sm text-gray-600">
            Hubungan MK terhadap CPMK dan indikator SubCPMK untuk program studi Anda (mode baca saja).
          </p>
        </div>
      </div>
    </div>

    <!-- Filter card (tahun saja, prodi fixed dari kaprodi) -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
      <div class="bg-blue-600 px-6 py-4">
        <h2 class="text-xl font-bold text-white flex items-center">
          <i class="fas fa-filter mr-2"></i>
          Filter
        </h2>
      </div>
      <div class="p-6">
        <form method="GET" action="{{ route('kaprodi.pemetaanmkcpmksubcpmk.index') }}" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-university text-blue-500 mr-1"></i>
                Program Studi
              </label>
              <input type="text" disabled
                     class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-sm"
                     value="{{ auth()->user()->prodi->nama_prodi ?? 'Program Studi' }}">
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-calendar text-green-500 mr-1"></i>
                Tahun Kurikulum
              </label>
              <select name="id_tahun"
                      class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="" {{ empty($id_tahun ?? '') ? 'selected' : '' }}>Semua Tahun</option>
                @foreach(($tahun_tersedia ?? []) as $t)
                  <option value="{{ $t->id_tahun }}" {{ ($id_tahun ?? '') == $t->id_tahun ? 'selected' : '' }}>
                    {{ $t->tahun }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="self-end">
              <button type="submit"
                      class="w-full px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-search mr-2"></i>
                Tampilkan Data
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    @php
      $collection = collect($data ?? []);
    @endphp

    @if($collection->isNotEmpty())
      <!-- Tabel pemetaan (mirip admin) -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
          <h2 class="text-lg font-semibold text-white flex items-center">
            <i class="fas fa-diagram-project mr-2 text-sm"></i>
            Pemetaan MK - CPMK - SubCPMK
          </h2>
        </div>
        <div class="overflow-x-auto">
          @php
            $groupMk = $collection->groupBy('kode_mk');
          @endphp
          <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-800 text-white">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-32">Kode MK</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama MK</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-32">Kode CPMK</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Deskripsi CPMK</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-80">SubCPMK</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($groupMk as $kode_mk => $rowsMk)
                @php
                  $mkName    = $rowsMk->first()->nama_mk ?? '';
                  $groupCpmk = $rowsMk->groupBy('kode_cpmk');
                  $mkRowCount = $groupCpmk->sum(fn($items) => max($items->count(), 1));
                  $firstMkRow = true;
                @endphp
                @foreach($groupCpmk as $kode_cpmk => $items)
                  @php
                    $cpmkRowCount = max($items->count(), 1);
                    $firstCpmkRow = true;
                    $deskripsiCpmk = $items->first()->deskripsi_cpmk ?? '-';
                  @endphp
                  @foreach($items as $item)
                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                      @if($firstMkRow)
                        <td class="px-4 py-4 border-r border-gray-200 align-top bg-gradient-to-r from-blue-50 to-transparent"
                            rowspan="{{ $mkRowCount }}">
                          <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-sm">
                            {{ $kode_mk }}
                          </span>
                        </td>
                        <td class="px-4 py-4 border-r border-gray-200 text-sm text-gray-700 align-top leading-relaxed"
                            rowspan="{{ $mkRowCount }}">
                          {{ $mkName }}
                        </td>
                        @php $firstMkRow = false; @endphp
                      @endif

                      @if($firstCpmkRow)
                        <td class="px-4 py-4 border-r border-gray-200 align-top">
                          <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-sm">
                            {{ $kode_cpmk }}
                          </span>
                        </td>
                        <td class="px-4 py-4 border-r border-gray-200 text-sm text-gray-700 leading-relaxed"
                            rowspan="{{ $cpmkRowCount }}">
                          {{ $deskripsiCpmk }}
                        </td>
                        @php $firstCpmkRow = false; @endphp
                      @endif

                      <td class="px-4 py-4 text-sm text-gray-700">
                        @if(!empty($item->sub_cpmk) || !empty($item->uraian_cpmk))
                          <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-green-100 text-green-800">
                            {{ $item->sub_cpmk }} &mdash; {{ $item->uraian_cpmk }}
                          </span>
                        @else
                          <span class="text-gray-400">-</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                @endforeach
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    @else
      <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
        <div class="text-sm text-yellow-800">Data kosong untuk tahun kurikulum yang dipilih.</div>
      </div>
    @endif

  </div>
</div>
@endsection
