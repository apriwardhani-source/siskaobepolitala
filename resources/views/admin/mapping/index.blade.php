<!-- resources/views/admin/mapping/index.blade.php -->
@extends('layouts.app')

@section('title', 'Kelola Mapping CPMK → CPL')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">Kelola Mapping CPMK → CPL</h1>
                <p class="text-sm text-gray-300 mt-1">
                    Daftar semua mapping antara CPL, CPMK, dan Mata Kuliah yang tersedia.
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('mapping.create') }}"
                    class="glass-button text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Mapping Baru
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="glass-card rounded-lg p-4 mb-4 text-green-200 border border-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="glass-card rounded-lg p-4 mb-4 text-red-200 border border-red-400">
                {{ session('error') }}
            </div>
        @endif

        <div class="glass-card rounded-lg overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white/10">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                CPL
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                CPMK
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Mata Kuliah (Banyak)
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Bobot (%)
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/10 divide-y divide-gray-200">
                        @forelse ($mappings as $mapping)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white align-top">
                                    {{ $mapping->cpl->kode_cpl ?? '-' }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white align-top">
                                    {{ $mapping->cpmk->kode_cpmk ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-white align-top">
                                    @forelse ($mapping->mataKuliahs as $mk)
                                        <div class="mb-1">
                                            <i class="fas fa-book-open text-blue-300 me-1"></i>
                                           {{ $mk->kode_matkul }} - {{ $mk->nama_matkul }}
                                        </div>
                                    @empty
                                        <span class="text-gray-400 italic">Tidak ada mata kuliah</span>
                                    @endforelse
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white align-top">
                                    {{ number_format($mapping->bobot, 2) }}%
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium align-top">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('mapping.edit', $mapping->id) }}"
                                            class="glass-button-warning">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>

                                        <form action="{{ route('mapping.destroy', $mapping->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus mapping ini?')"
                                            class="inline">
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
                                <td colspan="5" class="px-6 py-4 text-center text-gray-300">
                                    <i class="fas fa-exclamation-circle me-2"></i> Tidak ada data mapping.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($mappings->hasPages())
                <div class="px-6 py-3 bg-white/5 border-t border-white/10">
                    {{ $mappings->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
