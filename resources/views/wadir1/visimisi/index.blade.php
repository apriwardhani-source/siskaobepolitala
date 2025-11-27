@extends('layouts.wadir1.app')
@section('title','Visi & Misi - Wadir 1')
@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
  <div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center space-x-4">
      <div class="w-16 h-16 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
        <i class="fas fa-bullseye text-2xl"></i>
      </div>
      <div>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Visi & Misi Program Studi</h1>
        <p class="mt-1 text-sm text-gray-600">Tampilan ringkas untuk pemantauan Wadir 1</p>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-200 p-6">
      <h2 class="text-lg font-semibold text-gray-800 mb-2">Visi</h2>
      <p class="text-gray-700">{{ $visis->visi ?? 'Belum ada visi yang tercatat.' }}</p>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-200 p-6">
      <h2 class="text-lg font-semibold text-gray-800 mb-2">Misi</h2>
      <ol class="list-decimal pl-5 space-y-1">
        @forelse(($misis ?? []) as $m)
          <li class="text-gray-700">{{ $m->misi }}</li>
        @empty
          <li class="text-gray-500">Belum ada misi yang tercatat.</li>
        @endforelse
      </ol>
    </div>
  </div>
</div>
@endsection
