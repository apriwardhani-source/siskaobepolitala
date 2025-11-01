@extends('layouts.app')
@section('title', 'Detail Sub CPMK - Wadir 1')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
      <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
        <h1 class="text-xl font-bold text-white">Detail Sub CPMK</h1>
      </div>
      <div class="p-6">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div><dt class="text-gray-500">Kode CPMK</dt><dd class="font-medium">{{ $subcpmk->cpmk->kode_cpmk ?? '-' }}</dd></div>
          <div class="md:col-span-2"><dt class="text-gray-500">Sub CPMK</dt><dd class="font-medium">{{ $subcpmk->sub_cpmk ?? '-' }}</dd></div>
          <div class="md:col-span-2"><dt class="text-gray-500">Uraian</dt><dd class="font-medium">{{ $subcpmk->uraian_cpmk ?? '-' }}</dd></div>
        </dl>
      </div>
    </div>
  </div>
</div>
@endsection

