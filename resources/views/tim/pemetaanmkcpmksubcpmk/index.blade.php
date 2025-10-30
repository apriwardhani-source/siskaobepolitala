@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-full mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pemetaan MK - CPMK - Sub CPMK</h1>
            <p class="mt-2 text-sm text-gray-600">Pemetaan mata kuliah, capaian pembelajaran, dan sub capaian pembelajaran</p>
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
                    <h2 class="text-lg font-semibold text-gray-900">Matriks Pemetaan</h2>
                    
                    <!-- Filter -->
                    @if(isset($tahun_tersedia))
                    <div class="w-64">
                        <select id="tahun" name="id_tahun" onchange="updateFilter()"
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg 
                                   focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="" {{ empty($id_tahun) ? 'selected' : '' }}>Semua Tahun</option>
                            @foreach ($tahun_tersedia as $thn)
                                <option value="{{ $thn->id_tahun }}" {{ isset($id_tahun) && $id_tahun == $thn->id_tahun ? 'selected' : '' }}>
                                    {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>

                <!-- Filter Info -->
                @if (isset($id_tahun) && $id_tahun)
                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-sm text-blue-800 font-medium">Filter aktif:</span>
                        @if(isset($tahun_tersedia))
                            @php
                                $selected_tahun = $tahun_tersedia->where('id_tahun', $id_tahun)->first();
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                Tahun: {{ $selected_tahun ? $selected_tahun->nama_kurikulum . ' - ' . $selected_tahun->tahun : $id_tahun }}
                            </span>
                        @endif
                        <a href="{{ route('tim.pemetaanmkcpmksubcpmk.index') }}" 
                           class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-medium">
                            Reset filter
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Info Banner -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm text-blue-900 font-medium">Matriks Pemetaan Tiga Dimensi</p>
                        <p class="text-xs text-blue-700 mt-1">Tabel ini menampilkan relasi antara Mata Kuliah (MK), Capaian Pembelajaran Mata Kuliah (CPMK), dan Sub CPMK dalam satu tampilan terintegrasi.</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            @if(empty($data) || count($data) === 0)
                <!-- Empty State -->
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Data Pemetaan</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Data pemetaan MK-CPMK-Sub CPMK belum tersedia. Silakan tambahkan data pemetaan terlebih dahulu.
                    </p>
                </div>
            @else
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-[#1e3c72] to-[#2a5298] sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-[#2a5298] w-16">
                                <div class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    No
                                </div>
                            </th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-[#2a5298] w-28">
                                <div class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                    </svg>
                                    Kode MK
                                </div>
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-[#2a5298]">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                    </svg>
                                    Nama MK
                                </div>
                            </th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-[#2a5298] w-28">
                                <div class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Kode CPMK
                                </div>
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-[#2a5298]">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    Deskripsi CPMK
                                </div>
                            </th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-[#2a5298] w-28">
                                <div class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Sub CPMK
                                </div>
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                    </svg>
                                    Uraian Sub CPMK
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($data as $index => $row)
                            <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700 font-medium border-r border-gray-200">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-purple-100 text-purple-800">
                                        {{ $row->kode_mk }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 border-r border-gray-200">
                                    {{ $row->nama_mk }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $row->kode_cpmk }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 border-r border-gray-200 leading-relaxed">
                                    {{ $row->deskripsi_cpmk }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center border-r border-gray-200">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-800">
                                        {{ $row->sub_cpmk }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 leading-relaxed">
                                    {{ $row->uraian_cpmk }}
                                </td>
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
/* Sticky header styling */
.sticky {
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

/* Smooth scroll for overflow */
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

/* Fade animations */
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

@push('scripts')
<script>
function updateFilter() {
    const tahunSelect = document.getElementById('tahun');
    const idTahun = tahunSelect.value;

    let url = "{{ route('tim.pemetaanmkcpmksubcpmk.index') }}";
    
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
@endpush
@endsection
