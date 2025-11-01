@extends('layouts.app')
@section('content')
<div class="p-6 space-y-4">
    <h1 class="text-xl font-semibold">Organisasi Mata Kuliah per Semester</h1>
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
        <button class="bg-blue-600 text-white px-3 py-1 rounded">Filter</button>
    </form>

    @foreach(($organisasiMK ?? collect()) as $row)
        <div class="bg-white shadow rounded p-4">
            <h2 class="font-semibold">Semester {{ $row['semester_mk'] }}</h2>
            <div class="text-sm text-gray-600 mb-2">Total SKS: {{ $row['sks_mk'] }} | Jumlah MK: {{ $row['jumlah_mk'] }}</div>
            <ul class="list-disc pl-5">
                @foreach(($row['nama_mk'] ?? []) as $nm)
                    <li>{{ $nm }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
    @if(($organisasiMK ?? collect())->isEmpty() && !empty($kode_prodi))
        <div class="text-gray-600">Data kosong untuk filter yang dipilih.</div>
    @endif
</div>
@endsection
