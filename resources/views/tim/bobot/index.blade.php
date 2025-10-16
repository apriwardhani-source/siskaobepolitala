@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Bobot CPL - MK</h1>
                    <p class="mt-2 text-sm text-gray-600">Kelola bobot capaian profil lulusan terhadap mata kuliah</p>
                </div>
                
                <a href="{{ route('tim.bobot.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 
                          hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg 
                          shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200
                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Bobot
                </a>
            </div>
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
            
            <!-- Toolbar -->
            <div class="px-6 py-5 border-b border-gray-200 bg-white">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Bobot per CPL</h2>
                    
                    <!-- Filter -->
                    <div class="w-64">
                        <select id="tahun" name="id_tahun" onchange="updateFilter()"
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg 
                                   focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="" {{ empty($id_tahun) ? 'selected' : '' }}>Semua Tahun</option>
                            @foreach ($tahun_tersedia as $thn)
                                <option value="{{ $thn->id_tahun }}" {{ $id_tahun == $thn->id_tahun ? 'selected' : '' }}>
                                    {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Filter Info -->
                @if ($id_tahun)
                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-sm text-blue-800 font-medium">Filter aktif:</span>
                        @php
                            $selected_tahun = $tahun_tersedia->where('id_tahun', $id_tahun)->first();
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                            Tahun: {{ $selected_tahun ? $selected_tahun->nama_kurikulum . ' - ' . $selected_tahun->tahun : $id_tahun }}
                        </span>
                        <a href="{{ route('tim.bobot.index') }}" 
                           class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-medium">
                            Reset filter
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Content -->
            @if($bobots->isEmpty())
                <!-- Empty State -->
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Data Bobot</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Belum ada bobot CPL-MK. Klik tombol "Tambah Bobot" untuk menambahkan data baru.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('tim.bobot.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 
                                  text-white font-medium rounded-lg shadow-sm hover:shadow-md 
                                  transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Bobot Pertama
                        </a>
                    </div>
                </div>
            @else
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                            <tr>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-16">No</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Kode CPL</th>
                                <th scope="col" class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">CPL</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">MK</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-24">Bobot</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Total Bobot</th>
                                <th scope="col" class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $grouped = $bobots->groupBy('id_cpl');
                            @endphp
                            @foreach ($grouped as $id_cpl => $items)
                                @php
                                    $first = $items->first();
                                    $totalBobot = $items->sum('bobot');
                                @endphp
                                <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700 font-medium align-top" rowspan="{{ $items->count() }}">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center align-top" rowspan="{{ $items->count() }}">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            {{ $first->kode_cpl }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 align-top" rowspan="{{ $items->count() }}">
                                        {{ Str::limit($first->deskripsi_cpl, 100) }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $items->first()->kode_mk }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-semibold text-gray-900">
                                        {{ $items->first()->bobot }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center align-top" rowspan="{{ $items->count() }}">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold
                                                     {{ $totalBobot == 100 ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $totalBobot }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm align-top" rowspan="{{ $items->count() }}">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('tim.bobot.detail', $first->id_cpl) }}" 
                                               class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all duration-200"
                                               title="Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('tim.bobot.edit', $items->first()->id_bobot) }}" 
                                               class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                               title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @foreach ($items->skip(1) as $item)
                                <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $loop->parent->even ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $item->kode_mk }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-semibold text-gray-900">
                                        {{ $item->bobot }}
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>

@push('scripts')
<script>
function updateFilter() {
    const tahunSelect = document.getElementById('tahun');
    const idTahun = tahunSelect.value;

    let url = "{{ route('tim.bobot.index') }}";
    
    if (idTahun) {
        url += '?id_tahun=' + encodeURIComponent(idTahun);
    }

    window.location.href = url;
}

// Auto-hide alerts
setTimeout(function() {
    const el = document.getElementById('alert-success');
    if (el) {
        el.classList.add('animate-fade-out');
        setTimeout(() => el.remove(), 300);
    }
}, 5000);
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fade-out {
    from { opacity: 1; }
    to { opacity: 0; }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

.animate-fade-out {
    animation: fade-out 0.3s ease-out;
}
</style>
@endpush
@endsection
