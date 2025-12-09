@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header -->
        <div class="mb-6">
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-arrow-left mr-2 text-xs"></i>
                kembali
            </a>
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-graduate text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                        Detail Mahasiswa
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Informasi lengkap mengenai mahasiswa dengan NIM {{ $mahasiswa->nim ?? '-' }}.
                    </p>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-info-circle mr-2 text-sm"></i>
                    Informasi Mahasiswa
                </h2>
            </div>

            <div class="px-6 py-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">NIM</label>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-mono font-semibold bg-blue-100 text-blue-800 mr-3">
                                {{ $mahasiswa->nim }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">Nama Mahasiswa</label>
                        <input type="text" value="{{ $mahasiswa->nama_mahasiswa }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">Program Studi</label>
                        <input type="text" value="{{ $mahasiswa->prodi->nama_prodi ?? '-' }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">Tahun Kurikulum</label>
                        <input type="text" value="{{ $mahasiswa->tahunKurikulum->tahun ?? '-' }}" readonly
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-800">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-800">Status</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                     @if($mahasiswa->status == 'aktif') bg-green-100 text-green-800
                                     @elseif($mahasiswa->status == 'lulus') bg-blue-100 text-blue-800
                                     @elseif($mahasiswa->status == 'cuti') bg-yellow-100 text-yellow-800
                                     @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($mahasiswa->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex justify-end">
                    <a href="{{ route('tim.mahasiswa.edit', $mahasiswa->id) }}"
                       class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-edit mr-2 text-xs"></i>
                        Edit Mahasiswa
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

