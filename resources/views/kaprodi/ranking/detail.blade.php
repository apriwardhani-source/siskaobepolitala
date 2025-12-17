@extends('layouts.kaprodi.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('kaprodi.ranking.hasil', $session->id_session) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium mb-3">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Kembali ke Ranking</span>
            </a>

            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Detail Perhitungan SAW</h1>
                    <p class="mt-2 text-sm text-gray-600">Breakdown perhitungan untuk mahasiswa {{ $detail['nim'] }}</p>
                </div>
            </div>
        </div>

        <!-- Mahasiswa Info -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-6">
            <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $detail['nama'] }}</h2>
                        <p class="text-sm text-gray-600">NIM: {{ $detail['nim'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Ranking</p>
                        <p class="text-4xl font-bold text-blue-600">{{ $detail['ranking'] }}</p>
                    </div>
                </div>
                <div class="mt-4 p-4 bg-white rounded-lg border border-blue-200">
                    <p class="text-sm text-gray-600">Total Skor SAW</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($detail['total_skor'], 6) }}</p>
                </div>
            </div>
        </div>

        <!-- Detail Perhitungan -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Breakdown Perhitungan per Kriteria</h2>
            </div>
            
            <div class="p-6 space-y-6">
                @foreach($detail['detail'] as $kode_mk => $data)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $data['nama_mk'] }}</h3>
                            <span class="inline-block mt-1 px-2 py-1 rounded text-xs font-semibold 
                                {{ $data['kompetensi'] == 'utama' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($data['kompetensi']) }} (Bobot: {{ $data['bobot_raw'] }})
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Skor Kriteria</p>
                            <p class="text-lg font-bold text-green-600">{{ number_format($data['skor_kriteria'], 6) }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500 text-xs">Nilai Asli</p>
                            <p class="font-semibold text-gray-900">{{ number_format($data['nilai_asli'], 2) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Nilai Max</p>
                            <p class="font-semibold text-gray-900">{{ number_format($data['nilai_max'], 2) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Normalized</p>
                            <p class="font-semibold text-gray-900">{{ number_format($data['normalized'], 6) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Bobot (%)</p>
                            <p class="font-semibold text-gray-900">{{ number_format($data['bobot_normalized'] * 100, 2) }}%</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 p-3 bg-gray-50 rounded text-xs text-gray-600">
                        <p class="font-mono">
                            Rumus: ({{ number_format($data['nilai_asli'], 2) }} / {{ number_format($data['nilai_max'], 2) }}) x {{ number_format($data['bobot_normalized'], 6) }} = 
                            <span class="font-bold text-green-600">{{ number_format($data['skor_kriteria'], 6) }}</span>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-t border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Total Skor SAW (Penjumlahan Semua Skor Kriteria):</p>
                        <p class="text-xs text-gray-500 mt-1">
                            @foreach($detail['detail'] as $idx => $data)
                                {{ number_format($data['skor_kriteria'], 6) }}{{ $loop->last ? '' : ' + ' }}
                            @endforeach
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-green-600">{{ number_format($detail['total_skor'], 6) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

