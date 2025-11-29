@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.prodi.index') }}" 
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-arrow-left mr-2 text-xs"></i>
                kembali
            </a>
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-university text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Detail Program Studi</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Informasi lengkap mengenai program studi dan kaprodi.
                    </p>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Info Prodi -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Kode Prodi</p>
                        <p class="mt-1 text-lg font-bold text-gray-900">{{ $prodi->kode_prodi }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-semibold text-gray-500 mb-1 uppercase">Jenjang Pendidikan</p>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                            {{ $prodi->jenjang_pendidikan }}
                        </span>
                    </div>
                </div>
                <div class="px-6 py-4 bg-white grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 mb-1 uppercase">Nama Program Studi</p>
                        <p class="text-sm text-gray-800 leading-relaxed">
                            {{ $prodi->nama_prodi }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 mb-1 uppercase">Nama Kaprodi</p>
                        <p class="text-sm text-gray-800 leading-relaxed">
                            {{ $prodi->nama_kaprodi ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Aksi -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.prodi.index') }}" 
                   class="inline-flex items-center px-5 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times mr-2 text-xs"></i>
                    Kembali
                </a>
                <a href="{{ route('admin.prodi.edit', $prodi->kode_prodi) }}" 
                   class="inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                    <i class="fas fa-edit mr-2 text-xs"></i>
                    Edit Prodi
                </a>
            </div>
        </div>

    </div>
</div>
@endsection

