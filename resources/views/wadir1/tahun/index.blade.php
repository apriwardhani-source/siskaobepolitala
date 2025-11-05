@extends('layouts.wadir1.app')
@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold mb-4">Tahun Kurikulum</h1>
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Nama Kurikulum</th>
                    <th class="px-4 py-2 text-left">Tahun</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($tahuns ?? []) as $t)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $t->nama_kurikulum }}</td>
                        <td class="px-4 py-2">{{ $t->tahun }}</td>
                    </tr>
                @empty
                    <tr><td class="px-4 py-4" colspan="2">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

