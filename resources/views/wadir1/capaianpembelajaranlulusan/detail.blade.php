@extends('layouts.wadir1.app')
@section('content')
<div class="p-6 space-y-4">
    <h1 class="text-xl font-semibold">Detail CPL</h1>
    <div class="bg-white shadow rounded p-4">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><dt class="text-gray-500">Kode</dt><dd class="font-medium">{{ $id_cpl->kode_cpl ?? '-' }}</dd></div>
            <div class="md:col-span-2"><dt class="text-gray-500">Deskripsi</dt><dd class="font-medium">{{ $id_cpl->deskripsi_cpl ?? '-' }}</dd></div>
        </dl>
    </div>
    <div class="bg-white shadow rounded p-4">
        <h2 class="font-semibold mb-2">Profil Lulusan Terkait</h2>
        <ul class="list-disc pl-5">
            @foreach(($profilLulusans ?? []) as $pl)
                <li>{{ $pl->kode_pl }} — {{ $pl->deskripsi_pl }}</li>
            @endforeach
            @if(($profilLulusans ?? collect())->isEmpty())
                <li class="list-none text-gray-600">Tidak ada data.</li>
            @endif
        </ul>
    </div>
</div>
@endsection
