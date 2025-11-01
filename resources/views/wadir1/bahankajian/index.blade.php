@extends('layouts.wadir1.app')
@section('content')
<div class="p-6 space-y-4">
    <h1 class="text-xl font-semibold">Bahan Kajian</h1>
    <form method="get" class="flex gap-2 items-end">
        <div>
            <label class="text-sm text-gray-600">Prodi</label>
            <select name="kode_prodi" class="border rounded px-2 py-1">
                <option value="">-- pilih prodi --</option>
                @foreach(($prodis ?? []) as $p)
                    <option value="{{ $p->kode_prodi }}" @selected(($kode_prodi ?? '')==$p->kode_prodi)>{{ $p->nama_prodi }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-sm text-gray-600">Tahun</label>
            <select name="id_tahun" class="border rounded px-2 py-1">
                <option value="">-- semua --</option>
                @foreach(($tahun_tersedia ?? []) as $t)
                    <option value="{{ $t->id_tahun }}" @selected(($id_tahun ?? '')==$t->id_tahun)>{{ $t->tahun }}</option>
                @endforeach
            </select>
        </div>
        <button class="bg-blue-600 text-white px-3 py-1 rounded">Filter</button>
    </form>

    @if(isset($kode_prodi) && $kode_prodi!=='' && ($dataKosong ?? false))
        <div class="text-gray-600">Data kosong untuk filter yang dipilih.</div>
    @endif

    @if(($bahankajians ?? collect())->isNotEmpty())
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Kode BK</th>
                <th class="px-4 py-2 text-left">Nama</th>
                <th class="px-4 py-2 text-left">Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bahankajians as $bk)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $bk->kode_bk }}</td>
                    <td class="px-4 py-2">{{ $bk->nama_bk }}</td>
                    <td class="px-4 py-2">{{ $bk->status_bk }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection

