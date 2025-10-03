<!-- resources/views/admin/manage_mahasiswa.blade.php -->
@extends('layouts.app')

@section('title', 'Kelola Data Mahasiswa')

@section('content')
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <h1 class="text-2xl font-bold text-white mb-6">Kelola Data Mahasiswa</h1>

        @if(session('success'))
            <div class="glass-card rounded-lg p-4 mb-4 text-green-200 border border-green-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('admin.create.mahasiswa.form') }}" class="glass-button text-lg">
                <i class="fas fa-user-plus me-2"></i>
                Tambah Mahasiswa
            </a>
        </div>

        <div class="glass-card rounded-lg overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white/10">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">NIM</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kurikulum</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Prodi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/10 divide-y divide-gray-200">
    @forelse($mahasiswas as $mahasiswa)
        @php
            $isNew = session('new_mahasiswa_id') == $mahasiswa->id;
        @endphp
        <tr class="{{ $isNew ? 'bg-green-700/40' : '' }}">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $mahasiswa->nim }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $mahasiswa->nama }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                {{ $mahasiswa->tahun_kurikulum ?? '-' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                {{ $mahasiswa->prodi->nama_prodi ?? '-' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                <div class="flex items-center space-x-3">
                    <!-- Tombol Edit -->
                    <a href="{{ route('admin.edit.mahasiswa', $mahasiswa->id) }}" 
                       class="glass-button-warning px-4 py-1">
                       <i class="fas fa-edit me-1"></i> Edit
                    </a>

                    <!-- Tombol Hapus -->
                    <form action="{{ route('admin.delete.mahasiswa', $mahasiswa->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus mahasiswa ini?')" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="glass-button-danger px-4 py-1">
                            <i class="fas fa-trash-alt me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center">
                Tidak ada data mahasiswa.
            </td>
        </tr>
    @endforelse
</tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
