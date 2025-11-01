@extends('layouts.wadir1.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold mb-4">Daftar Pengguna</h1>
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Role</th>
                    <th class="px-4 py-2 text-left">Prodi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users ?? [] as $user)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2 uppercase">{{ $user->role }}</td>
                        <td class="px-4 py-2">{{ optional($user->prodi)->nama_prodi ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td class="px-4 py-4" colspan="4">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
 </div>
@endsection

