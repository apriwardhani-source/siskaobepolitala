@extends('layouts.wadir1.app')
@section('title', 'Detail Bobot CPL-MK - Wadir 1')
@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-5xl mx-auto">

    <!-- Header selaras dengan admin -->
    <div class="mb-6">
      <a href="{{ route('wadir1.bobot.index') }}" 
         class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
        <i class="fas fa-arrow-left mr-2 text-xs"></i>
        kembali
      </a>
      <div class="flex items-center space-x-4">
        <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
          <i class="fas fa-weight-hanging text-xl"></i>
        </div>
        <div>
          <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Detail Bobot CPL - MK</h1>
          <p class="mt-1 text-sm text-gray-600">
            Informasi kontribusi mata kuliah terhadap CPL {{ $kode_cpl ?? $id_cpl }}.
          </p>
        </div>
      </div>
    </div>

    <div class="space-y-6">
      <!-- Info CPL -->
      <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
          <div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Kode CPL</p>
            <p class="mt-1 text-lg font-bold text-gray-900">{{ $kode_cpl ?? $id_cpl }}</p>
          </div>
          <div class="text-right">
            <p class="text-xs font-semibold text-gray-500 mb-1 uppercase">Total Bobot</p>
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold
                         {{ ($totalBobot ?? 0) == 100 ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
              {{ $totalBobot ?? 0 }}%
            </span>
          </div>
        </div>
        <div class="px-6 py-4 bg-white">
          <p class="text-xs font-semibold text-gray-500 mb-1 uppercase">Deskripsi CPL</p>
          <p class="text-sm text-gray-700 leading-relaxed">
            {{ $deskripsi_cpl ?? '-' }}
          </p>
        </div>
      </div>

      <!-- Daftar MK dan Bobot -->
      <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
          <p class="text-sm font-semibold text-gray-800">Mata Kuliah Kontributor</p>
          <p class="text-xs text-gray-500">
            Daftar mata kuliah yang berkontribusi pada CPL ini beserta bobot persentasenya.
          </p>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
              <tr>
                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-16">No</th>
                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Kode MK</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Nama Mata Kuliah</th>
                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-24">Bobot (%)</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @forelse(($mataKuliahs ?? []) as $index => $mk)
                <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                  <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700 font-medium">
                    {{ $index + 1 }}
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                      {{ $mk->kode_mk }}
                    </span>
                  </td>
                  <td class="px-4 py-3 text-sm text-gray-800">
                    {{ $mk->nama_mk }}
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-semibold text-gray-900">
                    {{ $existingBobots[$mk->kode_mk] ?? '-' }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-6 py-6 text-center text-gray-600 text-sm">
                    Tidak ada mata kuliah terkait untuk CPL ini.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
