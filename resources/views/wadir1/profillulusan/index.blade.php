@extends('layouts.wadir1.app')

@section('content')
<div class="p-6 space-y-4">
    <h1 class="text-xl font-semibold">Profil Lulusan</h1>
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
        <button type="submit" class="w-full px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
            <i class="fas fa-search mr-2"></i> Tampilkan Data
        </button>
    </form>

    @if(isset($kode_prodi) && $kode_prodi!=='' && ($profillulusans ?? collect())->isEmpty())
        <div class="text-gray-600">Data kosong untuk filter yang dipilih.</div>
    @endif

    @if(($profillulusans ?? collect())->isNotEmpty())
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Kode PL</th>
                <th class="px-4 py-2 text-left">Deskripsi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($profillulusans as $pl)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $pl->kode_pl }}</td>
                    <td class="px-4 py-2">{{ $pl->deskripsi_pl }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
