@extends('layouts.app')

@section('title', 'Kelola Data CPMK')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">Kelola Data CPMK</h1>
                <p class="text-sm text-gray-300 mt-1">Daftar seluruh CPMK yang telah terdaftar.</p>
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

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-white border border-white/30 border-collapse">
                <thead class="bg-white/10 border-b border-white/30">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Kode CPMK</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Deskripsi CPMK</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">CPL Terkait</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Jumlah MK</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white/5">
                    @forelse($cpmks as $index => $cpmk)
                        <tr class="hover:bg-white/5">
                            <td class="px-4 py-3 align-top border border-white/20">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 align-top font-semibold border border-white/20">{{ $cpmk->kode_cpmk }}</td>
                            <td class="px-4 py-3 align-top border border-white/20">{!! nl2br(e($cpmk->deskripsi)) !!}</td>
                            <td class="px-4 py-3 align-top border border-white/20">
                                @if($cpmk->cpl)
                                    <span class="badge bg-primary">{{ $cpmk->cpl->kode_cpl }}</span> - {{ $cpmk->cpl->deskripsi }}
                                @else
                                    <span class="text-red-400">Belum ditetapkan</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 align-top border border-white/20">{{ $cpmk->mataKuliahs->count() }}</td>
                            <td class="px-4 py-3 align-top border border-white/20">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('cpmk.edit', $cpmk->id) }}" class="glass-button-warning">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('cpmk.destroy', $cpmk->id) }}" method="POST" onsubmit="return confirm('Hapus CPMK ini?')">
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
                            <td colspan="6" class="px-6 py-4 text-center text-gray-300 border border-white/20">
                                <i class="fas fa-info-circle me-1"></i> Belum ada data CPMK.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $cpmks->links() }}
    </div>
</div>
@endsection
