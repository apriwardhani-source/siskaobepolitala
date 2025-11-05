@extends('layouts.wadir1.app')
@section('content')
<div class="p-6 space-y-4">
    <h1 class="text-xl font-semibold">Detail Catatan</h1>
    <div class="bg-white shadow rounded p-4 space-y-2">
        <div class="text-sm text-gray-500">Prodi: {{ optional($note->prodi)->nama_prodi ?? '-' }}</div>
        <h2 class="text-lg font-semibold">{{ $note->title }}</h2>
        <div class="whitespace-pre-line">{{ $note->note_content }}</div>
    </div>
</div>
@endsection

