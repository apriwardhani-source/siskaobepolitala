@extends('layouts.app')

@section('content')

    <div class="mx-20 mt-6">
        <h2 class="font-extrabold text-3xl mb-5 text-center">Detail Capaian Pembelajaran Lulusan</h2>
        <hr class="border-t-2 md:border-t-4 border-black my-3 md:my-4 mx-auto">

        @if ($selectedProfilLulusans)
            <div class="mt-4">
                <h3 class="text-xl font-semibold mb-2">PL Terkait</h3>
                @foreach ($selectedProfilLulusans as $id_pl)
                    @php
                        $plDetail = $profilLulusans->firstWhere('id_pl', $id_pl);
                    @endphp
                    @if ($plDetail)
                        <input type="text" name="id_pl[]" id="id_pl"
                            value="{{ $plDetail->kode_pl }}: {{ $plDetail->deskripsi_pl }}" readonly
                            class="w-full p-3 border border-black rounded-lg mb-4">
                    @endif
                @endforeach
            </div>
        @endif

        <label for="kode_cpl" class="text-xl font-semibold">Kode CPL</label>
        <input type="text" name="kode_cpl" id="kode_cpl" value="{{ $id_cpl->kode_cpl }}" readonly
            class="w-full p-3 border border-black rounded-lg mb-4">

        <label for="deskripsi_cpl" class="text-xl font-semibold">Deskripsi CPL</label>
        <textarea type="text" name="deskripsi_cpl" id="deskripsi_cpl" readonly
            class="w-full p-3 border border-black rounded-lg mb-4">{{ $id_cpl->deskripsi_cpl }}</textarea>

        <label for="status_cpl" class="text-xl font-semibold">Status CPL</label>
        <input type="text" name="status_cpl" id="status_cpl" value="{{ $id_cpl->status_cpl }}" readonly
            class="w-full p-3 border border-black rounded-lg mb-10">
        <br>

        <a href="{{ route('admin.capaianprofillulusan.index') }}"
            class="bg-gray-600 text-white font-bold hover:bg-gray-700 px-4 py-2 rounded-lg">Kembali</a>
    </div>

@endsection
