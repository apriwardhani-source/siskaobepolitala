@extends('layouts.app')

@section('title', 'Kelola Data CPMK per CPL')

@section('content')
<<<<<<< HEAD
<div class="max-w-6xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">Kelola Data CPMK per CPL</h1>
                <p class="text-sm text-gray-300 mt-1">Daftar hubungan antara CPL dan CPMK-nya (satu CPL bisa memiliki banyak CPMK).</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('cpmk.create') }}" class="glass-button text-lg">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Banyak CPMK
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="glass-card rounded-lg p-4 mb-4 text-green-200 border border-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if($cpmks->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-white border border-white/30 border-collapse">
                <thead class="bg-white/10 border-b border-white/30">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Kode CPL</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Deskripsi CPL</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Kode CPMK</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Deskripsi CPMK</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Jumlah MK</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white/5">
                    @forelse($cpmks->groupBy('cpl.id') as $cplId => $cpmksPerCpl)
                        @php
                            $cpl = $cpmksPerCpl->first()->cpl;
                            $count = $cpmksPerCpl->count();
                        @endphp
                        @foreach($cpmksPerCpl as $index => $cpmk)
                            <tr class="hover:bg-white/5">
                                @if($index == 0)
                                <td class="px-4 py-3 align-top border border-white/20" rowspan="{{ $count }}">{{ $loop->parent->iteration }}</td>
                                <td class="px-4 py-3 align-top font-semibold border border-white/20" rowspan="{{ $count }}">{{ $cpl->kode_cpl ?? '-' }}</td>
                                <td class="px-4 py-3 align-top border border-white/20" rowspan="{{ $count }}">{!! nl2br(e($cpl->deskripsi ?? '-')) !!}</td>
                                @endif
                                <td class="px-4 py-3 align-top font-semibold border border-white/20">{{ $cpmk->kode_cpmk }}</td>
                                <td class="px-4 py-3 align-top border border-white/20">{!! nl2br(e($cpmk->deskripsi)) !!}</td>
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
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-300 border border-white/20">
                                <i class="fas fa-info-circle me-1"></i> Belum ada data CPMK.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
=======
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
>>>>>>> acc8a3e44542c0d028632212aa45ad2bf6542950
        </div>
        @else
        <div class="text-center py-8">
            <p class="text-gray-300">Belum ada data CPMK.</p>
            <a href="{{ route('cpmk.create') }}" class="glass-button mt-4">
                <i class="fas fa-plus me-2"></i> Tambahkan CPMK Pertama
            </a>
        </div>
        @endif
    </div>
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $cpmks->links() }}
    </div>
@endsection