@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
      <div class="px-6 py-4 border-b bg-gray-50">
        <h1 class="text-xl font-bold text-gray-800">Detail Bobot per MK untuk CPL: {{ $id_cpl }}</h1>
        <p class="text-sm text-gray-600 mt-1">Daftar mata kuliah yang berkontribusi pada CPL ini beserta bobotnya.</p>
      </div>
      <div class="p-6">
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-6 py-3 text-left font-semibold text-gray-700">Kode MK</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-700">Nama MK</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-700">Bobot</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              @forelse(($mataKuliahs ?? []) as $mk)
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-3">{{ $mk->kode_mk }}</td>
                  <td class="px-6 py-3">{{ $mk->nama_mk }}</td>
                  <td class="px-6 py-3">{{ $existingBobots[$mk->kode_mk] ?? '-' }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="px-6 py-6 text-center text-gray-600">Tidak ada mata kuliah terkait.</td>
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

