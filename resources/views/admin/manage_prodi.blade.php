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
                <table class="min-w-full text-white border border-white/30 border-collapse">
                    <thead class="bg-white/10 border-b border-white/30">
    <tr>
        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-white/30">Kode Prodi</th>
        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-white/30">Nama Prodi</th>
        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-white/30">Jenjang</th>
        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-white/30">Aksi</th>
    </tr>
</thead>
<tbody class="bg-white/5">
    @forelse($prodis as $prodi)
        <tr class="hover:bg-white/5">
            <td class="px-6 py-4 whitespace-nowrap text-sm border border-white/20">{{ $prodi->kode_prodi }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm border border-white/20">{{ $prodi->nama_prodi }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm border border-white/20">{{ $prodi->jenjang }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm border border-white/20 flex gap-2">
                <a href="{{ route('admin.edit.prodi', $prodi->id) }}" class="glass-button-warning"><i class="fas fa-edit me-1"></i>Edit</a>
                <form action="{{ route('admin.delete.prodi', $prodi->id) }}" method="POST" onsubmit="return confirm('Yakin hapus prodi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="glass-button-danger"><i class="fas fa-trash me-1"></i>Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center border border-white/20">Tidak ada data prodi.</td>
        </tr>
    @endforelse
</tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
