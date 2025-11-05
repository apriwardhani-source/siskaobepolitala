@extends('layouts.app')
@section('content')
<div class="p-6 space-y-4">
    <h1 class="text-xl font-semibold">Peta Pemenuhan CPL</h1>
    <form method="get" class="flex gap-2 items-end">
        <div>
            <label class="text-sm text-gray-600">Prodi</label>
            <select name="kode_prodi" class="border rounded px-2 py-1">
                <option value="">-- pilih prodi --</option>
                @foreach(($prodis ?? []) as $p)
                    <option value="{{ $p->kode_prodi }}" @selected(($kode_prodi ?? '')==$p->kode_prodi)>{{ $p->nama_prodi }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-sm text-gray-600">Tahun</label>
            <select name="id_tahun" class="border rounded px-2 py-1">
                <option value="">-- semua --</option>
                @foreach(($tahun_tersedia ?? []) as $t)
                    <option value="{{ $t->id_tahun }}" @selected(($id_tahun ?? '')==$t->id_tahun)>{{ $t->tahun }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="w-full px-6 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
            <i class="fas fa-search mr-2"></i> Tampilkan Data
        </button>
    </form>

    @if(($petaCPL ?? []) && !empty($kode_prodi))
        @foreach($petaCPL as $cplId => $row)
            <div class="bg-white shadow rounded p-4">
                <h2 class="font-semibold">CPL {{ $row['label'] ?? $cplId }}</h2>
                @foreach(($row['semester'] ?? []) as $semester => $mks)
                    <div class="mt-2">
                        <div class="text-sm text-gray-600">{{ $semester }}</div>
                        <ul class="list-disc pl-5">
                            @foreach($mks as $mk)
                                <li>{{ $mk }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @endforeach
    @elseif(!empty($kode_prodi))
        <div class="text-gray-600">Data kosong untuk filter yang dipilih.</div>
    @endif
</div>
@endsection
