@extends('layouts.tim.app')

@section('content')

    <div class="mr-20 ml-20">
        <h2 class="text-4xl font-extrabold text-center mb-4">Edit Capaian Pembelajaran Lulusan</h2>
        <hr class="w-full border border-black mb-4">

        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tim.capaianpembelajaranlulusan.update', $id_cpl->id_cpl) }}"
            method="POST">

            @csrf
            @method('PUT')

            <label class="text-xl font-semibold" for="kode_cpl">Kode Capaian Profil Lulusan:</label>
            <input type="text" name="kode_cpl" id="kode_cpl" class="border border-black w-full rounded-lg p-3 mt-1 mb-3"
                value="{{ old('kode_cpl', $id_cpl->kode_cpl) }}" required>
            <br>

            <label class="text-xl font-semibold" for="deskripsi_cpl">Deskripsi Capaian Profil Lulusan:</label>
            <textarea type="text" name="deskripsi_cpl" id="deskripsi_cpl"
                class="border border-black w-full rounded-lg p-3 mb-3 mt-2" required>{{ old('deskripsi_cpl', $id_cpl->deskripsi_cpl) }}</textarea>
            <br>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-800 px-5 py-2 rounded-lg text-white font-bold">Simpan</button>
            <a href="{{ route('tim.capaianpembelajaranlulusan.index') }}"
                class="ml-2 bg-gray-600 hover:bg-gray-800 rounded-lg py-2 px-5 text-white font-bold">Kembali</a>
        </form>
    </div>
@endsection
