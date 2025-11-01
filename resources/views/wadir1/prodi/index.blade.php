@extends('layouts.wadir1.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold mb-4">Daftar Prodi</h1>
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Kode</th>
                    <th class="px-4 py-2 text-left">Nama Prodi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prodis ?? [] as $prodi)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $prodi->kode_prodi }}</td>
                        <td class="px-4 py-2">{{ $prodi->nama_prodi }}</td>
                    </tr>
                @empty
                    <tr><td class="px-4 py-4" colspan="2">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

