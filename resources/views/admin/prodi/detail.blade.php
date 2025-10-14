@extends('layouts.app')

@section('content')
    <div class="mx-20 mt-6">
        <h2 class="font-extrabold text-3xl mb-5 text-center">Detail Prodi</h2>
        <hr class="border-t-2 md:border-t-4 border-black my-3 md:my-4 mx-auto">

        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md space-y-4">
            <div>
                <label class="block text-lg font-semibold text-gray-700">Kode Prodi</label>
                <input type="text" value="{{ $prodi->kode_prodi }}" readonly
                    class="w-full p-3 border border-black rounded-lg focus:outline-none bg-gray-50">
            </div>

            <div>
                <label class="block text-lg font-semibold text-gray-700">Nama Jurusan</label>
                <input type="text" value="{{ $prodi->jurusan->nama_jurusan }}" readonly
                    class="w-full p-3 border border-black rounded-lg focus:outline-none bg-gray-50">
            </div>

            <div>
                <label class="block text-lg font-semibold text-gray-700">Nama Prodi</label>
                <input type="text" value="{{ $prodi->nama_prodi }}" readonly
                    class="w-full p-3 border border-black rounded-lg focus:outline-none bg-gray-50">
            </div>

            <div>
                <label class="block text-lg font-semibold text-gray-700">Nama Kaprodi</label>
                <input type="text" value="{{ $prodi->nama_kaprodi }}" readonly
                    class="w-full p-3 border border-black rounded-lg focus:outline-none bg-gray-50">
            </div>

            <div>
                <label class="block text-lg font-semibold text-gray-700">Jenjang Pendidikan</label>
                <input type="text" value="{{ $prodi->jenjang_pendidikan }}" readonly
                    class="w-full p-3 border border-black rounded-lg focus:outline-none bg-gray-50">
            </div>
        </div>

        <div class="max-w-2xl mx-auto flex justify-end space-x-4 mt-6">
            <a href="{{ route('admin.prodi.index') }}"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-900 text-white font-semibold rounded-lg transition duration-200">
                Kembali
            </a>
            <a href="{{ route('admin.prodi.edit', $prodi->kode_prodi) }}"
                class="px-6 py-2 bg-yellow-600 hover:bg-yellow-800 text-white font-semibold rounded-lg transition duration-200">
                Edit
            </a>
        </div>
    </div>
@endsection
