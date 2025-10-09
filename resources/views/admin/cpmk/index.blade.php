@extends('layouts.app')

@section('title', 'Kelola Data CPMK')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">Kelola Data CPMK</h1>
                <p class="text-sm text-gray-300 mt-1">Daftar semua CPMK yang tersedia.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('cpmk.create') }}" class="glass-button text-lg">
                    <i class="fas fa-plus-circle me-2"></i> Tambah CPMK Baru
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="glass-card rounded-lg p-4 mb-4 text-green-200 border border-green-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="glass-card rounded-lg overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full text-white border border-white/30 border-collapse">
                    <thead class="bg-white/10 border-b border-white/30">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-white/30">CPL</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-white/30">Kode CPMK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-white/30">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-white/30">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/5">
                        @forelse($cpmks as $cpmk)
                            <tr class="hover:bg-white/5">
                                {{-- Kolom CPL --}}
                                <td class="px-6 py-4 text-sm border border-white/20">
                                    {{ $cpmk->cpl->kode_cpl ?? '-' }}
                                </td>
                                {{-- Kolom Kode CPMK --}}
                                <td class="px-6 py-4 text-sm border border-white/20">
                                    {{ $cpmk->kode_cpmk }}
                                </td>
                                {{-- Kolom Deskripsi --}}
                                <td class="px-6 py-4 text-sm border border-white/20">
                                    {{ Str::limit($cpmk->deskripsi, 100) }}
                                </td>
                                {{-- Kolom Aksi --}}
                                <td class="px-6 py-4 text-sm font-medium border border-white/20">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('cpmk.edit', $cpmk->id) }}" class="glass-button-warning">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('cpmk.destroy', $cpmk->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="glass-button-danger">
                                                <i class="fas fa-trash-alt me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-300 border border-white/20">Tidak ada data CPMK.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($cpmks->hasPages())
                <div class="px-6 py-3 bg-white/5 border-t border-white/10">
                    {{ $cpmks->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
