@php
    $user = auth()->user();
    $role = $user->role ?? 'guest';
    $routePrefix = $role;
    
    // Role labels
    $roleLabels = [
        'admin' => 'Admin',
        'wadir1' => 'Wadir 1',
        'kaprodi' => 'Kaprodi',
        'tim' => 'Admin Prodi',
        'dosen' => 'Dosen',
    ];
    $roleLabel = $roleLabels[$role] ?? ucfirst($role);
    
    // Permissions per role
    $canManageUsers = $role === 'admin';
    $canManageMahasiswa = $role === 'tim';
    $canSeePengaturan = in_array($role, ['admin', 'tim', 'kaprodi', 'wadir1']);
    $canSeeCapaian = in_array($role, ['admin', 'tim', 'kaprodi', 'wadir1']);
    $canSeeKurikulum = in_array($role, ['admin', 'tim', 'kaprodi', 'wadir1']);
    $canSeePemetaan = in_array($role, ['admin', 'tim', 'kaprodi', 'wadir1']);
    $canSeePenilaian = $role === 'dosen';
    $canSeeLaporan = in_array($role, ['admin', 'tim', 'kaprodi', 'wadir1', 'dosen']);
    $canSeeHasilOBE = in_array($role, ['admin', 'wadir1', 'kaprodi']);
@endphp

<!-- Navbar -->
<nav class="bg-gradient-to-r from-[#1e3c72] to-[#2a5298] text-white fixed top-0 left-0 w-full z-50 shadow-lg">
    <!-- Top Bar -->
    <div class="px-6 py-4 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/logo-politala.png') }}" alt="Logo Politala" class="h-12 w-auto">
            <span class="font-bold text-xl uppercase">Politala OBE - {{ $roleLabel }}</span>
        </div>
        
        <!-- Mobile Menu Button -->
        <button onclick="toggleMobileMenu()" class="md:hidden text-white">
            <i class="bi bi-list text-3xl"></i>
        </button>
        
        <!-- User Menu (Desktop) -->
        <div class="hidden md:flex items-center space-x-4">
            <span class="font-medium text-lg">{{ $user->name }}</span>
            <div class="relative">
                <button onclick="toggleDropdownProfil()" class="flex items-center focus:outline-none">
                    <i class="bi bi-person-circle text-white text-2xl"></i>
                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414L10 13.414 5.293 8.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <div id="userDropdown" class="absolute right-0 mt-2 bg-white text-black rounded-md shadow-lg py-2 w-48 z-50" style="display: none;">
                    @if($canManageUsers)
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-th-large mr-2 text-purple-600"></i>
                        <span>Dashboard Pengaturan</span>
                    </a>
                    @endif
                    <a href="{{ route('settings.profile') }}" class="flex items-center px-4 py-2 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-user-circle mr-2 text-blue-600"></i>
                        <span>Profil Saya</span>
                    </a>
                    <div class="border-t border-gray-200 my-1"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-2 hover:bg-gray-100 text-red-600 text-left">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Menu Bar (Desktop) -->
    <div class="hidden md:flex bg-[#1a2f5c] px-6 py-2 space-x-1">
        <!-- Beranda (All Roles) -->
        <a href="{{ route($routePrefix . '.dashboard') }}" class="px-4 py-2 hover:bg-[#2a5298] rounded transition-colors duration-200">
            <i class="bi bi-house-door mr-2"></i>Beranda
        </a>

        @if($canSeePengaturan)
        <!-- Pengaturan -->
        <div class="relative dropdown">
            <button class="px-4 py-2 hover:bg-[#2a5298] rounded flex items-center transition-colors duration-200">
                Pengaturan <i class="bi bi-chevron-down ml-1"></i>
            </button>
            <div class="dropdown-menu hidden absolute left-0 mt-2 bg-white text-black rounded-md shadow-lg py-2 w-48">
                <a href="{{ route($routePrefix . '.visimisi.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-flag mr-2"></i>Visi Misi
                </a>
                <a href="{{ route($routePrefix . '.tahun.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-calendar mr-2"></i>Tahun Kurikulum
                </a>
            </div>
        </div>
        @endif

        @if($canSeeCapaian)
        <!-- Capaian Pembelajaran -->
        <div class="relative dropdown">
            <button class="px-4 py-2 hover:bg-[#2a5298] rounded flex items-center transition-colors duration-200">
                Capaian Pembelajaran <i class="bi bi-chevron-down ml-1"></i>
            </button>
            <div class="dropdown-menu hidden absolute left-0 mt-2 bg-white text-black rounded-md shadow-lg py-2 w-56">
                @if($role === 'admin')
                <a href="{{ route('admin.capaianprofillulusan.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-list-check mr-2"></i>CPL
                </a>
                @else
                <a href="{{ route($routePrefix . '.capaianpembelajaranlulusan.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-list-check mr-2"></i>CPL
                </a>
                @endif
                <a href="{{ route($routePrefix . '.capaianpembelajaranmatakuliah.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-bookmark mr-2"></i>CPMK
                </a>
                <a href="{{ route($routePrefix . '.subcpmk.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-bookmark-check mr-2"></i>Sub CPMK
                </a>
            </div>
        </div>
        @endif

        @if($canSeeKurikulum)
        <!-- Kurikulum -->
        <div class="relative dropdown">
            <button class="px-4 py-2 hover:bg-[#2a5298] rounded flex items-center transition-colors duration-200">
                Kurikulum <i class="bi bi-chevron-down ml-1"></i>
            </button>
            <div class="dropdown-menu hidden absolute left-0 mt-2 bg-white text-black rounded-md shadow-lg py-2 w-56">
                <a href="{{ route($routePrefix . '.matakuliah.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-book mr-2"></i>Mata Kuliah
                </a>
                <a href="{{ route($routePrefix . '.matakuliah.organisasimk') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-columns mr-2"></i>Organisasi MK
                </a>
            </div>
        </div>
        @endif

        @if($canSeePemetaan)
        <!-- Pemetaan -->
        <div class="relative dropdown">
            <button class="px-4 py-2 hover:bg-[#2a5298] rounded flex items-center transition-colors duration-200">
                Pemetaan <i class="bi bi-chevron-down ml-1"></i>
            </button>
            <div class="dropdown-menu hidden absolute left-0 mt-2 bg-white text-black rounded-md shadow-lg py-2 w-64">
                <a href="{{ route($routePrefix . '.pemetaancplmk.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-bar-chart mr-2"></i>Pemetaan CPL - MK
                </a>
                <a href="{{ route($routePrefix . '.pemetaancplcpmkmk.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-diagram-3 mr-2"></i>Pemetaan CPL - CPMK - MK
                </a>
                <a href="{{ route($routePrefix . '.pemetaancplcpmkmk.pemetaanmkcplcpmk') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-graph-up mr-2"></i>Pemetaan MK - CPL - CPMK
                </a>
                <a href="{{ route($routePrefix . '.pemetaanmkcpmksubcpmk.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-diagram-2 mr-2"></i>Pemetaan MK - CPMK - SubCPMK
                </a>
                <a href="{{ route($routePrefix . '.bobot.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-speedometer2 mr-2"></i>Bobot CPL - MK
                </a>
            </div>
        </div>
        @endif

        @if($canManageMahasiswa || $canManageUsers)
        <!-- Manajemen -->
        <div class="relative dropdown">
            <button class="px-4 py-2 hover:bg-[#2a5298] rounded flex items-center transition-colors duration-200">
                Manajemen <i class="bi bi-chevron-down ml-1"></i>
            </button>
            <div class="dropdown-menu hidden absolute left-0 mt-2 bg-white text-black rounded-md shadow-lg py-2 w-56">
                @if($canManageMahasiswa)
                <a href="{{ route('tim.mahasiswa.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-people mr-2"></i>Mahasiswa
                </a>
                @endif
                @if($canManageUsers)
                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-people mr-2"></i>Pengguna
                </a>
                <a href="{{ route('admin.pendingusers.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-person-check mr-2"></i>Persetujuan Pengguna
                </a>
                <a href="{{ route('admin.prodi.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-mortarboard mr-2"></i>Program Studi
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-envelope mr-2"></i>Pesan Kontak
                </a>
                @endif
            </div>
        </div>
        @endif

        @if($canSeePenilaian)
        <!-- Penilaian (Dosen only) -->
        <a href="{{ route('dosen.penilaian.index') }}" class="px-4 py-2 hover:bg-[#2a5298] rounded transition-colors duration-200">
            <i class="bi bi-clipboard-check mr-2"></i>Penilaian
        </a>
        @endif

        @if($canSeeLaporan)
        <!-- Laporan -->
        <div class="relative dropdown">
            <button class="px-4 py-2 hover:bg-[#2a5298] rounded flex items-center transition-colors duration-200">
                Laporan <i class="bi bi-chevron-down ml-1"></i>
            </button>
            <div class="dropdown-menu hidden absolute right-0 mt-2 bg-white text-black rounded-md shadow-lg py-2 w-56">
                @if($canSeeHasilOBE)
                <a href="{{ route($routePrefix . '.hasilobe.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-bar-chart mr-2"></i>Hasil OBE
                </a>
                @endif
                <a href="{{ route($routePrefix . '.ranking.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-trophy mr-2"></i>Ranking Mahasiswa
                </a>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="mobile-menu md:hidden bg-[#1a2f5c]">
        <div class="px-6 py-2 space-y-2">
            <!-- Beranda -->
            <a href="{{ route($routePrefix . '.dashboard') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-house-door mr-2"></i>Beranda
            </a>

            @if($canSeePengaturan)
            <div class="border-t border-[#243b73]"></div>
            <p class="text-gray-400 text-xs px-4 py-1 uppercase">Pengaturan</p>
            <a href="{{ route($routePrefix . '.visimisi.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-flag mr-2"></i>Visi Misi
            </a>
            <a href="{{ route($routePrefix . '.tahun.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-calendar mr-2"></i>Tahun Kurikulum
            </a>
            @endif

            @if($canSeeCapaian)
            <div class="border-t border-[#243b73]"></div>
            <p class="text-gray-400 text-xs px-4 py-1 uppercase">Capaian Pembelajaran</p>
            @if($role === 'admin')
            <a href="{{ route('admin.capaianprofillulusan.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-list-check mr-2"></i>CPL
            </a>
            @else
            <a href="{{ route($routePrefix . '.capaianpembelajaranlulusan.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-list-check mr-2"></i>CPL
            </a>
            @endif
            <a href="{{ route($routePrefix . '.capaianpembelajaranmatakuliah.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-bookmark mr-2"></i>CPMK
            </a>
            <a href="{{ route($routePrefix . '.subcpmk.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-bookmark-check mr-2"></i>Sub CPMK
            </a>
            @endif

            @if($canSeeKurikulum)
            <div class="border-t border-[#243b73]"></div>
            <p class="text-gray-400 text-xs px-4 py-1 uppercase">Kurikulum</p>
            <a href="{{ route($routePrefix . '.matakuliah.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-book mr-2"></i>Mata Kuliah
            </a>
            <a href="{{ route($routePrefix . '.matakuliah.organisasimk') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-columns mr-2"></i>Organisasi MK
            </a>
            @endif

            @if($canSeePemetaan)
            <div class="border-t border-[#243b73]"></div>
            <p class="text-gray-400 text-xs px-4 py-1 uppercase">Pemetaan</p>
            <a href="{{ route($routePrefix . '.pemetaancplmk.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-bar-chart mr-2"></i>CPL - MK
            </a>
            <a href="{{ route($routePrefix . '.pemetaancplcpmkmk.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-diagram-3 mr-2"></i>CPL - CPMK - MK
            </a>
            <a href="{{ route($routePrefix . '.bobot.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-speedometer2 mr-2"></i>Bobot CPL - MK
            </a>
            @endif

            @if($canManageMahasiswa || $canManageUsers)
            <div class="border-t border-[#243b73]"></div>
            <p class="text-gray-400 text-xs px-4 py-1 uppercase">Manajemen</p>
            @if($canManageMahasiswa)
            <a href="{{ route('tim.mahasiswa.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-people mr-2"></i>Mahasiswa
            </a>
            @endif
            @if($canManageUsers)
            <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-people mr-2"></i>Pengguna
            </a>
            <a href="{{ route('admin.prodi.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-mortarboard mr-2"></i>Program Studi
            </a>
            @endif
            @endif

            @if($canSeePenilaian)
            <div class="border-t border-[#243b73]"></div>
            <a href="{{ route('dosen.penilaian.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-clipboard-check mr-2"></i>Penilaian
            </a>
            @endif

            @if($canSeeLaporan)
            <div class="border-t border-[#243b73]"></div>
            <p class="text-gray-400 text-xs px-4 py-1 uppercase">Laporan</p>
            @if($canSeeHasilOBE)
            <a href="{{ route($routePrefix . '.hasilobe.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-bar-chart mr-2"></i>Hasil OBE
            </a>
            @endif
            <a href="{{ route($routePrefix . '.ranking.index') }}" class="block px-4 py-2 hover:bg-[#2a5298] rounded">
                <i class="bi bi-trophy mr-2"></i>Ranking Mahasiswa
            </a>
            @endif

            <div class="border-t border-[#243b73]"></div>
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-[#2a5298] rounded text-red-300">
                    <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                </button>
            </form>
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('active');
    }
    
    function toggleDropdownProfil() {
        const dropdown = document.getElementById("userDropdown");
        if (dropdown.style.display === "none") {
            dropdown.style.display = "block";
        } else {
            dropdown.style.display = "none";
        }
    }

    document.addEventListener("click", function (event) {
        const button = event.target.closest("button");
        const dropdown = document.getElementById("userDropdown");
        if (!button && !event.target.closest("#userDropdown")) {
            if (dropdown) dropdown.style.display = "none";
        }
    });
</script>

<style>
    .dropdown:hover .dropdown-menu {
        display: block;
    }
    .mobile-menu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-in-out;
    }
    .mobile-menu.active {
        max-height: 800px;
        overflow-y: auto;
    }
</style>
