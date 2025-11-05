@extends('layouts.wadir1.app')

@section('content')
<div class="p-6 space-y-4">
    <h1 class="text-xl font-semibold">Detail Profil Lulusan</h1>
    <div class="bg-white shadow rounded p-4">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><dt class="text-gray-500">Kode PL</dt><dd class="font-medium">{{ $profillulusan->kode_pl ?? '-' }}</dd></div>
            <div class="md:col-span-2"><dt class="text-gray-500">Deskripsi</dt><dd class="font-medium">{{ $profillulusan->deskripsi_pl ?? '-' }}</dd></div>
        </dl>
    </div>
</div>
@endsection

