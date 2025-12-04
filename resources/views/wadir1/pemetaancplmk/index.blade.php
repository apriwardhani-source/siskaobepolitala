@extends('layouts.wadir1.app')
@section('title', 'Pemetaan CPL - MK - Wadir 1')
@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <!-- Header ala fitur lain -->
    <div class="mb-8">
      <div class="flex items-center space-x-4">
        <div class="flex-shrink-0">
          <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
            <i class="fas fa-project-diagram text-white text-2xl"></i>
          </div>
        </div>
        <div>
          <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pemetaan CPL - MK</h1>
          <p class="mt-1 text-sm text-gray-600">Matriks pemetaan capaian profil lulusan dengan mata kuliah</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
      <!-- Header Filter -->
      <div class="bg-blue-600 px-6 py-4 flex items-center justify-between text-white">
        <div class="flex items-center space-x-3">
          <div class="w-9 h-9 rounded-lg bg-blue-500 flex items-center justify-center shadow">
            <i class="fas fa-filter text-white"></i>
          </div>
          <div>
            <h2 class="text-lg font-bold">Filter Pemetaan CPL - MK</h2>
            <p class="text-xs text-blue-100">Pilih program studi dan tahun kurikulum untuk menampilkan matriks.</p>
          </div>
        </div>
      </div>

      <!-- Toolbar -->
      <div class="px-6 py-5 border-b border-gray-200 bg-white">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
          <div>
            <h2 class="text-lg font-semibold text-gray-900">Matriks Pemetaan</h2>
            <p class="text-xs text-gray-500">Sesuaikan program studi dan tahun sebelum melihat matriks.</p>
          </div>
          <form action="{{ route('wadir1.pemetaancplmk.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">
                <i class="fas fa-university text-blue-500 mr-1"></i>
                Program Studi
              </label>
              <select name="kode_prodi" required class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="" disabled {{ empty($kode_prodi ?? '') ? 'selected' : '' }}>Pilih Program Studi</option>
                @foreach(($prodis ?? []) as $prodi)
                  <option value="{{ $prodi->kode_prodi }}" {{ ($kode_prodi ?? '') == $prodi->kode_prodi ? 'selected' : '' }}>{{ $prodi->nama_prodi }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">
                <i class="fas fa-calendar text-green-500 mr-1"></i>
                Tahun Kurikulum
              </label>
              <select name="id_tahun" required class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="" disabled {{ empty($id_tahun ?? '') ? 'selected' : '' }}>Pilih Tahun Kurikulum</option>
                @foreach(($tahun_tersedia ?? []) as $thn)
                  <option value="{{ $thn->id_tahun }}" {{ ($id_tahun ?? '') == $thn->id_tahun ? 'selected' : '' }}>{{ $thn->nama_kurikulum }} - {{ $thn->tahun }}</option>
                @endforeach
              </select>
            </div>
            <div class="flex sm:justify-end">
              <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 w-full sm:w-auto justify-center">
                <i class="fas fa-search mr-2"></i> Terapkan
              </button>
            </div>
          </form>
        </div>
        @php $hasFilter = !empty($kode_prodi ?? null) && !empty($id_tahun ?? null); @endphp
        @if ($hasFilter)
        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
          <div class="flex flex-wrap gap-2 items-center">
            <span class="text-sm text-blue-800 font-medium">Filter aktif:</span>
            @if (!empty($kode_prodi))
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                Prodi: {{ ($prodis ?? collect())->where('kode_prodi', $kode_prodi)->first()->nama_prodi ?? $kode_prodi }}
              </span>
            @endif
            @if (!empty($id_tahun))
              @php $selected_tahun = ($tahun_tersedia ?? collect())->firstWhere('id_tahun', $id_tahun); @endphp
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                Tahun: {{ $selected_tahun ? ($selected_tahun->nama_kurikulum . ' - ' . $selected_tahun->tahun) : $id_tahun }}
              </span>
            @endif
            <a href="{{ route('wadir1.pemetaancplmk.index') }}" class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-medium">Reset filter</a>
          </div>
        </div>
        @endif
      </div>

      <div class="px-6 py-4 bg-blue-50 border-b border-blue-100">
        <div class="flex items-start">
          <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center mr-3">
            <i class="fas fa-info"></i>
          </div>
          <div class="text-sm text-blue-800">Centang menunjukkan CPL terpetakan ke MK. Tampilan ini bersifat read-only untuk Wadir1.</div>
        </div>
      </div>

      @if(!$hasFilter)
        <div class="p-10 text-center">
          <div class="flex justify-center mb-4">
            <div class="w-20 h-20 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
              <i class="fas fa-filter text-3xl"></i>
            </div>
          </div>
          <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
          <p class="text-gray-600 mt-1">Silakan pilih program studi dan tahun kurikulum untuk menampilkan matriks pemetaan.</p>
        </div>
      @else
        <div class="overflow-auto border">
          <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gradient-to-r from-gray-700 to-gray-800 text-white text-center">
              <tr>
                <th class="border px-4 py-2 text-xs font-semibold uppercase tracking-wider">Kode MK</th>
                <th class="border px-4 py-2 text-xs font-semibold uppercase tracking-wider">Nama Mata Kuliah</th>
                @foreach (($cpls ?? []) as $cpl)
                  <th class="border px-4 py-2 text-xs font-semibold uppercase tracking-wider relative group cursor-pointer">
                    {{ $cpl->kode_cpl }}
                    <div
                      class="absolute left-1/2 -translate-x-1/2 top-full mt-1 hidden group-hover:block w-64 bg-black text-white text-xs rounded p-2 z-50 text-center shadow-lg">
                      <div class="bg-gray-600 font-semibold">
                        {{ $prodiByCpl[$cpl->id_cpl] ?? 'Program Studi' }}
                      </div>
                      <div class="mt-2 text-justify">
                        {{ $cpl->deskripsi_cpl ?? '-' }}
                      </div>
                    </div>
                  </th>
                @endforeach
              </tr>
            </thead>
            <tbody class="bg-white text-gray-800">
              @foreach (($mks ?? []) as $index => $mk)
                <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                  <td class="border px-4 py-2 align-top text-center">{{ $mk->kode_mk }}</td>
                  <td class="border px-4 py-2 align-top">{{ $mk->nama_mk }}</td>
                  @foreach (($cpls ?? []) as $cpl)
                    @php
                      $mkRelasi = $relasi[$mk->kode_mk] ?? collect();
                      $terpetakan = $mkRelasi->pluck('id_cpl')->contains($cpl->id_cpl);
                    @endphp
                    <td class="border px-4 py-2 text-center">
                      @if ($terpetakan)
                        <span
                          class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-500 text-white text-sm font-bold">
                          ✓
                        </span>
                      @endif
                    </td>
                  @endforeach
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</div>

@push('styles')
<style>
input[type="checkbox"]:checked::before { content: "✓"; color: white; font-size: 1.1rem; font-weight: bold; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
.sticky { box-shadow: 2px 0 5px rgba(0,0,0,0.06); }
.overflow-x-auto { scrollbar-width: thin; scrollbar-color: #cbd5e0 #f7fafc; }
.overflow-x-auto::-webkit-scrollbar { height: 8px; }
.overflow-x-auto::-webkit-scrollbar-track { background: #f7fafc; }
.overflow-x-auto::-webkit-scrollbar-thumb { background-color: #cbd5e0; border-radius: 4px; }
.overflow-x-auto::-webkit-scrollbar-thumb:hover { background-color: #a0aec0; }
</style>
@endpush
@endsection
