@extends('layouts.app')

@section('title', 'Relasi MK ↔ CPL & CPMK')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/20">
            <div>
                <h1 class="text-2xl font-bold text-white">Relasi Mata Kuliah dengan CPL & CPMK</h1>
                <p class="text-sm text-gray-300 mt-1">Tampilan ini tidak menampilkan bobot. Bobot hanya terlihat di halaman Mapping.</p>
            </div>
            <a href="{{ route('admin.manage.matkul') }}" class="glass-button">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar MK
            </a>
        </div>

        <div class="glass-card rounded-lg overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full text-white border border-white/30 border-collapse">
                    <thead class="bg-white/10 border-b border-white/30">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">MK</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Nama MK</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">CPL</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">CPMK</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">Uraian CPMK</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border border-white/30">SUB-CPMK</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/5">
                        @forelse ($grouped as $item)
                            @php $count = max(1, count($item['rows'])); @endphp
                            @if ($count === 1 && empty($item['rows']))
                                <tr class="hover:bg-white/5">
                                    <td class="px-6 py-4 border border-white/20">{{ $item['mk']->kode_matkul }}</td>
                                    <td class="px-6 py-4 border border-white/20">{{ $item['mk']->nama_matkul }}</td>
                                    <td colspan="4" class="px-6 py-4 text-gray-300 border border-white/20">Belum ada relasi CPL/CPMK.</td>
                                </tr>
                            @else
                                @foreach ($item['rows'] as $index => $row)
                                    <tr class="hover:bg-white/5">
                                        @if ($index == 0)
                                            <td class="px-6 py-4 border border-white/20 align-top" rowspan="{{ $count }}">{{ $item['mk']->kode_matkul }}</td>
                                            <td class="px-6 py-4 border border-white/20 align-top" rowspan="{{ $count }}">{{ $item['mk']->nama_matkul }}</td>
                                        @endif
                                        <td class="px-6 py-4 border border-white/20">{{ $row['cpl'] }}</td>
                                        <td class="px-6 py-4 border border-white/20">{{ $row['cpmk'] }}</td>
                                        <td class="px-6 py-4 border border-white/20">{{ Str::limit($row['uraian'], 150) }}</td>
                                        <td class="px-6 py-4 border border-white/20">{!! nl2br(e($row['sub'])) !!}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-300 border border-white/20">
                                    Tidak ada data mata kuliah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
