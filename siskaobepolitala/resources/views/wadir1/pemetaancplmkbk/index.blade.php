@extends('layouts.wadir1.app')
@section('content')
<div class="p-6">
    <h1 class="text-xl font-semibold mb-4">Pemetaan CPL ↔ MK ↔ BK</h1>
    <div class="bg-white shadow rounded p-4">
        <pre class="text-sm whitespace-pre-wrap">{{ json_encode($relasi ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    </div>
</div>
@endsection

