<!-- resources/views/layouts/nav.blade.php -->
<header class="header-nav flex items-center justify-between px-4 py-2 bg-gray-900">
    <!-- Logo + Judul -->
    <div class="flex items-center space-x-2">
        <img src="{{ asset('images/politala-logo.png') }}" alt="Logo" class="logo-img w-7 h-7">
        <h2 class="text-white font-semibold text-base">Sistem OBE Politala</h2>
    </div>

    <!-- Navigation Menu + Profil -->
    <nav class="flex items-center space-x-4">
        <ul class="nav-menu flex space-x-3 text-sm">
            <!-- Menu Umum (Dashboard) -->
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center px-2 py-1 hover:text-yellow-400">
                    <i class="fas fa-home mr-1 text-xs"></i> Dashboard
                </a>
            </li>

            <!-- Menu berdasarkan Role -->
            @if (Auth::check())
                @php $userRole = Auth::user()->role; @endphp

                @if ($userRole === 'admin')
                    <li><a href="{{ route('admin.manage.users') }}"
                            class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-users mr-1 text-xs"></i> Akun</a></li>
                    <li><a href="{{ route('admin.manage.prodi') }}"
                            class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-building mr-1 text-xs"></i> Prodi</a></li>
                    <li><a href="{{ route('admin.manage.mahasiswa') }}"
                            class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-graduation-cap mr-1 text-xs"></i> Mhs</a></li>
                    <li><a href="{{ route('admin.manage.angkatan') }}"
                            class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-calendar-alt mr-1 text-xs"></i> Angkatan</a></li>
                    <li><a href="{{ route('admin.manage.matkul') }}"
                            class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-book mr-1 text-xs"></i> Mata Kuliah</a></li>
                    <li><a href="{{ route('admin.manage.matkul') }}"
                            class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-list-ol mr-1 text-xs"></i> CPL</a></li>
                    <li><a href="{{ route('admin.manage.matkul') }}"
                            class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-tasks mr-1 text-xs"></i> CPMK</a></li>
                @elseif($userRole === 'dosen')
                    <li><a href="#" class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-tasks mr-1 text-xs"></i> CPMK</a></li>
                    <li><a href="#" class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-edit mr-1 text-xs"></i> Input Nilai</a></li>
                @elseif($userRole === 'akademik')
                    <li><a href="{{ route('akademik.cpl') }}"
                            class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-list-ol mr-1 text-xs"></i> CPL</a></li>
                    <li><a href="{{ route('akademik.cpmk') }}"
                            class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-tasks mr-1 text-xs"></i> CPMK</a></li>
                    <li><a href="{{ route('akademik.mapping') }}"
                            class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-link mr-1 text-xs"></i> Mapping</a></li>
                @elseif($userRole === 'kaprodi')
                    <li><a href="{{ route('kaprodi.laporan.mk') }}"
                            class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-chart-bar mr-1 text-xs"></i> Laporan MK</a></li>
                    <li><a href="{{ route('kaprodi.laporan.angkatan') }}"
                            class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-chart-line mr-1 text-xs"></i> Laporan Angkatan</a></li>
                @elseif($userRole === 'wadir')
                    <li><a href="#" class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-chart-pie mr-1 text-xs"></i> Laporan Lintas Prodi</a></li>
                    <li><a href="#" class="flex items-center px-2 py-1 hover:text-yellow-400"><i
                                class="fas fa-file-pdf mr-1 text-xs"></i> Laporan Akademik</a></li>
                @endif
            @endif
        </ul>

    </nav>
</header>
