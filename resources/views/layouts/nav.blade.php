<!-- resources/views/layouts/nav.blade.php -->
<header class="header-nav flex items-center justify-between px-4 py-2">
    <!-- Logo + Judul -->
    <div class="flex items-center space-x-2">
        <img src="{{ asset('images/politala-logo.png') }}" alt="Logo" class="logo-img">
        <h2 class="text-white font-bold text-lg">Sistem OBE Politala</h2>
    </div>



    <!-- Navigation Menu -->
    <nav>
        <ul class="nav-menu flex space-x-4">
            <!-- Menu Umum (Dashboard) -->
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-home me-1"></i>
                    Dashboard
                </a>
            </li>

            <!-- Menu berdasarkan Role -->
            @if (Auth::check())
                @php $userRole = Auth::user()->role; @endphp

                @if ($userRole === 'admin')
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
                    <li>
                        <a href="{{ route('admin.manage.matkul') }}">
                            <i class="fas fa-list-ol me-1"></i>
                            CPL
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.manage.matkul') }}">
                            <i class="fas fa-tasks me-1"></i>
                            CPMK
                        </a>
                    </li>
                @elseif($userRole === 'dosen')
                    <li>
                        <a href="#">
                            <i class="fas fa-tasks me-1"></i>
                            CPMK
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-edit me-1"></i>
                            Input Nilai
                        </a>
                    </li>
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
                        <a href="{{ route(name:'kaprodi.laporan.mk') }}">
                            <i class="fas fa-chart-bar me-1"></i>
                            Laporan MK
                        </a>
                    </li>
                    <li>
                        <a href="{{ route(name:'kaprodi.laporan.angkatan') }}">
                            <i class="fas fa-chart-line me-1"></i>
                            Laporan Angkatan
                        </a>
                    </li>
                @elseif($userRole === 'wadir')
                    <li>
                        <a href="#">
                            <i class="fas fa-chart-pie me-1"></i>
                            Laporan Lintas Prodi
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-file-pdf me-1"></i>
                            Laporan Akademik
                        </a>
                    </li>
                @endif
            @endif
        </ul>
    </nav>
</header>
