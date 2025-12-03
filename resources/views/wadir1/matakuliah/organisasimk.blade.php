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
        <h2 class="text-xl font-bold text-white">
          <i class="fas fa-filter mr-2"></i>Filter Organisasi MK
        </h2>
      </div>
      <div class="p-6">
        <form method="GET" action="{{ route('wadir1.matakuliah.organisasimk') }}" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Program Studi</label>
              <select name="kode_prodi" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="">Semua Prodi</option>
                @foreach(($prodis ?? []) as $p)
                  <option value="{{ $p->kode_prodi }}" {{ ($kode_prodi ?? '') == $p->kode_prodi ? 'selected' : '' }}>
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
              <a href="{{ route('wadir1.export.mk', ['kode_prodi' => ($kode_prodi ?? request('kode_prodi')), 'id_tahun' => ($id_tahun ?? request('id_tahun'))]) }}" class="inline-flex items-center px-4 py-2.5 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>

    @php
        $isFiltered = !empty($kode_prodi) || !empty($id_tahun);
    @endphp

    @if(!$isFiltered)
      <!-- Empty Prompt When No Filter -->
      <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center mb-8">
        <div class="flex justify-center mb-4">
          <div class="w-20 h-20 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
            <i class="fas fa-filter text-3xl"></i>
          </div>
        </div>
        <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
        <p class="text-gray-600 mt-1">
          Silakan pilih program studi dan tahun untuk menampilkan organisasi mata kuliah.
        </p>
      </div>
    @endif

    @if($isFiltered)
      @php
          $dataCollection = collect($organisasiMK ?? []);
          $hasData = $dataCollection->isNotEmpty();
      @endphp

      @if(!$hasData)
        <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center">
          <div class="flex justify-center mb-4">
            <div class="w-20 h-20 rounded-2xl bg-gray-200 text-gray-500 flex items-center justify-center">
              <i class="far fa-folder-open text-3xl"></i>
            </div>
          </div>
          <h3 class="text-lg font-semibold text-gray-800">Tidak ada data</h3>
          <p class="text-gray-600 mt-1">
            Data organisasi mata kuliah tidak ditemukan untuk filter yang dipilih.
          </p>
        </div>
      @else
        <!-- Result: Tabel ala Tim Organisasi MK -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
          <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Distribusi Mata Kuliah per Semester</h2>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                <tr>
                  <th class="px-6 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-40">Semester</th>
                  <th class="px-6 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Total SKS</th>
                  <th class="px-6 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Jumlah MK</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Mata Kuliah</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @php
                    $bySemester = $dataCollection->keyBy('semester_mk');
                    $totalSks = 0;
                    $totalMk = 0;
                @endphp

                @for ($i = 1; $i <= 8; $i++)
                  @php
                      $row = $bySemester->get($i, [
                          'semester_mk' => $i,
                          'sks_mk' => 0,
                          'jumlah_mk' => 0,
                          'nama_mk' => [],
                      ]);

                      $totalSks += $row['sks_mk'];
                      $totalMk += $row['jumlah_mk'];
                  @endphp
                  <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $i % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                    <td class="px-6 py-4 text-center">
                      <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                        Semester {{ $row['semester_mk'] }}
                      </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                      <span class="text-lg font-bold text-gray-900">{{ $row['sks_mk'] }}</span>
                      <span class="text-xs text-gray-500 ml-1">SKS</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                      <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold
                                   {{ $row['jumlah_mk'] > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                        {{ $row['jumlah_mk'] }} MK
                      </span>
                    </td>
                    <td class="px-6 py-4">
                      @if (!empty($row['nama_mk']))
                        <div class="flex flex-wrap gap-2">
                          @foreach ($row['nama_mk'] as $namaMk)
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                              {{ $namaMk }}
                            </span>
                          @endforeach
                        </div>
                      @else
                        <span class="text-gray-400 text-sm italic">Tidak ada mata kuliah</span>
                      @endif
                    </td>
                  </tr>
                @endfor

                <!-- Total Row -->
                <tr class="bg-gradient-to-r from-gray-800 to-gray-900 text-white font-bold">
                  <td class="px-6 py-5 text-center text-base uppercase tracking-wider">
                    <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"/>
                    </svg>
                    Total
                  </td>
                  <td class="px-6 py-5 text-center">
                    <span class="text-xl">{{ $totalSks }}</span>
                    <span class="text-sm ml-1">SKS</span>
                  </td>
                  <td class="px-6 py-5 text-center">
                    <span class="text-xl">{{ $totalMk }}</span>
                    <span class="text-sm ml-1">MK</span>
                  </td>
                  <td class="px-6 py-5"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      @endif
    @endif
  </div>
  </div>
@endsection

