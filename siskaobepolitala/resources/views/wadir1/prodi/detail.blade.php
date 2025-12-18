@extends('layouts.wadir1.app')

@section('content')
<div class="p-6 space-y-4">
    <h1 class="text-xl font-semibold">Detail Prodi</h1>
    <div class="bg-white shadow rounded p-4">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><dt class="text-gray-500">Kode Prodi</dt><dd class="font-medium">{{ $prodi->kode_prodi ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Nama Prodi</dt><dd class="font-medium">{{ $prodi->nama_prodi ?? '-' }}</dd></div>
        </dl>
    </div>
</div>
@endsection

