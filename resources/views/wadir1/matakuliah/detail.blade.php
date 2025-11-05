@extends('layouts.app')
@section('content')
<div class="p-6 space-y-4">
    <h1 class="text-xl font-semibold">Detail Mata Kuliah</h1>
    <div class="bg-white shadow rounded p-4">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><dt class="text-gray-500">Kode</dt><dd class="font-medium">{{ $matakuliah->kode_mk ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Nama</dt><dd class="font-medium">{{ $matakuliah->nama_mk ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">SKS</dt><dd class="font-medium">{{ $matakuliah->sks_mk ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Semester</dt><dd class="font-medium">{{ $matakuliah->semester_mk ?? '-' }}</dd></div>
        </dl>
    </div>

    <div class="bg-white shadow rounded p-4">
        <h2 class="font-semibold mb-2">CPL Terkait</h2>
        <ul class="list-disc pl-5">
            @foreach(($capaianprofillulusans ?? []) as $cpl)
                <li>{{ $cpl->kode_cpl }} — {{ $cpl->deskripsi_cpl }}</li>
            @endforeach
            @if(($capaianprofillulusans ?? collect())->isEmpty())
                <li class="list-none text-gray-600">Tidak ada data.</li>
            @endif
        </ul>
    </div>

    <div class="bg-white shadow rounded p-4">
        <h2 class="font-semibold mb-2">Bahan Kajian Terkait</h2>
        <ul class="list-disc pl-5">
            @foreach(($bahanKajians ?? []) as $bk)
                <li>{{ $bk->kode_bk }} — {{ $bk->nama_bk }}</li>
            @endforeach
            @if(($bahanKajians ?? collect())->isEmpty())
                <li class="list-none text-gray-600">Tidak ada data.</li>
            @endif
        </ul>
    </div>
</div>
@endsection
