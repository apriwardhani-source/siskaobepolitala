@extends('layouts.wadir1.app')
@section('content')
<div class="p-6 space-y-4">
    <h1 class="text-xl font-semibold">Catatan</h1>
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Judul</th>
                    <th class="px-4 py-2 text-left">Prodi</th>
                    <th class="px-4 py-2 text-left">Oleh</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($notes ?? []) as $n)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $n->title }}</td>
                        <td class="px-4 py-2">{{ optional($n->prodi)->nama_prodi ?? '-' }}</td>
                        <td class="px-4 py-2">{{ optional($n->user)->name ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('wadir1.notes.detail', $n->id_note) }}" class="text-blue-600">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-4 py-4" colspan="4">Tidak ada catatan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
