@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Bobot CPL - MK (Kaprodi)</h1>
      <p class="mt-2 text-sm text-gray-600">Pembobotan kontribusi MK terhadap CPL di prodi Anda</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
      <div class="px-6 py-4 border-b bg-gray-50">
        <h2 class="text-lg font-semibold text-gray-800">Filter</h2>
      </div>
      <div class="p-6">
        <form method="GET" action="{{ route('kaprodi.bobot.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kurikulum</label>
            <select name="id_tahun" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
              <option value="">Semua</option>
              @foreach(($tahun_tersedia ?? []) as $t)
                <option value="{{ $t->id_tahun }}" {{ ($id_tahun ?? request('id_tahun'))==$t->id_tahun ? 'selected' : '' }}>{{ $t->tahun }}</option>
              @endforeach
            </select>
          </div>
          <div class="self-end">
            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
              Tampilkan Data
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
      <div class="px-6 py-4 border-b bg-gray-50">
        <h2 class="text-lg font-semibold text-gray-800">Daftar Bobot</h2>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-6 py-3 text-left font-semibold text-gray-700">Kode MK</th>
              <th class="px-6 py-3 text-left font-semibold text-gray-700">Kode CPL</th>
              <th class="px-6 py-3 text-left font-semibold text-gray-700">Bobot</th>
              <th class="px-6 py-3"></th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @forelse(($bobots ?? []) as $b)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-3">{{ $b->kode_mk }}</td>
                <td class="px-6 py-3">{{ $b->kode_cpl ?? ($b->kode_cpl ?? '-') }}</td>
                <td class="px-6 py-3">{{ $b->bobot }}</td>
                <td class="px-6 py-3 text-right">
                  <a href="{{ route('kaprodi.bobot.detail', $b->id_cpl) }}" class="inline-flex items-center px-3 py-1.5 text-blue-600 hover:text-blue-800">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Detail CPL
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="px-6 py-6 text-center text-gray-600">Tidak ada data.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

