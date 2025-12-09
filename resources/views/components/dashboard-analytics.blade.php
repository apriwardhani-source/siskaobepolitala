<div class="dashboard-analytics">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Mahasiswa</h5>
                    <h2 id="stat-mahasiswa">-</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Mata Kuliah</h5>
                    <h2 id="stat-matakuliah">-</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total CPL</h5>
                    <h2 id="stat-cpl">-</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Rata-rata Nilai</h5>
                    <h2 id="stat-nilai">-</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Distribusi Nilai Mahasiswa</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartDistribusiNilai"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Pencapaian CPL</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartPencapaianCPL"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Trend Nilai Per Semester</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartTrendSemester"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 3 -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5>Top 5 Mata Kuliah Terbaik</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartTopMK"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5>5 Mata Kuliah Perlu Perbaikan</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartBottomMK"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch analytics data
    fetch('/api/dashboard/analytics?kode_prodi={{ Auth::user()->kode_prodi ?? "" }}')
        .then(response => response.json())
        .then(data => {
            // Update statistics cards
            document.getElementById('stat-mahasiswa').textContent = data.totalMahasiswa;
            document.getElementById('stat-matakuliah').textContent = data.totalMataKuliah;
            document.getElementById('stat-cpl').textContent = data.totalCPL;
            document.getElementById('stat-nilai').textContent = data.rataRataNilai;

            // Chart 1: Distribusi Nilai (Bar Chart)
            new Chart(document.getElementById('chartDistribusiNilai'), {
                type: 'bar',
                data: {
                    labels: data.distribusiNilai.labels,
                    datasets: [{
                        label: 'Jumlah Mahasiswa',
                        data: data.distribusiNilai.data,
                        backgroundColor: [
                            '#4CAF50', '#8BC34A', '#CDDC39',
                            '#FFEB3B', '#FFC107', '#FF9800',
                            '#FF5722', '#F44336', '#E91E63'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart 2: Pencapaian CPL (Radar Chart)
            new Chart(document.getElementById('chartPencapaianCPL'), {
                type: 'radar',
                data: {
                    labels: data.pencapaianCPL.labels,
                    datasets: [{
                        label: 'Skor CPL',
                        data: data.pencapaianCPL.data,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        r: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });

            // Chart 3: Trend Semester (Line Chart)
            new Chart(document.getElementById('chartTrendSemester'), {
                type: 'line',
                data: {
                    labels: data.trendSemester.labels,
                    datasets: [{
                        label: 'Rata-rata Nilai',
                        data: data.trendSemester.data,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });

            // Chart 4: Top MK (Horizontal Bar)
            new Chart(document.getElementById('chartTopMK'), {
                type: 'bar',
                data: {
                    labels: data.topMataKuliah.labels,
                    datasets: [{
                        label: 'Rata-rata Nilai',
                        data: data.topMataKuliah.data,
                        backgroundColor: '#4CAF50'
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });

            // Chart 5: Bottom MK (Horizontal Bar)
            new Chart(document.getElementById('chartBottomMK'), {
                type: 'bar',
                data: {
                    labels: data.bottomMataKuliah.labels,
                    datasets: [{
                        label: 'Rata-rata Nilai',
                        data: data.bottomMataKuliah.data,
                        backgroundColor: '#F44336'
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error loading analytics:', error));
});
</script>

<style>
.dashboard-analytics .card {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.dashboard-analytics .card-body h2 {
    font-size: 2.5rem;
    font-weight: bold;
    margin: 0;
}

.dashboard-analytics canvas {
    max-height: 300px;
}
</style>
