@extends('layouts.wadir1.app')
@section('content')
<div class="p-6 space-y-4">
    <h1 class="text-xl font-semibold">Detail Bahan Kajian</h1>
    <div class="bg-white shadow rounded p-4">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><dt class="text-gray-500">Kode</dt><dd class="font-medium">{{ $id_bk->kode_bk ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Nama</dt><dd class="font-medium">{{ $id_bk->nama_bk ?? '-' }}</dd></div>
            <div class="md:col-span-2"><dt class="text-gray-500">Deskripsi</dt><dd class="font-medium">{{ $id_bk->deskripsi_bk ?? '-' }}</dd></div>
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
</div>
@endsection

