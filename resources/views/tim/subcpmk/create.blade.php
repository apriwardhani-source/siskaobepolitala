@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        {{-- Header seperti admin CPL create --}}
        <div class="mb-6">
            <a href="{{ route('tim.subcpmk.index') }}"
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <span class="mr-2 text-base leading-none">&larr;</span>
                kembali
            </a>
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-list-ul text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                        Tambah Sub CPMK
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Tambahkan Sub CPMK baru dan kaitkan dengan CPMK serta mata kuliah terkait.
                    </p>
                </div>
            </div>
        </div>

        {{-- Kartu formulir --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-plus-circle mr-2 text-sm"></i>
                    Formulir Tambah Sub CPMK
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

                <form action="{{ route('tim.subcpmk.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Dropdown CPMK --}}
                        <div class="space-y-2 md:col-span-2">
                            <label for="id_cpmk" class="block text-sm font-semibold text-gray-800">
                                CPMK
                            </label>
                            <select name="id_cpmk" id="id_cpmk" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="" disabled selected>Pilih CPMK</option>
                                @foreach ($cpmks as $cpmk)
                                    <option value="{{ $cpmk->id_cpmk }}" {{ old('id_cpmk') == $cpmk->id_cpmk ? 'selected' : '' }}>
                                        {{ $cpmk->kode_cpmk }} - {{ $cpmk->deskripsi_cpmk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Dropdown MK --}}
                        <div class="space-y-2 md:col-span-2">
                            <label for="kode_mk" class="block text-sm font-semibold text-gray-800">
                                Mata Kuliah
                            </label>
                            <select name="kode_mk" id="kode_mk" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="" selected disabled>Pilih CPMK terlebih dahulu</option>
                            </select>
                        </div>

                        {{-- Sub CPMK --}}
                        <div class="space-y-2">
                            <label for="sub_cpmk" class="block text-sm font-semibold text-gray-800">
                                Sub CPMK
                            </label>
                            <input type="text" name="sub_cpmk" id="sub_cpmk" required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Contoh: a, b, c atau kode singkat"
                                   value="{{ old('sub_cpmk') }}">
                        </div>

                        {{-- Uraian --}}
                        <div class="space-y-2 md:col-span-2">
                            <label for="uraian_cpmk" class="block text-sm font-semibold text-gray-800">
                                Uraian Sub CPMK
                            </label>
                            <textarea name="uraian_cpmk" id="uraian_cpmk" rows="3" required
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Tuliskan uraian Sub CPMK secara ringkas dan jelas...">{{ old('uraian_cpmk') }}</textarea>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('tim.subcpmk.index') }}"
                           class="inline-flex items-center px-5 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            <i class="fas fa-times mr-2 text-xs"></i>
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                            <i class="fas fa-save mr-2 text-xs"></i>
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<!-- Script AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const getMkByCpmkUrl = "{{ route('tim.subcpmk.getMkByCpmk', [], false) }}";

    $(document).ready(function () {
        const cpmkSelect = $('#id_cpmk');
        const mkSelect = $('#kode_mk');

        // Nonaktifkan MK saat awal via JavaScript
        mkSelect.prop('disabled', true);

        cpmkSelect.on('change', function () {
            const cpmkId = $(this).val();

            if (cpmkId) {
                mkSelect.html('<option value="" selected disabled>Loading...</option>');
                mkSelect.prop('disabled', true);

                $.ajax({
                    url: getMkByCpmkUrl,
                    type: 'GET',
                    data: { id_cpmk: cpmkId },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function (data) {
                        mkSelect.html('<option value="" selected disabled>Pilih Mata Kuliah</option>');

                        if (data.length > 0) {
                            $.each(data, function (index, mk) {
                                mkSelect.append('<option value="' + mk.kode_mk + '">' + mk.kode_mk + ' - ' + mk.nama_mk + '</option>');
                            });
                            mkSelect.prop('disabled', false);
                        } else {
                            mkSelect.html('<option value="" selected disabled>Tidak ada mata kuliah tersedia</option>');
                        }
                    },
                    error: function () {
                        mkSelect.html('<option value="" selected disabled>Gagal memuat mata kuliah</option>');
                    }
                });
            } else {
                mkSelect.html('<option value="" selected disabled>Pilih CPMK terlebih dahulu</option>');
                mkSelect.prop('disabled', true);
            }
        });
    });
</script>
@endsection
