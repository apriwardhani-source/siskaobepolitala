@extends('layouts.kaprodi.app')

@section('content')

    <div class="mr-20 ml-20">
        <h2 class="text-4xl font-extrabold text-center mb-4">Detail Capaian Pembelajaran Lulusan</h2>
        <hr class="w-full border border-black mb-4">

        @if ($selectedProfilLulusans)
            <div class="mt-4">
                <h3 class="text-xl font-semibold mb-2">Detail Profil Lulusan Terkait:</h3>
                @foreach ($selectedProfilLulusans as $id_pl)
                    @php
                        $plDetail = $profilLulusans->firstWhere('id_pl', $id_pl);
                    @endphp
                    @if ($plDetail)
                        <input type="text" readonly class="w-full p-3 border border-black rounded-lg"
                            value="{{ $plDetail->kode_pl }}: {{ $plDetail->deskripsi_pl }}">
                    @endif
                @endforeach
            </div>
        @endif
        <br>

        <label for="kode_cpl" class="block text-xl font-semibold mb-1">Kode CPL</label>
        <input type="text" name="kode_cpl" id="kode_cpl" value="{{ $id_cpl->kode_cpl }}" readonly
            class="w-full p-3 border border-black rounded-lg mb-4">

        <label for="deskripsi_cpl" class="block text-xl font-semibold mb-1">Deskripsi CPL</label>
        <textarea type="text" name="deskripsi_cpl" id="deskripsi_cpl" readonly
            class="w-full p-3 border border-black rounded-lg mb-4">{{ $id_cpl->deskripsi_cpl }}</textarea>

        <label for="status_cpl" class="block text-xl font-semibold mb-1">Status CPL</label>
        <input type="text" name="status_cpl" id="status_cpl" value="{{ $id_cpl->status_cpl }}" readonly
            class="w-full p-3 border border-black rounded-lg mb-10">
        <br>

        <a href="{{ route('kaprodi.capaianpembelajaranlulusan.index') }}"
            class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg text-white font-bold">Kembali</a>
    </div>

@endsection
