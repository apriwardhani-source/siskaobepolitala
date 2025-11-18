@extends('layouts.wadir1.app')
@section('title', 'Pemetaan CPL - MK - Wadir 1')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-full mx-auto">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pemetaan CPL - MK</h1>
      <p class="mt-2 text-sm text-gray-600">Matriks pemetaan capaian profil lulusan dengan mata kuliah</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
      <div class="px-6 py-5 border-b border-gray-200 bg-white">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
          <h2 class="text-lg font-semibold text-gray-900">Matriks Pemetaan</h2>
          <div class="flex flex-col sm:flex-row gap-3">
            <form action="{{ route('wadir1.pemetaancplmk.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
              <select name="kode_prodi" class="block w-64 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="" {{ empty($kode_prodi ?? '') ? 'selected' : '' }}>Semua Prodi</option>
                @foreach(($prodis ?? []) as $prodi)
                  <option value="{{ $prodi->kode_prodi }}" {{ ($kode_prodi ?? '') == $prodi->kode_prodi ? 'selected' : '' }}>{{ $prodi->nama_prodi }}</option>
                @endforeach
              </select>
              <select name="id_tahun" class="block w-64 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="" {{ empty($id_tahun ?? '') ? 'selected' : '' }}>Semua Tahun</option>
                @foreach(($tahun_tersedia ?? []) as $thn)
                  <option value="{{ $thn->id_tahun }}" {{ ($id_tahun ?? '') == $thn->id_tahun ? 'selected' : '' }}>{{ $thn->nama_kurikulum }} - {{ $thn->tahun }}</option>
                @endforeach
              </select>
              <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-search mr-2"></i> Terapkan
              </button>
            </form>
          </div>
        </div>
        @php $hasFilter = !empty($kode_prodi ?? null) || !empty($id_tahun ?? null); @endphp
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

      <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
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
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 text-white flex items-center justify-center shadow-lg">
              <i class="fas fa-filter text-3xl"></i>
            </div>
          </div>
          <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
          <p class="text-gray-600 mt-1">Silakan pilih program studi dan/atau tahun untuk menampilkan matriks pemetaan.</p>
        </div>
      @else
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr>
                <th class="px-4 py-3 text-left bg-gray-50 border-b border-r border-gray-200 sticky left-0 z-20">CPL \ MK</th>
                @foreach (($mks ?? []) as $mk)
                  <th class="px-4 py-3 text-center bg-gray-50 border-b border-r border-gray-200 whitespace-nowrap">
                    <div class="relative group inline-block">
                      <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-800">{{ $mk->kode_mk }}</span>
                      <div class="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 hidden group-hover:block w-72 bg-gray-900 text-white text-sm rounded-lg shadow-2xl z-50">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-lg px-4 py-2 font-bold">{{ $mk->nama_prodi ?? 'Program Studi' }}</div>
                        <div class="px-4 py-3 text-left leading-relaxed"><strong>{{ $mk->kode_mk }}</strong> - {{ $mk->nama_mk }}</div>
                        <div class="absolute left-1/2 -translate-x-1/2 top-full"><div class="border-8 border-transparent border-t-gray-900"></div></div>
                      </div>
                    </div>
                  </th>
                @endforeach
              </tr>
            </thead>
            <tbody class="bg-white">
              @foreach (($cpls ?? []) as $index => $cpl)
                <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                  <td class="px-4 py-4 border-r border-b border-gray-200 sticky left-0 z-10 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                    <div class="relative group">
                      <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 cursor-help whitespace-nowrap">{{ $cpl->kode_cpl }}</span>
                      <div class="absolute left-full ml-2 top-1/2 -translate-y-1/2 hidden group-hover:block w-80 bg-gray-900 text-white text-sm rounded-lg shadow-2xl z-50">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-lg px-4 py-2 font-bold">{{ ($prodiByCpl[$cpl->id_cpl] ?? 'Program Studi') }}</div>
                        <div class="px-4 py-3 text-left leading-relaxed">{{ $cpl->deskripsi_cpl }}</div>
                        <div class="absolute right-full top-1/2 -translate-y-1/2"><div class="border-8 border-transparent border-r-gray-900"></div></div>
                      </div>
                    </div>
                  </td>
                  @foreach (($mks ?? []) as $mk)
                    <td class="px-4 py-4 text-center border-r border-b border-gray-200">
                      <input type="checkbox" disabled
                        {{ isset($relasi[$mk->kode_mk]) && in_array($cpl->id_cpl, ($relasi[$mk->kode_mk]->pluck('id_cpl')->toArray() ?? [])) ? 'checked' : '' }}
                        class="h-6 w-6 mx-auto appearance-none rounded border-2 border-blue-500 bg-white checked:bg-blue-600 checked:border-blue-600 disabled:opacity-100 disabled:cursor-default relative transition-all duration-200">
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
