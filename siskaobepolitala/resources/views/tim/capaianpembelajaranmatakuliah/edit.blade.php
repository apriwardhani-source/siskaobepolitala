@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        {{-- Header (menyerupai create) --}}
        <div class="mb-6">
            <a href="{{ route('tim.capaianpembelajaranmatakuliah.index', ['id_tahun' => request('id_tahun', 1)]) }}"
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <span class="mr-2 text-base leading-none">&larr;</span>
                Kembali
            </a>
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-bullseye text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                        Edit Capaian Pembelajaran Mata Kuliah (CPMK)
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Perbarui CPMK dan keterkaitannya dengan CPL serta mata kuliah yang relevan.
                    </p>
                </div>
            </div>
        </div>

        {{-- Kartu Formulir --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-edit mr-2 text-sm"></i>
                    Formulir Edit CPMK
                </h2>
            </div>

            <div class="px-6 py-6">
                @if ($errors->any())
                    <div class="mb-5 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-red-800 mb-1">Terjadi kesalahan</h3>
                                <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('tim.capaianpembelajaranmatakuliah.update', $cpmk->id_cpmk) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- CPL Terkait --}}
                        <div class="space-y-2 md:col-span-2">
                            <label for="id_cpl" class="block text-sm font-semibold text-gray-800">
                                CPL Terkait
                            </label>
                            <select id="id_cpl" name="id_cpl"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                <option value="">Pilih CPL</option>
                                @foreach ($cpls as $cpl)
                                    <option value="{{ $cpl->id_cpl }}"
                                        {{ in_array($cpl->id_cpl, old('id_cpl') ? [old('id_cpl')] : $selectedCpls) ? 'selected' : '' }}>
                                        {{ $cpl->kode_cpl }} - {{ $cpl->deskripsi_cpl }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- MK Terkait (dinamis) --}}
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-800">
                                MK Terkait
                            </label>
                            <div id="mkList"
                                 class="mt-1 w-full p-3 border border-gray-300 rounded-lg bg-gray-50 max-h-72 overflow-y-auto min-h-[60px] text-sm">
                            </div>
                            <p class="italic text-blue-600 text-xs mt-1">
                                Centang mata kuliah yang akan dikaitkan dengan CPMK ini.
                            </p>
                        </div>

                        {{-- Kode & Deskripsi CPMK --}}
                        <div class="space-y-2">
                            <label for="kode_cpmk" class="block text-sm font-semibold text-gray-800">Kode CPMK</label>
                            <input type="text" name="kode_cpmk" id="kode_cpmk"
                                   value="{{ old('kode_cpmk', $cpmk->kode_cpmk) }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label for="deskripsi_cpmk" class="block text-sm font-semibold text-gray-800">Deskripsi CPMK</label>
                            <textarea id="deskripsi_cpmk" name="deskripsi_cpmk" rows="3"
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Tuliskan deskripsi CPMK secara ringkas dan jelas..." required>{{ old('deskripsi_cpmk', $cpmk->deskripsi_cpmk) }}</textarea>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('tim.capaianpembelajaranmatakuliah.index', ['id_tahun' => request('id_tahun')]) }}"
                           class="inline-flex items-center px-5 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            <i class="fas fa-times mr-2 text-xs"></i>
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                            <i class="fas fa-save mr-2 text-xs"></i>
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    const mkList = document.getElementById('mkList');
    const cplSelect = document.getElementById('id_cpl');
    const selectedMKs = @json(old('selected_mks', $selectedMKs));

    function loadMKs(selectedCPL) {
        if (!selectedCPL) {
            mkList.innerHTML = '<div class="text-gray-500 italic">Pilih CPL terlebih dahulu</div>';
            return;
        }

        mkList.innerHTML = '<div class="text-blue-500 italic">Memuat mata kuliah...</div>';

        const isLocal = window.location.hostname === 'localhost'
            || window.location.hostname === '127.0.0.1'
            || window.location.hostname.includes('local');

        let url;
        if (isLocal) {
            url = "{{ route('tim.capaianpembelajaranmatakuliah.getMKByCPL') }}";
        } else {
            url = window.location.protocol + '//' + window.location.host +
                "{{ route('tim.capaianpembelajaranmatakuliah.getMKByCPL', [], false) }}";
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: JSON.stringify({ id_cpls: [selectedCPL] })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                mkList.innerHTML = '';

                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(mk => {
                        const isChecked = selectedMKs.includes(mk.kode_mk) ? 'checked' : '';
                        mkList.innerHTML += `
                            <label class="block my-1">
                                <input type="checkbox" name="selected_mks[]" value="${mk.kode_mk}" class="mr-2" ${isChecked}>
                                ${mk.kode_mk} - ${mk.nama_mk}
                            </label>`;
                    });

                    mkList.innerHTML += `
                        <div class="mt-3 pt-2 border-t">
                            <button type="button" id="selectAllMK" class="text-sm text-blue-600 mr-3">Pilih Semua</button>
                            <button type="button" id="deselectAllMK" class="text-sm text-red-600">Hapus Semua</button>
                        </div>`;

                    document.getElementById('selectAllMK').addEventListener('click', () => {
                        mkList.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = true);
                    });

                    document.getElementById('deselectAllMK').addEventListener('click', () => {
                        mkList.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                    });
                } else {
                    mkList.innerHTML = '<div class="text-red-500 italic">Tidak ada MK terkait</div>';
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                mkList.innerHTML = `<div class="text-red-500 italic">Gagal memuat MK: ${error.message}</div>`;
            });
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadMKs(cplSelect.value);
    });

    cplSelect.addEventListener('change', function () {
        loadMKs(this.value);
    });

    document.querySelector('form').addEventListener('submit', function (e) {
        if (document.querySelectorAll('input[name="selected_mks[]"]:checked').length === 0) {
            e.preventDefault();
            alert('Pilih minimal satu MK terlebih dahulu!');
        }
    });
</script>
@endpush
@endsection
