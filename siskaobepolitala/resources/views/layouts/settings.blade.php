<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SISKABOE Politala') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
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
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">

<!-- Navbar -->
<nav class="bg-gradient-to-r from-[#1e3c72] to-[#2a5298] text-white fixed top-0 left-0 w-full z-50 shadow-lg">
    <!-- Top Bar -->
    <div class="container-fluid px-6 py-3 flex justify-between items-center">
        <!-- Logo and Title -->
        <div class="flex items-center gap-4">
            <img src="{{ asset('img/logo2.png') }}" alt="Politala Logo" class="h-12 w-12 object-contain">
            <div>
                <h1 class="text-xl font-bold">SISKABOE POLITALA</h1>
                <p class="text-xs text-gray-200">Sistem Kurikulum Berbasis OBE</p>
            </div>
        </div>

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
                        @if(auth()->user()->role === 'admin')
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
    
    <!-- Back Button Bar -->
    <div class="bg-[#1a2f5c] px-6 py-3">
        <div class="flex items-center gap-3">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg transition-all">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            @elseif(auth()->user()->role === 'tim')
                <a href="{{ route('tim.dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg transition-all">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            @elseif(auth()->user()->role === 'dosen')
                <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg transition-all">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            @elseif(auth()->user()->role === 'wadir1')
                <a href="{{ route('wadir1.dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg transition-all">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            @elseif(auth()->user()->role === 'kaprodi')
                <a href="{{ route('kaprodi.dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg transition-all">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            @endif
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mx-auto px-4 py-6" style="margin-top: 140px;">
    @yield('content')
</div>

</body>
</html>
