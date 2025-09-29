<!-- resources/views/admin/manage_prodi.blade.php (Contoh) -->
@extends('layouts.app')

@section('title', 'Kelola Data Prodi')

@section('content')
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <h1 class="text-2xl font-bold text-white mb-6">Kelola Data Prodi</h1>

        @if(session('success'))
            <div class="glass-card rounded-lg p-4 mb-4 text-green-200 border border-green-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('admin.create.prodi.form') }}" class="glass-button text-lg">
                <i class="fas fa-user-plus me-2"></i>
                Tambah Prodi
            </a>
        </div>

        <div class="glass-card rounded-lg overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white/10">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kode Prodi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Prodi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jenjang</th>
                            <!-- Tambahkan kolom lain jika diperlukan -->
                        </tr>
                    </thead>
                    <tbody class="bg-white/10 divide-y divide-gray-200">
                        @forelse($prodis as $prodi)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $prodi->kode_prodi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $prodi->nama_prodi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $prodi->jenjang }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center">Tidak ada data prodi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection