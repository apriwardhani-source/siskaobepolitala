<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kurikulum OBE')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    @vite(['resources/js/app.js'])
    
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
            max-height: 500px;
        }
    </style>
    
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
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<nav class="bg-gradient-to-r from-[#1e3c72] to-[#2a5298] text-white fixed top-0 left-0 w-full z-50 shadow-lg">
    <!-- Top Bar -->
    <div class="px-6 py-4 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/logo-politala.png') }}" alt="Logo Politala" class="h-12 w-auto">
            <span class="font-bold text-xl uppercase">Politala OBE - Kaprodi</span>
        </div>
        
        <!-- Mobile Menu Button -->
        <button onclick="toggleMobileMenu()" class="md:hidden text-white">
            <i class="bi bi-list text-3xl"></i>
        </button>
        
        <!-- User Menu (Desktop) -->
        <div class="hidden md:flex items-center space-x-4">
            <span class="font-medium text-lg">{{ auth()->user()->name }}</span>
            <div class="relative">
                <button onclick="toggleDropdownProfil()" class="flex items-center focus:outline-none">
                    <i class="bi bi-person-circle text-white text-2xl"></i>
                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414L10 13.414 5.293 8.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <div id="userDropdown" class="absolute right-0 mt-2 bg-white text-black rounded-md shadow-lg py-2 w-48 z-50" style="display: none;">
                    @auth
                        <a href="{{ route('settings.profile') }}" class="flex items-center px-4 py-2 hover:bg-gray-100 transition-colors">
                            <i class="fas fa-user-circle mr-2 text-blue-600"></i>
                            <span>Profil Saya</span>
                        </a>
                        <div class="border-t border-gray-200 my-1"></div>
                    @endauth
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
        <!-- Dashboard -->
        <a href="{{ route('kaprodi.dashboard') }}" class="px-4 py-2 hover:bg-[#2a5298] rounded transition-colors duration-200">
            <i class="bi bi-house-door mr-2"></i>Beranda
        </a>
        
        <!-- Program Setup -->
        <div class="relative dropdown">
            <button class="px-4 py-2 hover:bg-[#2a5298] rounded flex items-center transition-colors duration-200">
                Pengaturan Program <i class="bi bi-chevron-down ml-1"></i>
            </button>
            <div class="dropdown-menu hidden absolute left-0 mt-2 bg-white text-black rounded-md shadow-lg py-2 w-48">
                <a href="{{ route('kaprodi.visimisi.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-calendar mr-2"></i>Visi Misi
                </a>
                <a href="{{ route('kaprodi.tahun.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-calendar mr-2"></i>Tahun
                </a>
            </div>
        </div>
        
        <!-- Learning Outcomes -->
        <div class="relative dropdown">
            <button class="px-4 py-2 hover:bg-[#2a5298] rounded flex items-center transition-colors duration-200">
                Capaian Pembelajaran <i class="bi bi-chevron-down ml-1"></i>
            </button>
            <div class="dropdown-menu hidden absolute left-0 mt-2 bg-white text-black rounded-md shadow-lg py-2 w-56">
                <a href="{{ route('kaprodi.capaianpembelajaranlulusan.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-check2-square mr-2"></i>1. CPL Prodi
                </a>
            </div>
        </div>
        
        <!-- Curriculum -->
        <div class="relative dropdown">
            <button class="px-4 py-2 hover:bg-[#2a5298] rounded flex items-center transition-colors duration-200">
                Kurikulum <i class="bi bi-chevron-down ml-1"></i>
            </button>
            <div class="dropdown-menu hidden absolute left-0 mt-2 bg-white text-black rounded-md shadow-lg py-2 w-56">
                <a href="{{ route('kaprodi.matakuliah.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-book mr-2"></i>2. Mata Kuliah
                </a>
                <a href="{{ route('kaprodi.pemetaancplmk.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-bar-chart mr-2"></i>3. CPL - MK
                </a>
            </div>
        </div>
        
        <!-- Advanced Mapping -->
        <div class="relative dropdown">
            <button class="px-4 py-2 hover:bg-[#2a5298] rounded flex items-center transition-colors duration-200">
                Lanjutan <i class="bi bi-chevron-down ml-1"></i>
            </button>
            <div class="dropdown-menu hidden absolute left-0 mt-2 bg-white text-black rounded-md shadow-lg py-2 w-56">
                <a href="{{ route('kaprodi.matakuliah.organisasimk') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-columns mr-2"></i>4. Organisasi MK
                </a>
            </div>
        </div>
        
        <!-- Pemetaan -->
        <div class="relative dropdown">
            <button class="px-4 py-2 hover:bg-[#2a5298] rounded flex items-center transition-colors duration-200">
                Pemetaan <i class="bi bi-chevron-down ml-1"></i>
            </button>
            <div class="dropdown-menu hidden absolute right-0 mt-2 bg-white text-black rounded-md shadow-lg py-2 w-64">
                <a href="{{ route('kaprodi.capaianpembelajaranmatakuliah.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-bookmark mr-2"></i>CPMK
                </a>
                <a href="{{ route('kaprodi.pemetaancplcpmkmk.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-diagram-3 mr-2"></i>Pemetaan CPL-CPMK-MK
                </a>
                <a href="{{ route('kaprodi.pemetaancplcpmkmk.pemetaanmkcplcpmk') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-graph-up mr-2"></i>Pemetaan MK-CPL-CPMK
                </a>
                <a href="{{ route('kaprodi.subcpmk.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-bookmark-check mr-2"></i>Sub CPMK
                </a>
                <a href="{{ route('kaprodi.pemetaanmkcpmksubcpmk.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-diagram-2 mr-2"></i>Pemetaan MK-CPMK-SubCPMK
                </a>
                <a href="{{ route('kaprodi.bobot.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    <i class="bi bi-speedometer2 mr-2"></i>Bobot CPL-MK
                </a>
            </div>
        </div>
        
        <!-- Ranking Mahasiswa -->
        <a href="{{ route('kaprodi.ranking.index') }}" class="px-4 py-2 hover:bg-gray-700 rounded transition-colors duration-200">
            <i class="bi bi-trophy mr-2"></i>Ranking Mahasiswa
        </a>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="mobile-menu md:hidden bg-gray-800">
        <div class="px-6 py-2 space-y-2">
            <a href="{{ route('kaprodi.dashboard') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">
                <i class="bi bi-house-door mr-2"></i>Beranda
            </a>
            <div class="border-t border-gray-700"></div>
            <p class="text-gray-400 text-xs px-4 py-1">PENGATURAN PROGRAM</p>
            <a href="{{ route('kaprodi.visimisi.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">
                <i class="bi bi-calendar mr-2"></i>Visi Misi
            </a>
            <a href="{{ route('kaprodi.tahun.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">
                <i class="bi bi-calendar mr-2"></i>Tahun
            </a>
            <div class="border-t border-gray-700"></div>
            <p class="text-gray-400 text-xs px-4 py-1">CAPAIAN PEMBELAJARAN</p>
            <a href="{{ route('kaprodi.capaianpembelajaranlulusan.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">
                <i class="bi bi-check2-square mr-2"></i>1. CPL Prodi
            </a>
            <div class="border-t border-gray-700"></div>
            <p class="text-gray-400 text-xs px-4 py-1">KURIKULUM</p>
            <a href="{{ route('kaprodi.matakuliah.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">
                <i class="bi bi-book mr-2"></i>2. Mata Kuliah
            </a>
            <a href="{{ route('kaprodi.pemetaancplmk.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">
                <i class="bi bi-bar-chart mr-2"></i>3. CPL - MK
            </a>
            <div class="border-t border-gray-700"></div>
            <a href="{{ route('kaprodi.ranking.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">
                <i class="bi bi-trophy mr-2"></i>Ranking Mahasiswa
            </a>
            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-700 rounded text-red-400">
                    <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mx-auto px-4 py-6 mt-32">
    @yield('content')
</div>

@stack('scripts')
</body>
</html>
