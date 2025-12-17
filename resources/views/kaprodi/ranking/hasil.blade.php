@extends('layouts.kaprodi.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <!-- Tombol kembali full-width di atas -->
            <a href="{{ route('kaprodi.ranking.index') }}"
               class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium mb-3">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Kembali ke Pengaturan Ranking</span>
            </a>

            <!-- Logo + judul + info + tombol export -->
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-trophy text-white text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                            {{ $session->judul }}
                        </h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Total {{ $session->total_mahasiswa }} mahasiswa &bull;
                            {{ $kriteria->count() }} kriteria &bull;
                            Diupload {{ $session->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('kaprodi.ranking.export', $session->id_session) }}" 
                       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 inline-flex items-center text-sm font-semibold shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 10v6m0 0l-3-3m3 3 3-3m2 8H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414A1 1 0 0 1 19 9.414V19a2 2 0 0 1-2 2z" />
                        </svg>
                        Export Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                          clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium text-blue-900">Kriteria yang Digunakan:</p>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach($kriteria as $mk)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                {{ $mk->kompetensi_mk == 'utama' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $mk->nama_mk }} 
                                <span class="ml-1 text-[10px] opacity-75">({{ ucfirst($mk->kompetensi_mk) }})</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Ranking Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Hasil Ranking</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-600 to-indigo-600">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase w-24">Rank</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase">NIM</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase">Nama Mahasiswa</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase">Skor SAW</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($rankings as $rank)
                        <tr class="hover:bg-blue-50 transition-colors {{ $rank->ranking <= 3 ? 'bg-yellow-50' : '' }}">
                            <td class="px-6 py-4 text-center">
                                @if($rank->ranking == 1)
                                    <span class="relative inline-flex items-center justify-center w-10 h-10 text-yellow-400 leading-none mx-auto">
                                        <i class="fas fa-crown text-3xl"></i>
                                        <span class="absolute inset-0 flex items-center justify-center text-sm font-bold text-white leading-none">
                                            1
                                        </span>
                                    </span>
                                @elseif($rank->ranking == 2)
                                    <span class="relative inline-flex items-center justify-center w-10 h-10 text-gray-400 leading-none mx-auto">
                                        <i class="fas fa-crown text-3xl"></i>
                                        <span class="absolute inset-0 flex items-center justify-center text-sm font-bold text-white leading-none">
                                            2
                                        </span>
                                    </span>
                                @elseif($rank->ranking == 3)
                                    <span class="relative inline-flex items-center justify-center w-10 h-10 text-amber-500 leading-none mx-auto">
                                        <i class="fas fa-crown text-3xl"></i>
                                        <span class="absolute inset-0 flex items-center justify-center text-sm font-bold text-white leading-none">
                                            3
                                        </span>
                                    </span>
                                @else
                                    <span class="font-semibold text-gray-700">
                                        {{ $rank->ranking }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $rank->nim }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $rank->nama_mahasiswa }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-gradient-to-r from-green-500 to-green-600 text-white shadow-sm">
                                    {{ number_format($rank->total_skor, 4) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('kaprodi.ranking.detail', [$session->id_session, $rank->nim]) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg shadow-sm transition-all duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S3.732 16.057 2.458 12z" />
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $rankings->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
