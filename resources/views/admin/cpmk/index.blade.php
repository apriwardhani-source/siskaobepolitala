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
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white/10">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">CPL
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kode
                                    CPMK</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white/10 divide-y divide-gray-200">
                            @php
                                // Ambil koleksi dari paginator (kalau pakai paginate)
                                $items = $cpmks instanceof \Illuminate\Pagination\LengthAwarePaginator
                                    ? $cpmks->getCollection()
                                    : collect($cpmks);

                                // Urut ASC "natural" oleh CPL lalu kode CPMK (CPL01 < CPL02 < CPL10; CPMK011 < CPMK012)
                                $sorted = $items->sort(function ($a, $b) {
                                    $cplA = optional($a->cpl)->kode_cpl ?? '';
                                    $cplB = optional($b->cpl)->kode_cpl ?? '';
                                    $byCpl = strnatcasecmp($cplA, $cplB);
                                    if ($byCpl !== 0)
                                        return $byCpl;
                                    return strnatcasecmp($a->kode_cpmk, $b->kode_cpmk);
                                });

                                // Kelompokkan per CPL
                                $grouped = $sorted->groupBy(fn($row) => optional($row->cpl)->kode_cpl ?? '-');
                            @endphp

                            @forelse ($grouped as $kodeCpl => $rows)
                                @php $rowspan = $rows->count();
                                $first = true; @endphp

                                @foreach ($rows as $cpmk)
                                    <tr>
                                        {{-- Kolom CPL (sekali per grup, pakai rowspan) --}}
                                        @if ($first)
                                            <td class="px-6 py-4 text-sm text-white font-semibold align-top" rowspan="{{ $rowspan }}">
                                                {{ $kodeCpl }}
                                            </td>
                                            @php $first = false; @endphp
                                        @endif

                                        {{-- Kolom Kode CPMK --}}
                                        <td class="px-6 py-4 text-sm text-white align-top">
                                            {{ $cpmk->kode_cpmk }}
                                        </td>

                                        {{-- Kolom Deskripsi CPMK (bukan deskripsi CPL) --}}
                                        <td class="px-6 py-4 text-sm text-white align-top whitespace-normal break-words">
    {!! nl2br(e($cpmk->deskripsi)) !!}
</td>


                                        {{-- Kolom Aksi --}}
                                        <td class="px-6 py-4 text-sm font-medium align-top">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('cpmk.edit', $cpmk->id) }}" class="glass-button-warning">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('cpmk.destroy', $cpmk->id) }}" method="POST" class="inline"
                                                    onsubmit="return confirm('Hapus CPMK ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="glass-button-danger">
                                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-300">Tidak ada data CPMK.</td>
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