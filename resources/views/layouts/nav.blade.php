<!-- resources/views/layouts/nav.blade.php -->
<header class="header-nav">
    <h2>OBE System</h2>
    <nav>
        <ul class="nav-menu">
            <!-- Menu Umum (Dashboard) -->
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-home me-1"></i> <!-- Gunakan ikon jika diinginkan -->
                    Dashboard
                </a>
            </li>

            <!-- Menu berdasarkan Role -->
            @if(Auth::check())
                @php $userRole = Auth::user()->role; @endphp

                @if($userRole === 'admin')
                    <li>
                        <a href="{{ route('admin.manage.users') }}">
                            <i class="fas fa-users me-1"></i>
                            Kelola Akun
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.manage.prodi') }}">
                            <i class="fas fa-building me-1"></i>
                            Prodi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.manage.mahasiswa') }}">
                            <i class="fas fa-graduation-cap me-1"></i>
                            Mahasiswa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.manage.angkatan') }}">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Angkatan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.manage.matkul') }}">
                            <i class="fas fa-book me-1"></i>
                            Mata Kuliah
                        </a>
                    </li>
                @elseif($userRole === 'dosen')
                    <li>
                        <a href="{{ route('dosen.cpmk') }}">
                            <i class="fas fa-tasks me-1"></i>
                            CPMK
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dosen.input.nilai') }}">
                            <i class="fas fa-edit me-1"></i>
                            Input Nilai
                        </a>
                    </li>
                    <!-- Tambahkan menu lain untuk Dosen jika diperlukan -->
                @elseif($userRole === 'akademik')
                    <li>
                        <a href="{{ route('akademik.cpl') }}">
                            <i class="fas fa-list-ol me-1"></i>
                            CPL
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('akademik.cpmk') }}">
                            <i class="fas fa-tasks me-1"></i>
                            CPMK
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('akademik.mapping') }}">
                            <i class="fas fa-link me-1"></i>
                            Mapping
                        </a>
                    </li>
                @elseif($userRole === 'kaprodi')
                    <li>
                        <a href="{{ route('kaprodi.laporan.cpl.matakuliah') }}">
                            <i class="fas fa-chart-bar me-1"></i>
                            Laporan MK
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kaprodi.laporan.cpl.angkatan') }}">
                            <i class="fas fa-chart-line me-1"></i>
                            Laporan Angkatan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kaprodi.generate.rumusan') }}">
                            <i class="fas fa-file-alt me-1"></i>
                            Rumusan MK
                        </a>
                    </li>
                @elseif($userRole === 'wadir')
                    <li>
                        <a href="{{ route('wadir.laporan.cpl.lintasprodi') }}">
                            <i class="fas fa-chart-pie me-1"></i>
                            Laporan Lintas Prodi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('wadir.generate.laporan') }}">
                            <i class="fas fa-file-pdf me-1"></i>
                            Laporan Akademik
                        </a>
                    </li>
                @endif
            @endif
        </ul>
    </nav>
</header>