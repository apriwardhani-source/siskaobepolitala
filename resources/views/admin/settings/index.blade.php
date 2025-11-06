@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8 px-4">
    <div class="container-fluid max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-400 to-purple-600 rounded-2xl blur opacity-75"></div>
                            <div class="relative bg-gradient-to-br from-indigo-500 to-purple-600 text-white p-4 rounded-2xl">
                                <i class="fas fa-cog text-4xl"></i>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-700 bg-clip-text text-transparent mb-1">Pengaturan Sistem</h1>
                            <p class="text-gray-600 text-sm flex items-center gap-2">
                                <i class="fas fa-sliders-h text-indigo-500"></i>
                                Kelola konfigurasi dan integrasi sistem
                            </p>
                        </div>
                    </div>
                    <nav class="text-sm">
                        <ol class="flex items-center gap-2 text-gray-500">
                            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition-colors flex items-center gap-1">
                                <i class="fas fa-home text-xs"></i> Dashboard
                            </a></li>
                            <li><i class="fas fa-chevron-right text-xs"></i></li>
                            <li class="text-indigo-600 font-semibold">Pengaturan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Settings Cards Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- WhatsApp Integration Card -->
            <a href="{{ route('admin.whatsapp.connect') }}" class="group">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6">
                        <div class="flex items-center justify-between">
                            <div class="bg-white/20 backdrop-blur-lg rounded-xl p-4">
                                <i class="fab fa-whatsapp text-white text-4xl"></i>
                            </div>
                            <i class="fas fa-arrow-right text-white text-xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">WhatsApp Integration</h3>
                        <p class="text-sm text-gray-600 mb-4">Kelola koneksi WhatsApp untuk notifikasi otomatis</p>
                        <div class="flex items-center gap-2 text-sm">
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full font-semibold">
                                <i class="fas fa-bell mr-1"></i>Notifikasi
                            </span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-semibold">
                                <i class="fas fa-check-circle mr-1"></i>Active
                            </span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Profile Settings Card -->
            <a href="{{ route('admin.settings.profile') }}" class="group">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div class="bg-gradient-to-br from-blue-500 to-cyan-600 p-6">
                        <div class="flex items-center justify-between">
                            <div class="bg-white/20 backdrop-blur-lg rounded-xl p-4">
                                <i class="fas fa-user-circle text-white text-4xl"></i>
                            </div>
                            <i class="fas fa-arrow-right text-white text-xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Profil Akun</h3>
                        <p class="text-sm text-gray-600 mb-4">Edit informasi profil dan ubah password</p>
                        <div class="flex items-center gap-2 text-sm">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-semibold">
                                <i class="fas fa-id-badge mr-1"></i>Akun
                            </span>
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full font-semibold">
                                <i class="fas fa-lock mr-1"></i>Keamanan
                            </span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- System Settings Card -->
            <a href="{{ route('admin.settings.system') }}" class="group">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-6">
                        <div class="flex items-center justify-between">
                            <div class="bg-white/20 backdrop-blur-lg rounded-xl p-4">
                                <i class="fas fa-cogs text-white text-4xl"></i>
                            </div>
                            <i class="fas fa-arrow-right text-white text-xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Pengaturan Sistem</h3>
                        <p class="text-sm text-gray-600 mb-4">Konfigurasi umum dan preferensi sistem</p>
                        <div class="flex items-center gap-2 text-sm">
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full font-semibold">
                                <i class="fas fa-sliders-h mr-1"></i>Config
                            </span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full font-semibold">
                                <i class="fas fa-database mr-1"></i>System
                            </span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Email Configuration Card (Coming Soon) -->
            <div class="relative group">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 opacity-60">
                    <div class="bg-gradient-to-br from-orange-500 to-red-600 p-6">
                        <div class="flex items-center justify-between">
                            <div class="bg-white/20 backdrop-blur-lg rounded-xl p-4">
                                <i class="fas fa-envelope text-white text-4xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Email Configuration</h3>
                        <p class="text-sm text-gray-600 mb-4">Setup SMTP dan template email</p>
                        <div class="flex items-center gap-2 text-sm">
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full font-semibold">
                                <i class="fas fa-clock mr-1"></i>Coming Soon
                            </span>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="bg-white px-4 py-2 rounded-full shadow-lg text-sm font-bold text-gray-700">
                        <i class="fas fa-lock mr-2"></i>Coming Soon
                    </span>
                </div>
            </div>

            <!-- Backup & Restore Card (Coming Soon) -->
            <div class="relative group">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 opacity-60">
                    <div class="bg-gradient-to-br from-teal-500 to-cyan-600 p-6">
                        <div class="flex items-center justify-between">
                            <div class="bg-white/20 backdrop-blur-lg rounded-xl p-4">
                                <i class="fas fa-database text-white text-4xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Backup & Restore</h3>
                        <p class="text-sm text-gray-600 mb-4">Backup database dan restore data</p>
                        <div class="flex items-center gap-2 text-sm">
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full font-semibold">
                                <i class="fas fa-clock mr-1"></i>Coming Soon
                            </span>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="bg-white px-4 py-2 rounded-full shadow-lg text-sm font-bold text-gray-700">
                        <i class="fas fa-lock mr-2"></i>Coming Soon
                    </span>
                </div>
            </div>

            <!-- Logs & Monitoring Card (Coming Soon) -->
            <div class="relative group">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 opacity-60">
                    <div class="bg-gradient-to-br from-pink-500 to-rose-600 p-6">
                        <div class="flex items-center justify-between">
                            <div class="bg-white/20 backdrop-blur-lg rounded-xl p-4">
                                <i class="fas fa-chart-line text-white text-4xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Logs & Monitoring</h3>
                        <p class="text-sm text-gray-600 mb-4">Activity logs dan system monitoring</p>
                        <div class="flex items-center gap-2 text-sm">
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full font-semibold">
                                <i class="fas fa-clock mr-1"></i>Coming Soon
                            </span>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="bg-white px-4 py-2 rounded-full shadow-lg text-sm font-bold text-gray-700">
                        <i class="fas fa-lock mr-2"></i>Coming Soon
                    </span>
                </div>
            </div>

        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl p-8 shadow-2xl text-white">
            <div class="flex items-start gap-4">
                <div class="bg-white/20 backdrop-blur-lg rounded-xl p-3 flex-shrink-0">
                    <i class="fas fa-info-circle text-3xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-2">Tips Pengaturan</h3>
                    <ul class="space-y-2 text-sm text-indigo-100">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle mt-1"></i>
                            <span>Pastikan WhatsApp Integration aktif untuk menerima notifikasi real-time</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle mt-1"></i>
                            <span>Update profil akun secara berkala untuk keamanan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle mt-1"></i>
                            <span>Hubungi developer untuk fitur Coming Soon yang Anda butuhkan</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
