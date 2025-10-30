@extends('layouts.tim.app')

@section('content')
    <div class="mr-20 ml-20">
        <h2 class="text-4xl font-extrabold text-center mb-4">Detail Capaian Pembelajaran Lulusan</h2>
        <hr class="w-full border border-black mb-4">

        <label for="kode_cpl" class="block text-xl font-semibold mb-1">Kode CPL</label>
        <input type="text" name="kode_cpl" id="kode_cpl" value="{{ $id_cpl->kode_cpl }}" readonly
            class="w-full p-3 border border-black rounded-lg mb-4 bg-gray-100">

        <label for="deskripsi_cpl" class="block text-xl font-semibold mb-1">Deskripsi CPL</label>
        <textarea type="text" name="deskripsi_cpl" id="deskripsi_cpl" readonly
            class="w-full p-3 border border-black rounded-lg mb-10 bg-gray-100">{{ $id_cpl->deskripsi_cpl }}</textarea>
        <br>

        <a href="{{ route('tim.capaianpembelajaranlulusan.index') }}"
            class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg text-white font-bold">Kembali</a>
    </div>
@endsection
