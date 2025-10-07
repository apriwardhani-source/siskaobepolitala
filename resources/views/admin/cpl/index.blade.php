@extends('layouts.app')

@section('title', 'Kelola CPL')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="glass-card rounded-xl p-6 shadow-lg">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2">Kelola CPL (Capaian Pembelajaran Lulusan)</h1>
                    <p class="text-sm text-gray-300">Daftar semua CPL yang tersedia. Total: {{ $cpls->count() }} CPL</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('cpl.create') }}"
                       class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center"
                       style="background-color: rgba(22,163,74,.6);">
                        <i class="fas fa-plus-circle me-2"></i> Tambah CPL Baru
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="glass-card rounded-lg p-4 mb-4 text-green-200 border border-green-400">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="glass-card rounded-lg p-4 mb-4 text-red-200 border border-red-400">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="glass-card rounded-lg overflow-hidden shadow-lg">
                {{-- CSS lokal untuk tabel CPL --}}
                <style>
                    table.cpl-table { table-layout: fixed; width: 100%; }
                    .cpl-desc {
                        white-space: normal;
                        overflow-wrap: break-word;
                        word-break: break-word;
                        hyphens: auto;
                    }
                </style>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 cpl-table" lang="id">
                        {{-- Kode (140px), Deskripsi (fleksibel), Aksi (220px) --}}
                        <colgroup>
                            <col style="width:140px;">
                            <col>
                            <col style="width:220px;">
                        </colgroup>

                        <thead class="bg-white/10">
                            <tr>
<<<<<<< HEAD
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kode CPL</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
=======
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kode
                                    CPL</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Deskripsi</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Threshold (%)</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi
                                </th>
>>>>>>> 349879a2ffcb181c7fc6f136869fccf3cce385be
                            </tr>
                        </thead>

                        <tbody class="bg-white/10 divide-y divide-gray-200">
                            @forelse($cpls as $cpl)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white font-medium align-top">
                                        {{ $cpl->kode_cpl }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-white align-top">
                                        <div class="cpl-desc">
                                            {!! nl2br(e($cpl->deskripsi)) !!}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white align-top">
                                        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                                            <a href="{{ route('cpl.edit', $cpl->id) }}"
                                               class="glass-button px-3 py-1"
                                               style="background-color: rgba(245,158,11,.6);">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('cpl.destroy', $cpl->id) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus CPL {{ $cpl->kode_cpl }}?');"
                                                  style="display:inline; margin:0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="glass-button px-3 py-1"
                                                        style="background-color: rgba(220,38,38,.6);">
                                                    <i class="fas fa-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center">
                                        <i class="fas fa-exclamation-circle me-2"></i> Belum ada data CPL.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($cpls instanceof \Illuminate\Contracts\Pagination\Paginator || (method_exists($cpls, 'hasPages') && $cpls->hasPages()))
                    <div class="px-6 py-3 bg-white/5 border-t border-white/10">
                        {{ $cpls->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
