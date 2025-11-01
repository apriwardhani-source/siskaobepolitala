@extends('layouts.wadir1.app')

@section('content')
<div class="p-6 space-y-4">
    <h1 class="text-xl font-semibold">Detail Pengguna</h1>
    <div class="bg-white shadow rounded p-4">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><dt class="text-gray-500">Nama</dt><dd class="font-medium">{{ $user->name ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Email</dt><dd class="font-medium">{{ $user->email ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Role</dt><dd class="font-medium uppercase">{{ $user->role ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Prodi</dt><dd class="font-medium">{{ optional($user->prodi)->nama_prodi ?? '-' }}</dd></div>
        </dl>
    </div>
</div>
@endsection

