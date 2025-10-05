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
        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
            Tahun Kurikulum
        </th>
        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
            Mata Kuliah
        </th>
        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
            Aksi
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
                {{ $angkatan->matkul->nama_matkul ?? '-' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-white flex space-x-2">
                <a href="{{ route('angkatan.edit', $angkatan->id) }}" class="glass-button-warning">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <form action="{{ route('angkatan.delete', $angkatan->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus kurikulum ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="glass-button-danger">
                        <i class="fas fa-trash-alt me-1"></i> Hapus
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center">
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
