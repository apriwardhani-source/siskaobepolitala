<!-- resources/views/admin/manage_angkatan.blade.php -->
@extends('layouts.app')

@section('title', 'Kelola Data Kurikulum')

@section('content')
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <h1 class="text-2xl font-bold text-white mb-6">Kelola Data Kurikulum</h1>

        @if(session('success'))
            <div class="glass-card rounded-lg p-4 mb-4 text-green-200 border border-green-400">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tombol Tambah Kurikulum -->
        <div class="mb-4">
            <a href="{{ route('angkatan.create') }}" class="glass-button text-lg">
                <i class="fas fa-plus-circle me-2"></i>
                Tambah Kurikulum
            </a>
        </div>

        <!-- Tabel Data Kurikulum -->
        <div class="glass-card rounded-lg overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white/10">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Tahun Kurikulum
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Program Studi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/10 divide-y divide-gray-200">
                        @forelse($angkatans as $angkatan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                    {{ $angkatan->tahun_kurikulum }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                    {{ $angkatan->prodi->nama_prodi ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center">
                                    Tidak ada data kurikulum.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
