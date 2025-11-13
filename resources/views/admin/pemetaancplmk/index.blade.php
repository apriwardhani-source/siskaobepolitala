@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-full mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pemetaan CPL - MK</h1>
            <p class="mt-2 text-sm text-gray-600">Matriks pemetaan capaian profil lulusan dengan mata kuliah</p>
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
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <h2 class="text-lg font-semibold text-gray-900">Matriks Pemetaan</h2>
                    
                    <!-- Filters -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <select id="prodi" name="kode_prodi" onchange="updateFilter()"
                                class="select-modern">
                            <option value="" {{ empty($kode_prodi) ? 'selected' : '' }} disabled>Pilih Prodi</option>
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi->kode_prodi }}" {{ $kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>

                        <select id="tahun" name="id_tahun" onchange="updateFilter()"
                                class="select-modern">
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
                @if ($kode_prodi || $id_tahun)
                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-sm text-blue-800 font-medium">Filter aktif:</span>
                        @if ($kode_prodi)
                            <span class="badge-modern badge-blue">
                                Prodi: {{ $prodis->where('kode_prodi', $kode_prodi)->first()->nama_prodi ?? $kode_prodi }}
                            </span>
                        @endif
                        @if ($id_tahun)
                            @php
                                $selected_tahun = $tahun_tersedia->firstWhere('id_tahun', $id_tahun);
                            @endphp
                            <span class="badge-modern badge-blue">
                                Tahun: {{ $selected_tahun ? $selected_tahun->nama_kurikulum . ' - ' . $selected_tahun->tahun : $id_tahun }}
                            </span>
                        @endif
                        <a href="{{ route('admin.pemetaancplmk.index') }}" 
                           class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-medium">
                            Reset filter
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Content -->
            @if (!$kode_prodi)
                <!-- Empty State - No Prodi Selected -->
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <h3 class="empty-state-title">Pilih Program Studi</h3>
                    <p class="empty-state-text">
                        Silakan pilih program studi terlebih dahulu untuk menampilkan matriks pemetaan.
                    </p>
                </div>
            @elseif ($cpls->isEmpty())
                <!-- Empty State - No Data -->
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="empty-state-title">Belum Ada Data Pemetaan</h3>
                    <p class="empty-state-text">
                        Data belum dibuat untuk program studi ini.
                    </p>
                </div>
            @else
                <!-- Info Banner -->
                <div class="px-6 py-4 bg-blue-50 border-b border-blue-200">
                    <p class="text-sm text-blue-800">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <strong>Tip:</strong> Arahkan cursor pada kode CPL atau kode MK untuk melihat deskripsi lengkap
                    </p>
                </div>

                <!-- Matrix Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead class="bg-gradient-to-r from-gray-700 to-gray-800 sticky top-0 z-20">
                            <tr>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-gray-600 sticky left-0 z-30 bg-gradient-to-r from-gray-700 to-gray-800">
                                    CPL / MK
                                </th>
                                @foreach ($mks as $mk)
                                    <th class="px-3 py-4 text-center text-xs font-semibold text-gray-100 border-r border-gray-600 min-w-[80px] relative group">
                                        <span class="cursor-help whitespace-nowrap">{{ $mk->kode_mk }}</span>
                                        <!-- Tooltip -->
                                        <div class="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 hidden group-hover:block w-80 bg-gray-900 text-white text-sm rounded-lg shadow-2xl z-50 animate-fade-in">
                                            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-lg px-4 py-2 font-bold">
                                                {{ $mk->nama_prodi }}
                                            </div>
                                            <div class="px-4 py-3 text-left leading-relaxed">
                                                <strong>{{ $mk->kode_mk }}</strong> - {{ $mk->nama_mk }}
                                            </div>
                                            <!-- Arrow -->
                                            <div class="absolute left-1/2 -translate-x-1/2 top-full">
                                                <div class="border-8 border-transparent border-t-gray-900"></div>
                                            </div>
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($cpls as $index => $cpl)
                                <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="px-4 py-4 border-r border-b border-gray-200 sticky left-0 z-10 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                        <div class="relative group">
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 cursor-help whitespace-nowrap">
                                                {{ $cpl->kode_cpl }}
                                            </span>
                                            
                                            <!-- Tooltip -->
                                            <div class="absolute left-full ml-2 top-1/2 -translate-y-1/2 hidden group-hover:block w-80 bg-gray-900 text-white text-sm rounded-lg shadow-2xl z-50 animate-fade-in">
                                                <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-lg px-4 py-2 font-bold">
                                                    {{ $prodiByCpl[$cpl->id_cpl] ?? 'Program Studi' }}
                                                </div>
                                                <div class="px-4 py-3 text-left leading-relaxed">
                                                    {{ $cpl->deskripsi_cpl }}
                                                </div>
                                                <!-- Arrow -->
                                                <div class="absolute right-full top-1/2 -translate-y-1/2">
                                                    <div class="border-8 border-transparent border-r-gray-900"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @foreach ($mks as $mk)
                                        <td class="px-4 py-4 text-center border-r border-b border-gray-200">
                                            <input type="checkbox" disabled
                                                {{ isset($relasi[$mk->kode_mk]) && in_array($cpl->id_cpl, $relasi[$mk->kode_mk]->pluck('id_cpl')->toArray()) ? 'checked' : '' }}
                                                class="h-6 w-6 mx-auto appearance-none rounded border-2 border-blue-500 bg-white checked:bg-blue-600 checked:border-blue-600 disabled:opacity-100 disabled:cursor-default relative transition-all duration-200">
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>

@push('styles')
<style>
/* Custom checkbox style */
input[type="checkbox"]:checked::before {
    content: "✓";
    color: white;
    font-size: 1.1rem;
    font-weight: bold;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* Sticky column shadow */
.sticky {
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

/* Smooth scroll for horizontal overflow */
.overflow-x-auto {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e0 #f7fafc;
}

.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f7fafc;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background-color: #cbd5e0;
    border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background-color: #a0aec0;
}
</style>
@endpush

@push('scripts')
<script>
function updateFilter() {
    const prodiSelect = document.getElementById('prodi');
    const tahunSelect = document.getElementById('tahun');

    const kodeProdi = prodiSelect.value;
    const idTahun = tahunSelect.value;

    let url = "{{ route('admin.pemetaancplmk.index') }}";
    let params = [];

    if (kodeProdi) {
        params.push('kode_prodi=' + encodeURIComponent(kodeProdi));
    }

    if (idTahun) {
        params.push('id_tahun=' + encodeURIComponent(idTahun));
    }

    if (params.length > 0) {
        url += '?' + params.join('&');
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
@endpush
@endsection
