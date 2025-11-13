@extends('layouts.admin.app')

@section('title', 'Detail Hasil OBE')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <!-- Mahasiswa Info Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-6">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        @php
                            $colors = [
                                ['bg' => '#F44336', 'text' => '#FFFFFF'], // Red
                                ['bg' => '#E91E63', 'text' => '#FFFFFF'], // Pink
                                ['bg' => '#9C27B0', 'text' => '#FFFFFF'], // Purple
                                ['bg' => '#3F51B5', 'text' => '#FFFFFF'], // Indigo
                                ['bg' => '#2196F3', 'text' => '#FFFFFF'], // Blue
                                ['bg' => '#00BCD4', 'text' => '#FFFFFF'], // Cyan
                                ['bg' => '#4CAF50', 'text' => '#FFFFFF'], // Green
                                ['bg' => '#FF9800', 'text' => '#FFFFFF'], // Orange
                                ['bg' => '#795548', 'text' => '#FFFFFF'], // Brown
                            ];
                            $hash = 0;
                            for ($i = 0; $i < strlen($mahasiswa->nama_mahasiswa); $i++) {
                                $hash = ord($mahasiswa->nama_mahasiswa[$i]) + (($hash << 5) - $hash);
                            }
                            $colorIndex = abs($hash) % count($colors);
                            $avatarColor = $colors[$colorIndex];
                            
                            // Get initials
                            $words = explode(' ', trim($mahasiswa->nama_mahasiswa));
                            $initials = count($words) >= 2 
                                ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
                                : strtoupper(substr($mahasiswa->nama_mahasiswa, 0, 2));
                        @endphp
                        <div class="w-20 h-20 rounded-full flex items-center justify-center border-4 border-white/30 shadow-lg" 
                             style="background-color: {{ $avatarColor['bg'] }}; color: {{ $avatarColor['text'] }};">
                            <span class="font-bold text-2xl">{{ $initials }}</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-white mb-2">{{ $mahasiswa->nama_mahasiswa }}</h1>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                            <div class="flex items-center text-white/90">
                                <i class="fas fa-id-card mr-2"></i>
                                <span class="font-medium">NIM:</span>
                                <span class="ml-2">{{ $mahasiswa->nim }}</span>
                            </div>
                            <div class="flex items-center text-white/90">
                                <i class="fas fa-university mr-2"></i>
                                <span class="font-medium">Prodi:</span>
                                <span class="ml-2">{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</span>
                            </div>
                            <div class="flex items-center text-white/90">
                                <i class="fas fa-calendar mr-2"></i>
                                <span class="font-medium">Angkatan:</span>
                                <span class="ml-2">{{ $mahasiswa->tahun_kurikulum }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="hidden md:flex space-x-2">
                        <button onclick="window.print()" 
                                class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg backdrop-blur-sm border border-white/30 transition-all">
                            <i class="fas fa-print mr-2"></i>
                            Print
                        </button>
                        <button onclick="exportPDF()" 
                                class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg backdrop-blur-sm border border-white/30 transition-all">
                            <i class="fas fa-file-pdf mr-2"></i>
                            Export PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hasil OBE Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-chart-line mr-3"></i>
                    Hasil Capaian Pembelajaran per Mata Kuliah
                </h2>
            </div>

            @if($grouped_data->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r">
                                    Mata Kuliah
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-r">
                                    CPL
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-r">
                                    CPMK
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-r">
                                    Skor Maks
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Nilai Perkuliahan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($grouped_data as $mk_data)
                                @php
                                    $rowCount = $mk_data['details']->count();
                                    $firstRow = true;
                                @endphp
                                
                                @foreach($mk_data['details'] as $index => $detail)
                                <tr class="hover:bg-blue-50 transition-colors {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <!-- Mata Kuliah Column (Merged) -->
                                    @if($firstRow)
                                        <td rowspan="{{ $rowCount }}" class="px-4 py-4 border-r bg-blue-50/50">
                                            <div class="space-y-1">
                                                <div class="font-semibold text-gray-900 text-sm">
                                                    {{ $mk_data['kode_mk'] }}
                                                </div>
                                                <div class="text-xs text-gray-700 font-medium">
                                                    {{ $mk_data['nama_mk'] }}
                                                </div>
                                                <div class="flex items-center space-x-3 mt-2">
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                                        <i class="fas fa-layer-group mr-1"></i>
                                                        Semester {{ $mk_data['semester_mk'] }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                        <i class="fas fa-book mr-1"></i>
                                                        {{ $mk_data['sks_mk'] }} SKS
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        @php $firstRow = false; @endphp
                                    @endif

                                    <!-- CPL Column -->
                                    <td class="px-4 py-3 text-center border-r">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                                     {{ $detail['kode_cpl'] != '-' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $detail['kode_cpl'] }}
                                        </span>
                                    </td>

                                    <!-- CPMK Column -->
                                    <td class="px-4 py-3 text-center border-r">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                                     {{ $detail['kode_cpmk'] != '-' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $detail['kode_cpmk'] }}
                                        </span>
                                    </td>

                                    <!-- Skor Maks Column -->
                                    <td class="px-4 py-3 text-center border-r">
                                        <span class="font-semibold text-gray-900">
                                            {{ number_format($detail['skor_maks'], 0) }}
                                        </span>
                                    </td>

                                    <!-- Nilai Perkuliahan Column -->
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $nilai = $detail['nilai_perkuliahan'];
                                            $skor_maks = $detail['skor_maks'];
                                            $persentase = $skor_maks > 0 ? ($nilai / $skor_maks * 100) : 0;
                                            
                                            if ($persentase >= 80) {
                                                $colorClass = 'bg-green-100 text-green-800 border-green-300';
                                                $icon = 'fa-check-circle';
                                            } elseif ($persentase >= 60) {
                                                $colorClass = 'bg-yellow-100 text-yellow-800 border-yellow-300';
                                                $icon = 'fa-exclamation-circle';
                                            } else {
                                                $colorClass = 'bg-red-100 text-red-800 border-red-300';
                                                $icon = 'fa-times-circle';
                                            }
                                        @endphp
                                        
                                        @if($nilai > 0)
                                            <div class="inline-flex flex-col items-center">
                                                <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold border {{ $colorClass }}">
                                                    <i class="fas {{ $icon }} mr-2"></i>
                                                    {{ number_format($nilai, 1) }}
                                                </span>
                                                <span class="text-xs text-gray-500 mt-1">
                                                    ({{ number_format($persentase, 0) }}%)
                                                </span>
                                            </div>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-400 border border-gray-200">
                                                <i class="fas fa-minus mr-1"></i>
                                                Belum dinilai
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Summary Stats -->
                <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $grouped_data->count() }}</div>
                            <div class="text-xs text-gray-600 uppercase">Total Mata Kuliah</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $grouped_data->sum(fn($mk) => $mk['sks_mk']) }}</div>
                            <div class="text-xs text-gray-600 uppercase">Total SKS</div>
                        </div>
                        <div class="text-center">
                            @php
                                $total_details = $grouped_data->sum(fn($mk) => $mk['details']->count());
                            @endphp
                            <div class="text-2xl font-bold text-gray-900">{{ $total_details }}</div>
                            <div class="text-xs text-gray-600 uppercase">Total Penilaian</div>
                        </div>
                        <div class="text-center">
                            @php
                                $all_details = $grouped_data->flatMap(fn($mk) => $mk['details']);
                                $completed = $all_details->where('nilai_perkuliahan', '>', 0)->count();
                                $percentage = $total_details > 0 ? round(($completed / $total_details) * 100) : 0;
                            @endphp
                            <div class="text-2xl font-bold text-gray-900">{{ $percentage }}%</div>
                            <div class="text-xs text-gray-600 uppercase">Capaian</div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="px-6 py-16 text-center">
                    <i class="fas fa-chart-line text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Data Nilai</h3>
                    <p class="text-sm text-gray-500">
                        Mahasiswa ini belum memiliki data nilai OBE.
                    </p>
                </div>
            @endif
        </div>

    </div>
</div>

@push('scripts')
<script>
function exportPDF() {
    alert('Fitur export PDF akan segera tersedia!');
    // Implementasi export PDF bisa menggunakan library seperti jsPDF atau server-side PDF generator
}

// Print styling
window.onbeforeprint = function() {
    document.body.classList.add('printing');
};

window.onafterprint = function() {
    document.body.classList.remove('printing');
};
</script>

<style>
@media print {
    body {
        background: white;
    }
    .no-print {
        display: none !important;
    }
    table {
        page-break-inside: auto;
    }
    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
}
</style>
@endpush

@endsection
