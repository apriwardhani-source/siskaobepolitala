@extends('layouts.wadir1.app')
@section('content')
<div class="p-6 space-y-4">
    <h1 class="text-xl font-semibold">Tambah Catatan</h1>
    <form method="post" action="{{ route('wadir1.notes.store') }}" class="space-y-4 bg-white shadow rounded p-4">
        @csrf
        <div>
            <label class="block text-sm text-gray-600">Prodi</label>
            <select name="kode_prodi" class="border rounded px-2 py-1 w-full" required>
                <option value="">-- pilih prodi --</option>
                @foreach(($prodis ?? []) as $p)
                    <option value="{{ $p->kode_prodi }}">{{ $p->nama_prodi }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-gray-600">Judul</label>
            <input name="title" class="border rounded px-2 py-1 w-full" required />
        </div>
        <div>
            <label class="block text-sm text-gray-600">Isi</label>
            <textarea name="note_content" rows="6" class="border rounded px-2 py-1 w-full" required></textarea>
        </div>
        <button class="bg-blue-600 text-white px-3 py-1 rounded">Simpan</button>
    </form>
</div>
@endsection

