@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header (dengan ikon seperti Admin) -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Tahun Kurikulum</h1>
                        <p class="mt-1 text-sm text-gray-600">Kelola tahun kurikulum program studi</p>
                    </div>
                </div>
                
                <a href="{{ route('tim.tahun.create') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                    <i class="fas fa-plus mr-2 text-sm"></i>
                    Tambah Tahun
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

        @if (session('sukses'))
        <div id="alert-sukses" class="mb-6 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-800">Perhatian!</h3>
                    <p class="mt-1 text-sm text-red-700">{{ session('sukses') }}</p>
                </div>
                <button onclick="this.closest('#alert-sukses').remove()" 
                        class="ml-4 text-red-500 hover:text-red-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        <!-- Main Card (diselaraskan dengan Admin) -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">

            <!-- Card Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-between">
                <div>
                    <h2 class="text-lg md:text-xl font-semibold text-white">Daftar Tahun Kurikulum</h2>
                    <p class="mt-1 text-xs md:text-sm text-blue-100">
                        Ringkasan tahun ajaran yang digunakan pada program studi.
                    </p>
                </div>
                <div class="hidden sm:flex items-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-medium text-blue-50 shadow-sm">
                        <i class="fas fa-layer-group mr-2 text-[11px]"></i>
                        {{ $tahuns->total() }} Tahun
                    </span>
                </div>
            </div>

            <!-- Card Toolbar: deskripsi + search -->
            <div class="px-6 py-4 border-b border-gray-200 bg-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-sm text-gray-600">
                            Kelola penambahan, pengeditan, dan penghapusan tahun kurikulum.
                        </p>
                    </div>
                    <div class="w-full md:w-72">
                        <div class="relative">
                            <input
                                type="text"
                                id="search"
                                placeholder="Cari tahun ajaran..."
                                class="pl-9 pr-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400 w-full"
                            >
                            <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            @if ($tahuns->isEmpty())
                <!-- Empty State -->
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="empty-state-title">Belum Ada Tahun Kurikulum</h3>
                    <p class="empty-state-text">
                        Klik tombol "Tambah Tahun" untuk menambahkan tahun ajaran baru.
                    </p>
                </div>
            @else
                <!-- Table -->
                <div class="overflow-x-auto bg-gray-50">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-[#1e3c72] to-[#2a5298] text-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-16">
                                    <div class="flex items-center">
                                        <i class="fas fa-hashtag mr-2"></i>
                                        No
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider w-40">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        Tahun Ajaran
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-book-open mr-2"></i>
                                        Nama Kurikulum
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider w-32">
                                    <div class="flex items-center justify-center">
                                        <i class="fas fa-tools mr-2"></i>
                                        Aksi
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @foreach ($tahuns as $index => $tahun)
                            <tr class="hover:bg-blue-50 transition-colors duration-150">
                                <td class="px-4 py-3 whitespace-nowrap text-center font-medium text-gray-800">
                                    {{ $tahuns->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-sm">
                                        {{ $tahun->tahun }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-green-500 to-green-600 text-white shadow-sm">
                                        {{ ucfirst($tahun->nama_kurikulum) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('tim.tahun.edit', $tahun->id_tahun) }}" 
                                           class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                           title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('tim.tahun.destroy', $tahun->id_tahun) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Yakin ingin menghapus tahun ini?')"
                                                    class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-all duration-200"
                                                    title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($tahuns->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $tahuns->links() }}
                </div>
                @endif
            @endif

        </div>
    </div>
</div>

@push('scripts')
<script>
// Search functionality (client-side)
document.getElementById('search').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

// Auto-hide alerts
setTimeout(function() {
    ['alert-success', 'alert-sukses'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('animate-fade-out');
            setTimeout(() => el.remove(), 300);
        }
    });
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

.empty-state {
    padding: 4rem 1.5rem;
    text-align: center;
    background-color: #ffffff;
}

.empty-state-icon {
    width: 6rem;
    height: 6rem;
    margin-left: auto;
    margin-right: auto;
    color: #d1d5db;
}

.empty-state-title {
    margin-top: 1rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: #111827;
}

.empty-state-text {
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: #6b7280;
    max-width: 28rem;
    margin-left: auto;
    margin-right: auto;
}
</style>
@endpush
@endsection
