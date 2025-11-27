@extends('layouts.wadir1.app')
@section('title', 'Detail Bobot CPL-MK - Wadir 1')
@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
      <div class="bg-blue-600 px-6 py-4">
        <h1 class="text-xl font-bold text-white">Detail Bobot</h1>
      </div>
      <div class="p-6">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div><dt class="text-gray-500">Kode MK</dt><dd class="font-medium">{{ $kode_mk ?? '-' }}</dd></div>
          <div><dt class="text-gray-500">Kode CPL</dt><dd class="font-medium">{{ $kode_cpl ?? '-' }}</dd></div>
        </dl>
        <div class="mt-4">
          <dt class="text-gray-500">Bobot</dt>
          <dd class="font-medium text-lg">{{ $bobot ?? '-' }}</dd>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
