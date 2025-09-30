@extends('layouts.app')

@section('content')
<div class="container">
    <div class="glass-card mb-4">
        <h2 class="fw-bold">📊 Laporan CPL per Angkatan</h2>
        <p class="text-light">Lihat capaian CPL mahasiswa berdasarkan tahun angkatan, prodi, dan semester.</p>
    </div>

    {{-- Form filter --}}
    <div class="glass-card mb-4">
        <form method="GET" action="{{ route('kaprodi.laporan.angkatan') }}">
            <div class="row g-3">
                {{-- Pilih Prodi --}}
                <div class="col-md-4">
                    <label class="form-label text-light">Pilih Prodi</label>
                    <select id="prodi" name="prodi" class="form-select select2" required>
                        <option value="">-- Pilih Prodi --</option>
                        <option value="TI" {{ request('prodi') == 'TI' ? 'selected' : '' }}>Teknologi Informasi</option>
                        <option value="SI" {{ request('prodi') == 'SI' ? 'selected' : '' }}>Sistem Informasi</option>
                    </select>
                </div>

                {{-- Pilih Semester --}}
                <div class="col-md-4">
                    <label class="form-label text-light">Semester / Tahun Ajaran</label>
                    <select name="tahun_ajaran" class="form-select select2" required>
                        <option value="">-- Pilih --</option>
                        <option value="2024/2025 - Ganjil" {{ request('tahun_ajaran') == '2024/2025 - Ganjil' ? 'selected' : '' }}>2024/2025 - Ganjil</option>
                        <option value="2024/2025 - Genap" {{ request('tahun_ajaran') == '2024/2025 - Genap' ? 'selected' : '' }}>2024/2025 - Genap</option>
                    </select>
                </div>

                {{-- Pilih Angkatan --}}
                <div class="col-md-4">
                    <label class="form-label text-light">Pilih Angkatan</label>
                    <select name="angkatan" class="form-select select2" required>
                        <option value="">-- Pilih Angkatan --</option>
                        <option value="2024" {{ request('angkatan') == '2024' ? 'selected' : '' }}>2024</option>
                        <option value="2025" {{ request('angkatan') == '2025' ? 'selected' : '' }}>2025</option>
                        <option value="2026" {{ request('angkatan') == '2026' ? 'selected' : '' }}>2026</option>
                    </select>
                </div>
            </div>

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-light">
                    <i class="fa fa-search"></i> Generate Laporan
                </button>
            </div>
        </form>
    </div>

    {{-- Hasil laporan --}}
    @if(isset($laporan))
    <div class="glass-card mb-4">
        <h4 class="fw-bold">📑 Ringkasan Angkatan {{ request('angkatan') }}</h4>
        <p class="text-light">Rekap capaian CPL mahasiswa angkatan {{ request('angkatan') }} (Prodi {{ request('prodi') }}, {{ request('tahun_ajaran') }}).</p>

        {{-- Tabel ringkasan --}}
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Jumlah Mahasiswa</th>
                        <th>Rata-rata Nilai CPL</th>
                        <th>% Tercapai</th>
                        <th>% Belum Tercapai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $laporan['jumlah_mhs'] ?? 0 }}</td>
                        <td>{{ $laporan['rata_cpl'] ?? '-' }}</td>
                        <td>{{ $laporan['persen_tercapai'] ?? 0 }}%</td>
                        <td>{{ $laporan['persen_belum'] ?? 0 }}%</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Tabel detail per mahasiswa --}}
        @if(isset($laporan['detail']))
        <div class="table-responsive mb-4">
            <h5 class="fw-bold text-light">📌 Rumusan Akhir CPL per Mahasiswa</h5>
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <th>CPL</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporan['detail'] as $row)
                    <tr>
                        <td>{{ $row['nama'] }}</td>
                        <td>{{ $row['cpl'] }}</td>
                        <td>
                            <span class="badge {{ $row['status'] == 'Tercapai' ? 'bg-success' : 'bg-danger' }}">
                                {{ $row['status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- Grafik capaian --}}
        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="fw-bold text-light mb-0">Grafik Capaian Angkatan</h5>
                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-light" onclick="showChart('bar')"><i class="fa fa-chart-bar"></i></button>
                    <button class="btn btn-sm btn-outline-light" onclick="showChart('pie')"><i class="fa fa-chart-pie"></i></button>
                    <button class="btn btn-sm btn-outline-light" onclick="showChart('line')"><i class="fa fa-chart-line"></i></button>
                </div>
            </div>
            <canvas id="grafikAngkatan" style="max-height:400px"></canvas>
        </div>
    </div>

    {{-- Export --}}
    <div class="glass-card text-center">
        <h5 class="fw-bold mb-3">Ekspor Laporan</h5>
        <a href="{{ route('kaprodi.laporan.angkatan.export', ['format'=>'pdf']) }}" class="btn btn-danger me-2">
            <i class="fa fa-file-pdf"></i> PDF
        </a>
        <a href="{{ route('kaprodi.laporan.angkatan.export', ['format'=>'csv']) }}" class="btn btn-success">
            <i class="fa fa-file-csv"></i> CSV
        </a>
    </div>
    @endif
</div>

{{-- Select2 + jQuery --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    $('.select2').select2({ placeholder: "Cari...", allowClear: true, width: '100%' });
});

@if(isset($grafik))
    let chartInstance;
    function renderChart(type) {
        const ctx = document.getElementById('grafikAngkatan').getContext('2d');
        if(chartInstance) chartInstance.destroy();

        chartInstance = new Chart(ctx, {
            type: type,
            data: {
                labels: @json($grafik['labels']),
                datasets: [{
                    label: 'Jumlah Mahasiswa',
                    data: @json($grafik['data']),
                    backgroundColor: ['#36A2EB','#FF6384','#4BC0C0','#FFCE56'],
                    borderWidth: 1,
                    fill: type === 'line' ? false : true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: { display: true, text: `Grafik Capaian Angkatan (${type.toUpperCase()})`, color: '#fff' },
                    legend: { labels: { color: '#fff' } }
                },
                scales: (type === 'bar' || type === 'line') ? {
                    y: { beginAtZero: true, ticks: { color: '#fff' }, title: { display: true, text: 'Jumlah Mahasiswa', color: '#fff' } },
                    x: { ticks: { color: '#fff' }, title: { display: true, text: 'CPL', color: '#fff' } }
                } : {}
            }
        });
    }
    renderChart('bar');
    function showChart(type) { renderChart(type); }
@endif
</script>
@endsection
