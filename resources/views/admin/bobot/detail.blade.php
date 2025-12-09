@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header menyesuaikan detail tim -->
        <div class="mb-6">
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-arrow-left mr-2 text-xs"></i>
                Kembali
            </a>
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-weight-hanging text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                        Detail Bobot MK - CPL
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Lihat CPL yang berkontribusi pada mata kuliah ini beserta bobotnya.
                    </p>
                </div>
            </div>
        </div>

        <!-- Card utama -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-plus-circle mr-2 text-sm"></i>
                    Detail Bobot MK - CPL
                </h2>
                <div class="text-xs text-blue-100">
                    Total Bobot: 
                    <span id="totalBobot" class="font-semibold text-white">{{ $totalBobot ?? 0 }}%</span>
                </div>
            </div>

            <div class="px-6 py-6 space-y-6">
                <!-- Informasi MK -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-800">Mata Kuliah</label>
                    <div class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-900">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                            {{ $mk->kode_mk }}
                        </span>
                        <span class="ml-2">
                            {{ $mk->nama_mk }}
                        </span>
                    </div>
                </div>

                <!-- Distribusi Bobot CPL -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-semibold text-gray-800">
                            Daftar CPL dan Bobot Kontribusi
                        </label>
                        <span class="text-xs text-gray-500">
                            Setiap baris menampilkan CPL yang dipetakan ke mata kuliah ini beserta bobot persentasenya.
                        </span>
                    </div>
                    <div id="cplList"
                         class="border border-gray-200 rounded-lg bg-gray-50 max-h-[320px] overflow-y-auto divide-y divide-gray-200">
                        @forelse ($cpls as $cpl)
                            <div class="flex items-center justify-between bg-white px-4 py-3">
                                <div class="flex-1 pr-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $cpl->kode_cpl }}
                                    </span>
                                    <span class="ml-2 text-sm text-gray-900">
                                        {{ $cpl->deskripsi_cpl }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs text-gray-500">Bobot</span>
                                    <input type="number"
                                           disabled readonly min="0" max="100"
                                           value="{{ $cpl->bobot ?? 0 }}"
                                           class="w-20 px-3 py-1.5 border border-gray-300 rounded-lg text-center text-sm bg-gray-100 text-gray-800 bobot-input">
                                    <span class="text-xs text-gray-500">%</span>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-3 text-sm text-gray-500 italic">
                                Belum ada CPL yang dipetakan ke mata kuliah ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.bobot-input').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        const totalBobot = document.getElementById('totalBobot');
        if (totalBobot) {
            totalBobot.textContent = total + '%';
        }
    }

    updateTotal();
</script>
@endpush
@endsection
