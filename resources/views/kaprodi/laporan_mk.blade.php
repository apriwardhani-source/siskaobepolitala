@extends('layouts.app')

@section('content')
<div class="container">
    <div class="glass-card mb-4">
        <h2 class="fw-bold">📊 Laporan CPL per Mata Kuliah</h2>
        <p class="text-light">Lihat <b>Rumusan Akhir</b> capaian CPL berdasarkan hasil CPMK mahasiswa untuk mata kuliah tertentu.</p>
    </div>

    {{-- Form filter --}}
    <div class="glass-card mb-4">
        <form method="GET" action="{{ route('kaprodi.laporan.mk') }}">
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

                {{-- Semester / Tahun Ajaran --}}
                <div class="col-md-4">
                    <label class="form-label text-light">Semester / Tahun Ajaran</label>
                    <select name="tahun_ajaran" class="form-select select2" required>
                        <option value="">-- Pilih --</option>
                        <option value="2024/2025 - Ganjil" {{ request('tahun_ajaran') == '2024/2025 - Ganjil' ? 'selected' : '' }}>2024/2025 - Ganjil</option>
                        <option value="2024/2025 - Genap" {{ request('tahun_ajaran') == '2024/2025 - Genap' ? 'selected' : '' }}>2024/2025 - Genap</option>
                    </select>
                </div>

                {{-- Mata Kuliah --}}
                <div class="col-md-4">
                    <label class="form-label text-light">Mata Kuliah</label>
                    <select id="matkul" name="matkul" class="form-select select2" required>
                        <option value="">-- Pilih Mata Kuliah --</option>
                        {{-- Akan diisi via JS --}}
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
        <h4 class="fw-bold">📑 Rumusan Akhir Mata Kuliah {{ request('matkul') }}</h4>
        <p class="text-light">Rekap hasil CPMK → CPL mahasiswa untuk mata kuliah yang dipilih.</p>

        {{-- Tabel rekap CPMK -> CPL --}}
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Mahasiswa</th>
                        <th>CPMK</th>
                        <th>CPL</th>
                        <th>Status Capaian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporan as $row)
                    <tr>
                        <td>{{ $row->mahasiswa }}</td>
                        <td>{{ $row->cpmk }}</td>
                        <td>{{ $row->cpl }}</td>
                        <td>
                            <span class="badge {{ $row->status == 'Tercapai' ? 'bg-success' : 'bg-danger' }}">
                                {{ $row->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Grafik capaian --}}
        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="fw-bold text-light mb-0">Grafik Capaian CPL dari CPMK</h5>
                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-light" onclick="showChart('bar')"><i class="fa fa-chart-bar"></i></button>
                    <button class="btn btn-sm btn-outline-light" onclick="showChart('pie')"><i class="fa fa-chart-pie"></i></button>
                    <button class="btn btn-sm btn-outline-light" onclick="showChart('line')"><i class="fa fa-chart-line"></i></button>
                </div>
            </div>
            <canvas id="grafikCPL" style="max-height:400px"></canvas>
        </div>
    </div>

    {{-- Export --}}
    <div class="glass-card text-center">
        <h5 class="fw-bold mb-3">Ekspor Laporan</h5>
        <a href="{{ route('kaprodi.laporan.mk.export', ['format'=>'pdf']) }}" class="btn btn-danger me-2">
            <i class="fa fa-file-pdf"></i> PDF
        </a>
        <a href="{{ route('kaprodi.laporan.mk.export', ['format'=>'csv']) }}" class="btn btn-success">
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

    const matkulData = {
        "TI": [
            {id: "PWL", text: "Pemrograman Web Lanjut"},
            {id: "Jaringan", text: "Jaringan Komputer"},
            {id: "BasisData", text: "Basis Data"}
        ],
        "SI": [
            {id: "AnalisisSI", text: "Analisis Sistem Informasi"},
            {id: "ERP", text: "Enterprise Resource Planning"},
            {id: "ManajemenData", text: "Manajemen Data"}
        ]
    };

    $('#prodi').on('change', function() {
        const prodi = $(this).val();
        const $matkul = $('#matkul');
        $matkul.empty().append('<option value="">-- Pilih Mata Kuliah --</option>');
        if (matkulData[prodi]) {
            matkulData[prodi].forEach(item => {
                $matkul.append(new Option(item.text, item.id));
            });
        }
        $matkul.trigger('change');
    });
});

@if(isset($grafik))
    let chartInstance;
    function renderChart(type) {
        const ctx = document.getElementById('grafikCPL').getContext('2d');
        if(chartInstance) chartInstance.destroy();

        chartInstance = new Chart(ctx, {
            type: type,
            data: {
                labels: @json($grafik['labels']),
                datasets: [{
                    label: 'Jumlah Mahasiswa',
                    data: @json($grafik['data']),
                    backgroundColor: ['#36A2EB','#FF6384','#4BC0C0','#FFCE56'],
                    borderColor: ['#36A2EB','#FF6384','#4BC0C0','#FFCE56'],
                    borderWidth: 1,
                    fill: type === 'line' ? false : true,
                    tension: type === 'line' ? 0.3 : 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: { display: true, text: `Grafik Capaian CPL (${type.toUpperCase()})`, color: '#fff' },
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
