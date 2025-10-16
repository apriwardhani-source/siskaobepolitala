@extends('layouts.tim.app')

@section('title', 'Dashboard')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard Kurikulum OBE</h1>
            <p class="mt-2 text-sm text-gray-600">Progress implementasi kurikulum berbasis Outcome-Based Education untuk Program Studi Anda</p>
        </div>

        <!-- Toolbar -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                
                <!-- Export Section -->
                <form id="exportForm" action="{{ route('tim.export.excel') }}" method="GET" class="flex-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="lg:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Export</label>
                            <select name="id_tahun" id="tahunSelect" required
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg 
                                       focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="" disabled {{ empty($id_tahun) ? 'selected' : '' }}>Pilih Tahun</option>
                                @foreach ($availableYears as $th)
                                    <option value="{{ $th->id_tahun }}" {{ $id_tahun == $th->id_tahun ? 'selected' : '' }}>
                                        {{ $th->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="lg:col-span-2 flex items-end gap-3">
                            <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 
                                       text-white font-medium rounded-lg shadow-sm hover:shadow-md 
                                       transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <i class="fas fa-file-excel mr-2"></i>
                                Export Excel
                            </button>

                            <button type="button" onclick="exportWord()"
                                class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 
                                       text-white font-medium rounded-lg shadow-sm hover:shadow-md 
                                       transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <i class="fas fa-file-word mr-2"></i>
                                Export Word
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Year Filter for Chart -->
                <form method="GET" action="{{ route('tim.dashboard') }}" class="lg:w-80">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Grafik</label>
                        <div class="flex gap-3">
                            <select name="tahun_progress" required
                                class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg 
                                       focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="" disabled selected>Pilih Tahun</option>
                                @foreach ($availableYears as $th)
                                    <option value="{{ $th->id_tahun }}" {{ request('tahun_progress') == $th->id_tahun ? 'selected' : '' }}>
                                        {{ $th->tahun }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium 
                                       rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Progress Chart -->
        @if (request()->filled('tahun_progress'))
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-5">
                    <h2 class="text-xl font-bold text-white">Grafik Progress Kurikulum OBE</h2>
                    <p class="mt-1 text-sm text-gray-300">Visualisasi progress per komponen kurikulum</p>
                </div>

                <div class="p-6">
                    <!-- Target Info Box -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-5 mb-6">
                        <h4 class="font-semibold text-blue-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Target Standar Kurikulum OBE
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-blue-600">9</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">CPL</div>
                                <div class="text-xs text-gray-500">Capaian Profil Lulusan</div>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-blue-600">144</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">Total SKS</div>
                                <div class="text-xs text-gray-500">Mata Kuliah (D4)</div>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-blue-600">20</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">CPMK</div>
                                <div class="text-xs text-gray-500">Capaian Pembelajaran MK</div>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <div class="text-2xl font-bold text-blue-600">40</div>
                                <div class="text-xs font-medium text-gray-600 mt-1">Sub CPMK</div>
                                <div class="text-xs text-gray-500">Indikator Pencapaian</div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Container -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="w-full" style="height: 400px;">
                            <canvas id="progressChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">Pilih Tahun Grafik</h3>
                <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                    Silakan pilih tahun kurikulum di atas untuk menampilkan visualisasi progress implementasi OBE.
                </p>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if (request()->filled('tahun_progress'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const prodis = {!! json_encode($prodis) !!};

    const labels = prodis.map(prodi => prodi.nama_prodi);
    const datasets = [
        {
            label: 'CPL',
            data: prodis.map(prodi => prodi.progress_cpl || 0),
            backgroundColor: 'rgba(59, 130, 246, 0.7)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 2,
            borderRadius: 6
        },
        {
            label: 'Total SKS',
            data: prodis.map(prodi => prodi.progress_sks_mk || 0),
            backgroundColor: 'rgba(251, 191, 36, 0.7)',
            borderColor: 'rgba(251, 191, 36, 1)',
            borderWidth: 2,
            borderRadius: 6
        },
        {
            label: 'CPMK',
            data: prodis.map(prodi => prodi.progress_cpmk || 0),
            backgroundColor: 'rgba(249, 115, 22, 0.7)',
            borderColor: 'rgba(249, 115, 22, 1)',
            borderWidth: 2,
            borderRadius: 6
        },
        {
            label: 'Sub CPMK',
            data: prodis.map(prodi => prodi.progress_subcpmk || 0),
            backgroundColor: 'rgba(239, 68, 68, 0.7)',
            borderColor: 'rgba(239, 68, 68, 1)',
            borderWidth: 2,
            borderRadius: 6
        }
    ];

    const ctx = document.getElementById('progressChart').getContext('2d');
    const progressChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: false,
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11,
                            weight: '500'
                        }
                    }
                },
                y: {
                    stacked: false,
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        },
                        font: {
                            size: 11
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 13,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 12
                    },
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw + '%';
                        }
                    }
                },
                legend: {
                    position: 'top',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            }
        }
    });
});

function exportWord() {
    event.preventDefault();
    
    const form = document.getElementById('exportForm');
    const tahun = form.querySelector('select[name="id_tahun"]').value;

    if (!tahun) {
        alert('Harap pilih Tahun terlebih dahulu.');
        return;
    }

    const url = `{{ url('/export/kpt') }}?id_tahun=${tahun}`;
    window.open(url, '_blank');
}
</script>
@endif
@endpush

@endsection
