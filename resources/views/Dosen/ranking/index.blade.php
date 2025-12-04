@extends('layouts.dosen.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header (mirip Kaprodi Pemetaan) -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-trophy text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Ranking Mahasiswa (SAW)</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Lihat hasil perhitungan ranking mahasiswa program studi Anda berdasarkan session yang tersedia.
                    </p>
                </div>
            </div>
        </div>

        <!-- Kartu utama: Daftar Session Ranking -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <!-- Header kartu -->
            <div class="bg-blue-600 px-6 py-4 flex items-center justify-between text-white">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-500 flex items-center justify-center shadow">
                        <i class="fas fa-layer-group text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold">Daftar Session Ranking</h2>
                        <p class="text-xs text-blue-100">Pilih session untuk melihat rincian ranking mahasiswa.</p>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white">
                @if($sessions->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada data ranking</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada session ranking untuk prodi Anda.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gradient-to-r from-gray-700 to-gray-800 text-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Judul Session</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tahun Kurikulum</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Total Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tanggal Dibuat</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider w-40">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($sessions as $session)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $session->judul }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $session->tahun->nama_kurikulum ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $session->total_mahasiswa }} Mahasiswa
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $session->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <a href="{{ route('dosen.ranking.hasil', $session->id_session) }}" 
                                           class="inline-flex items-center px-4 py-2 text-xs font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Lihat Hasil
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $sessions->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
