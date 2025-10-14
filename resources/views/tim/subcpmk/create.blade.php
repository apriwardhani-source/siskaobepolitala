@extends('layouts.tim.app')

@section('content')
<div class="mx-20">
    <h2 class="font-extrabold text-4xl mb-6 text-center">Tambah Sub CPMK</h2>
    <hr class="w-full border border-black mb-4">

    @if ($errors->any())
        <div class="text-red-600 mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tim.subcpmk.store') }}" method="POST">
        @csrf

        <!-- Dropdown CPMK -->
        <div>
            <label for="id_cpmk" class="text-xl font-semibold">CPMK:</label>
            <select name="id_cpmk" id="id_cpmk" required
                class="w-full mt-1 p-3 border border-black rounded-lg focus:ring-blue-500 focus:border-blue-500 mb-5">
                <option value="" selected disabled>Pilih CPMK</option>
                @foreach ($cpmks as $cpmk)
                    <option value="{{ $cpmk->id_cpmk }}">{{ $cpmk->kode_cpmk }} - {{ $cpmk->deskripsi_cpmk }}</option>
                @endforeach
            </select>
        </div>

        <!-- Dropdown MK -->
        <div>
            <label for="kode_mk" class="text-xl font-semibold">Mata Kuliah:</label>
            <select name="kode_mk" id="kode_mk" required
                class="w-full mt-1 p-3 border border-black rounded-lg focus:ring-blue-500 focus:border-blue-500 mb-5">
                <option value="" selected disabled>Pilih CPMK terlebih dahulu</option>
            </select>
        </div>

        <!-- Sub CPMK -->
        <div>
            <label for="sub_cpmk" class="text-xl font-semibold">Sub CPMK:</label>
            <input type="text" name="sub_cpmk" id="sub_cpmk" required
                class="w-full mt-1 p-3 border border-black rounded-lg mb-5">
        </div>

        <!-- Uraian -->
        <div>
            <label for="uraian_cpmk" class="text-xl font-semibold">Uraian CPMK:</label>
            <input type="text" name="uraian_cpmk" id="uraian_cpmk" required
                class="w-full mt-1 p-3 border border-black rounded-lg mb-5">
        </div>

        <!-- Tombol -->
        <div class="mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white px-5 py-2 font-bold rounded-lg">
                Simpan
            </button>
            <a href="{{ route('tim.subcpmk.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-5 font-bold py-2 rounded-lg ml-2">
                Kembali
            </a>
        </div>
    </form>
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
