@extends('layouts.kaprodi.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header mirip Wadir1 -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Tahun Kurikulum</h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Ringkasan tahun ajaran dan kurikulum yang digunakan pada program studi Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu daftar tahun (read only) -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-between">
                <div>
                    <h2 class="text-lg md:text-xl font-semibold text-white">Daftar Tahun Kurikulum</h2>
                    <p class="mt-1 text-xs md:text-sm text-blue-100">
                        Ringkasan seluruh tahun kurikulum aktif yang dapat dipantau oleh Kaprodi.
                    </p>
                </div>
                <div class="hidden sm:flex items-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-medium text-blue-50 shadow-sm">
                        <i class="fas fa-layer-group mr-2 text-[11px]"></i>
                        {{ ($tahuns->count() ?? 0) }} Tahun
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                @if(($tahuns ?? collect())->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-16">No</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">Tahun</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Kurikulum</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @foreach ($tahuns as $index => $t)
                            <tr class="hover:bg-blue-50 transition-colors duration-150">
                                <td class="px-4 py-3 whitespace-nowrap text-center font-medium text-gray-800">
                                    {{ $tahuns->firstItem() ? $tahuns->firstItem() + $index : $index + 1 }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-sm">
                                        {{ $t->tahun }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-green-500 to-green-600 text-white shadow-sm">
                                        {{ $t->nama_kurikulum }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if(method_exists($tahuns, 'links') && $tahuns->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $tahuns->links() }}
                    </div>
                    @endif
                @else
                    <div class="px-6 py-16 text-center">
                        <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5A2 2 0 003 7v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Tidak Ada Data Tahun Kurikulum</h3>
                        <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                            Belum terdapat data tahun kurikulum yang dapat ditampilkan.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
