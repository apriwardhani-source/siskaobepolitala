@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-trophy text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Data Ranking Mahasiswa (SAW)</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Lihat hasil perhitungan ranking mahasiswa menggunakan metode Simple Additive Weighting (SAW).
                        Halaman ini hanya untuk melihat data (read-only).
                    </p>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div id="alert-success" class="mb-6 rounded-lg bg-green-50 border-l-4 border-green-500 p-4 shadow-sm">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-green-800">Informasi</h3>
                    <p class="mt-1 text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div id="alert-error" class="mb-6 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-800">Error</h3>
                    @foreach($errors->all() as $error)
                        <p class="mt-1 text-sm text-red-700">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Filter Card (mirip Wadir1) -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter Data Ranking
                </h2>
            </div>
            
            <form method="GET" action="{{ route('admin.ranking.index') }}" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-university text-blue-500 mr-1"></i>
                            Program Studi
                        </label>
                        <select name="kode_prodi" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="">Semua Prodi</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->kode_prodi }}" {{ request('kode_prodi') == $prodi->kode_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex md:justify-end">
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 w-full md:w-auto justify-center">
                            <i class="fas fa-search mr-2"></i>
                            Tampilkan Data
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Daftar Session Ranking (read-only) -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Riwayat Ranking</h2>
            </div>
            
            <div class="overflow-x-auto">
                @if($sessions->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Prodi</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Tahun</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Total Mahasiswa</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Diupload Oleh</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sessions as $index => $session)
                            <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $session->judul }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $session->prodi->nama_prodi ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $session->tahun ? $session->tahun->nama_kurikulum . ' - ' . $session->tahun->tahun : '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $session->total_mahasiswa }} mahasiswa
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $session->uploader->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $session->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.ranking.hasil', $session->id_session) }}" 
                                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat Hasil
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $sessions->links() }}
                    </div>
                @else
                    <div class="px-6 py-16 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Data Ranking</h3>
                        <p class="mt-2 text-sm text-gray-500">Belum ada session ranking yang tersedia untuk ditampilkan.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
