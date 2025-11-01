@extends('layouts.wadir1.app')
@section('content')
<div class="p-6 space-y-4">
    <h1 class="text-xl font-semibold">Edit Catatan</h1>
    <form method="post" action="{{ route('wadir1.notes.update', $note->id_note) }}" class="space-y-4 bg-white shadow rounded p-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm text-gray-600">Prodi</label>
            <select name="kode_prodi" class="border rounded px-2 py-1 w-full" required>
                @foreach(($prodis ?? []) as $p)
                    <option value="{{ $p->kode_prodi }}" @selected($note->kode_prodi==$p->kode_prodi)>{{ $p->nama_prodi }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-gray-600">Judul</label>
            <input name="title" class="border rounded px-2 py-1 w-full" value="{{ old('title', $note->title) }}" />
        </div>
        <div>
            <label class="block text-sm text-gray-600">Isi</label>
            <textarea name="note_content" rows="6" class="border rounded px-2 py-1 w-full">{{ old('note_content', $note->note_content) }}</textarea>
        </div>
        <button class="bg-blue-600 text-white px-3 py-1 rounded">Update</button>
    </form>
</div>
@endsection

