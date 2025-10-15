@extends('layouts.tim.app')

@section('content')
    <div class="ml-20 mr-20">
        <h2 class="font-extrabold text-4xl mb-6 text-center">Tambah MataKuliah</h2>
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

        <form action="{{ route('tim.matakuliah.store') }}" method="POST">
            @csrf

            <label class="text-xl font-semibold mb-2">CPL Terkait:</label>
            <div class="border border-black p-4 w-full rounded-lg mt-1 mb-3 max-h-60 overflow-y-auto">
                @foreach ($capaianProfilLulusans as $cpl)
                    <div class="mb-2">
                        <label class="flex items-start">
                            <input type="checkbox" name="id_cpls[]" value="{{ $cpl->id_cpl }}" 
                                class="mt-1 mr-2" required>
                            <span class="text-sm">{{ $cpl->kode_cpl }} - {{ $cpl->deskripsi_cpl }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
            <p class="italic text-red-700 mb-3">*Pilih minimal satu CPL.</p>

            <div class="mt-3">
                <label for="kode_mk" class="text-xl font-semibold">Kode Mata Kuliah</label>
                <input type="text" name="kode_mk" id="kode_mk" class="mt-1 w-full p-3 border border-black rounded-lg ">
            </div>
            <div class="mt-3">
                <label for="nama_mk" class="text-xl font-semibold">Nama Mata Kuliah</label>
                <input type="text" name="nama_mk" id="nama_mk" class="mt-1 w-full p-3 border border-black rounded-lg ">
            </div>
            <div class="mt-3">
                <label for="sks_mk" class="text-xl font-semibold">SKS MataKuliah</label>
                <input type="number" name="sks_mk" id="sks_mk" class="mt-1 w-full p-3 border border-black rounded-lg ">
            </div>
            <div class="mt-3">
                <label for="semester_mk" class="text-xl font-semibold">Semester MataKuliah</label>
                <select name="semester_mk" id="semester_mk" class="mt-1 w-full p-3 border border-black rounded-lg ">
                    <option value="" disabled selected>Pilih Semester</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
            </div>
            <div class="mt-3">
                <label for="kompetensi_mk" class="text-xl font-semibold">kompetensi MataKuliah</label>
                <select name="kompetensi_mk" id="kompetensi_mk" class="mt-1 w-full p-3 border border-black rounded-lg mb-3">
                    <option value="" selected disabled>Pilih Kompetensi MK</option>
                    <option value="pendukung">pendukung</option>
                    <option value="utama">utama</option>
                </select>
            </div>
            <div>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-800 text-white font-bold mt-3 px-5 py-2 rounded-lg">Simpan</button>
                <a href="{{ route('tim.matakuliah.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 px-5 py-2 rounded-lg text-white font-bold ml-2">Kembali</a>
            </div>
        </form>
    </div>

    @endsection
