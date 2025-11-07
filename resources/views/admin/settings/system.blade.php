@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-indigo-50 py-8 px-4">
    <div class="container-fluid max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.settings.index') }}" class="text-gray-500 hover:text-purple-600 transition-colors">
                        <i class="fas fa-arrow-left text-2xl"></i>
                    </a>
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-indigo-600 rounded-2xl blur opacity-75"></div>
                        <div class="relative bg-gradient-to-br from-purple-500 to-indigo-600 text-white p-4 rounded-2xl">
                            <i class="fas fa-cogs text-4xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-indigo-700 bg-clip-text text-transparent mb-1">Pengaturan Sistem</h1>
                        <p class="text-gray-600 text-sm">Konfigurasi preferensi sistem</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coming Soon -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 p-12 text-center">
            <div class="inline-block bg-gradient-to-br from-purple-100 to-indigo-100 rounded-full p-8 mb-6">
                <i class="fas fa-tools text-6xl text-purple-600"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-3">Coming Soon</h2>
            <p class="text-gray-600 mb-6">Fitur pengaturan sistem sedang dalam pengembangan</p>
            <a href="{{ route('admin.settings.index') }}" 
               class="inline-block px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white rounded-xl font-semibold shadow-lg transition-all transform hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Pengaturan
            </a>
        </div>
    </div>
</div>
@endsection
