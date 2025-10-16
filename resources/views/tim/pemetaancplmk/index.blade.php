@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-full mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pemetaan CPL - MK</h1>
            <p class="mt-2 text-sm text-gray-600">Matriks pemetaan capaian profil lulusan terhadap mata kuliah</p>
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
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Matriks Pemetaan</h2>
                        <p class="mt-1 text-sm text-gray-500">Centang menunjukkan CPL terpetakan ke MK</p>
                    </div>
                    
                    <!-- Filter -->
                    <div class="w-64">
                        <select id="tahun" name="id_tahun" onchange="updateFilter()"
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg 
                                   focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="" {{ empty($id_tahun) ? 'selected' : '' }}>Semua Tahun</option>
                            @if (isset($tahun_tersedia))
                                @foreach ($tahun_tersedia as $thn)
                                    <option value="{{ $thn->id_tahun }}" {{ $id_tahun == $thn->id_tahun ? 'selected' : '' }}>
                                        {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                                    </option>
                                @endforeach
                            @endif
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
                        <a href="{{ route('tim.pemetaancplmk.index') }}" 
                           class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-medium">
                            Reset filter
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Content -->
            @if($cpls->isEmpty())
                <!-- Empty State -->
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Tidak Ada Data Pemetaan</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Belum ada data pemetaan CPL-MK untuk tahun kurikulum yang dipilih.
                    </p>
                </div>
            @else
                <!-- Matrix Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-700 to-gray-800 sticky top-0">
                            <tr>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-gray-600 sticky left-0 bg-gradient-to-r from-gray-700 to-gray-800 z-10">
                                    CPL
                                </th>
                                @foreach ($mks as $mk)
                                    <th class="px-3 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-gray-600 whitespace-nowrap">
                                        {{ $mk->kode_mk }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($cpls as $index => $cpl)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4 border-r border-gray-300 font-semibold bg-gray-50 text-center sticky left-0 z-10 {{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-100' }}">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            {{ $cpl->kode_cpl }}
                                        </span>
                                    </td>
                                    @foreach ($mks as $mk)
                                        <td class="px-3 py-4 border-r border-gray-200 text-center {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                            @php
                                                $isMapped = false;
                                                if (isset($relasi[$mk->kode_mk])) {
                                                    foreach ($relasi[$mk->kode_mk] as $rel) {
                                                        if ($rel->id_cpl == $cpl->id_cpl) {
                                                            $isMapped = true;
                                                            break;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <div class="flex items-center justify-center">
                                                <div class="relative">
                                                    <input type="checkbox" 
                                                           {{ $isMapped ? 'checked' : '' }} 
                                                           disabled
                                                           class="w-6 h-6 text-green-600 bg-white border-2 border-gray-300 rounded 
                                                                  focus:ring-2 focus:ring-green-500 cursor-not-allowed
                                                                  {{ $isMapped ? 'checked-custom' : '' }}">
                                                    @if($isMapped)
                                                    <svg class="absolute top-0.5 left-0.5 w-5 h-5 text-white pointer-events-none" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Legend -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-center space-x-6 text-sm">
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 border-2 border-gray-300 rounded bg-green-600 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">= CPL terpetakan ke MK</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 border-2 border-gray-300 rounded bg-white"></div>
                            <span class="text-gray-700 font-medium">= Belum terpetakan</span>
                        </div>
                    </div>
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

    let url = "{{ route('tim.pemetaancplmk.index') }}";
    
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
/* Custom checkbox styling */
input[type="checkbox"]:checked.checked-custom {
    background-color: #10b981;
    border-color: #10b981;
}

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

/* Sticky column shadow */
.sticky {
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}
</style>
@endpush
@endsection
