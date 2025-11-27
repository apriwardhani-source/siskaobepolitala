@extends('layouts.wadir1.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('wadir1.ranking.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium mb-2 inline-block">
                        ← Kembali
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $session->judul }}</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Total {{ $session->total_mahasiswa }} mahasiswa •
                        {{ $kriteria->count() }} kriteria •
                        Diupload {{ $session->created_at->diffForHumans() }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('wadir1.ranking.export', $session->id_session) }}" 
                       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
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
                    <thead class="bg-blue-600">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase w-20">Rank</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase">NIM</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase">Nama Mahasiswa</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase">Skor SAW</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($rankings as $rank)
                        <tr class="hover:bg-blue-50 transition-colors 
                            {{ $rank->ranking <= 3 ? 'bg-yellow-50' : '' }}">
                            <td class="px-6 py-4">
                                @if($rank->ranking == 1)
                                    <div class="flex items-center">
                                        <span class="text-2xl">🥇</span>
                                        <span class="ml-2 font-bold text-lg text-yellow-600">1</span>
                                    </div>
                                @elseif($rank->ranking == 2)
                                    <div class="flex items-center">
                                        <span class="text-2xl">🥈</span>
                                        <span class="ml-2 font-bold text-lg text-gray-500">2</span>
                                    </div>
                                @elseif($rank->ranking == 3)
                                    <div class="flex items-center">
                                        <span class="text-2xl">🥉</span>
                                        <span class="ml-2 font-bold text-lg text-orange-600">3</span>
                                    </div>
                                @else
                                    <span class="font-semibold text-gray-700">{{ $rank->ranking }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $rank->nim }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $rank->nama_mahasiswa }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-green-500 text-white shadow-sm">
                                    {{ number_format($rank->total_skor, 4) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('wadir1.ranking.detail', [$session->id_session, $rank->nim]) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                    Detail →
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
