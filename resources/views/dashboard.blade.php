@extends('layouts.app')

@section('content')
    <div class="glass-card">
        <h1 class="mb-4">Dashboard</h1>
        <p>Selamat datang di Sistem Kalkulasi OBE, 
            <strong>{{ Auth::user()->name }}</strong>!</p>
        <p>Anda login sebagai: 
            <strong class="capitalize">{{ Auth::user()->role }}</strong></p>
    </div>

    <div class="mt-4 d-grid gap-3" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
        @if(Auth::user()->role === 'admin')
            <!-- Card untuk Admin -->
            <a href="{{ route('admin.manage.users') }}" class="glass-card-link"> <!-- Tambahkan link jika ada route -->
                <div class="glass-card">
                    <h3>Kelola Akun</h3>
                    <p>Tambah, edit, atau nonaktifkan akun pengguna.</p>
                </div>
            </a>
            <a href="{{ route('admin.manage.prodi') }}" class="glass-card-link">
                <div class="glass-card">
                    <h3>Kelola Prodi</h3>
                    <p>Tambah, edit, atau hapus data program studi.</p>
                </div>
            </a>
            <a href="{{ route('admin.manage.mahasiswa') }}" class="glass-card-link">
                <div class="glass-card">
                    <h3>Kelola Mahasiswa</h3>
                    <p>Tambah, edit, atau hapus data mahasiswa.</p>
                </div>
            </a>
            <a href="{{ route('admin.manage.angkatan') }}" class="glass-card-link">
                <div class="glass-card">
                    <h3>Kelola Angkatan</h3>
                    <p>Tambah, edit, atau hapus data angkatan.</p>
                </div>
            </a>
            <a href="{{ route('admin.manage.matkul') }}" class="glass-card-link">
                <div class="glass-card">
                    <h3>Kelola Mata Kuliah</h3>
                    <p>Tambah, edit, atau hapus data mata kuliah.</p>
                </div>
            </a>
        @elseif(Auth::user()->role === 'dosen')
            <!-- Card untuk Dosen -->
            <div class="glass-card">
                <h3>Kelola CPMK</h3>
                <p>Tentukan CPMK untuk mata kuliah yang diampu.</p>
            </div>
            <a href="#" class="glass-card-link"> <!-- Ganti dengan route yang benar nanti -->
                <div class="glass-card">
                    <h3>Input Nilai Mahasiswa</h3>
                    <p>Masukkan nilai berdasarkan komponen penilaian.</p>
                </div>
            </a>
            <div class="glass-card">
                <h3>Laporan Saya</h3>
                <p>Lihat ringkasan capaian dari mata kuliah yang diampu.</p>
            </div>
        @elseif(Auth::user()->role === 'akademik')
            <!-- Card untuk Akademik Prodi -->
            <a href="{{ route('akademik.cpl') }}" class="glass-card-link"> <!-- Ganti dengan route yang benar nanti -->
                <div class="glass-card">
                    <h3>Kelola CPL</h3>
                    <p>Tambah, edit, atau hapus Capaian Pembelajaran Lulusan.</p>
                </div>
            </a>
            <a href="{{ route('akademik.cpmk') }}" class="glass-card-link"> <!-- Ganti dengan route yang benar nanti -->
                <div class="glass-card">
                    <h3>Kelola CPMK</h3>
                    <p>Tambah, edit, atau hapus CPMK untuk mata kuliah.</p>
                </div>
            </a>
            <a href="{{ route('akademik.mapping') }}" class="glass-card-link"> <!-- Ganti dengan route yang benar nanti -->
                <div class="glass-card">
                    <h3>Mapping CPMK -> CPL</h3>
                    <p>Tentukan bobot kontribusi CPMK terhadap CPL.</p>
                </div>
            </a>
        @elseif(Auth::user()->role === 'kaprodi')
            <!-- Card untuk Kaprodi -->
            <a href="{{ route('kaprodi.laporan.mk') }}" class="glass-card-link"> <!-- Ganti dengan route yang benar nanti -->
                <div class="glass-card">
                    <h3>Laporan CPL per MK</h3>
                    <p>Lihat capaian CPL untuk setiap mata kuliah.</p>
                </div>
            </a>
            <a href="{{ route(name:'kaprodi.laporan.angkatan') }}" class="glass-card-link"> <!-- Ganti dengan route yang benar nanti -->
                <div class="glass-card">
                    <h3>Laporan CPL per Angkatan</h3>
                    <p>Lihat capaian CPL untuk setiap angkatan mahasiswa.</p>
                </div>
            </a>
        @elseif(Auth::user()->role === 'wadir')
            <!-- Card untuk Wadir I -->
            <a href="{{ route('wadir.laporan.cpl.lintasprodi') }}" class="glass-card-link"> <!-- Ganti dengan route yang benar nanti -->
                <div class="glass-card">
                    <h3>Laporan Agregat CPL</h3>
                    <p>Lihat ringkasan capaian CPL secara keseluruhan lintas program studi.</p>
                </div>
            </a>
            <a href="{{ route('wadir.generate.laporan') }}" class="glass-card-link"> <!-- Ganti dengan route yang benar nanti -->
                <div class="glass-card">
                    <h3>Generate Laporan Akademik</h3>
                    <p>Buat laporan akademik tingkat institusi.</p>
                </div>
            </a>
        @else
            <!-- Card default jika role tidak dikenali -->
            <div class="glass-card">
                <h3>Selamat Datang!</h3>
                <p>Role Anda saat ini: {{ Auth::user()->role }}. Fitur untuk role ini sedang dalam pengembangan.</p>
            </div>
        @endif
    </div>
@endsection