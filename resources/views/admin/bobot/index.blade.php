@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Bobot CPL - MK</h1>
            <p class="mt-2 text-sm text-gray-600">Bobot capaian profil lulusan per mata kuliah</p>
        </div>

        <!-- Alerts -->
        @if (session('success'))
        <div id="alert-success" class="mb-6 rounded-lg bg-green-50 border-l-4 border-green-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-green-800">Berhasil!</h3>
                    <p class="mt-1 text-sm text-green-700">{{ session('success') }}</p>
                </div>
                <button onclick="this.closest('#alert-success').remove()" 
                        class="ml-4 text-green-500 hover:text-green-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th class="w-16">No</th>
                            <th class="w-32">Kode CPL</th>
                            <th>Deskripsi CPL</th>
                            <th class="w-40">Mata Kuliah</th>
                            <th class="w-32">Bobot</th>
                            <th class="w-32">Total Bobot</th>
                            <th class="w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grouped = $bobots->groupBy('id_cpl');
                        @endphp
                        @foreach ($grouped as $id_cpl => $items)
                            @php
                                $cpl = $items->first()->capaianProfilLulusan;
                                $totalBobot = $items->sum('bobot');
                            @endphp
                            <tr class="align-top">
                                <td class="text-center font-medium">{{ $loop->iteration }}</td>
                                
                                <td>
                                    <span class="badge-modern badge-blue font-bold">{{ $cpl->kode_cpl }}</span>
                                </td>
                                
                                <td class="text-sm text-gray-700">
                                    {{ $cpl->deskripsi_cpl }}
                                </td>
                                
                                <td>
                                    <div class="space-y-1">
                                        @foreach ($items as $item)
                                            <div class="badge-modern badge-purple text-xs">{{ $item->kode_mk }}</div>
                                        @endforeach
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="space-y-1">
                                        @foreach ($items as $item)
                                            <div class="text-sm font-medium text-gray-900">{{ $item->bobot }}%</div>
                                        @endforeach
                                    </div>
                                </td>
                                
                                <td class="text-center">
                                    <div class="inline-flex items-center px-4 py-2 rounded-lg font-bold text-lg
                                                {{ $totalBobot == 100 ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $totalBobot }}%
                                    </div>
                                    @if($totalBobot != 100)
                                        <p class="text-xs text-amber-600 mt-1">Belum 100%</p>
                                    @endif
                                </td>
                                
                                <td class="text-center">
                                    <a href="{{ route('admin.bobot.detail', $id_cpl) }}"
                                       class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all duration-200 inline-block"
                                       title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-hide alerts
setTimeout(function() {
    const el = document.getElementById('alert-success');
    if (el) {
        el.classList.add('animate-fade-out');
        setTimeout(() => el.remove(), 300);
    }
}, 5000);
</script>
@endpush
@endsection
