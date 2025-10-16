@extends('layouts.app')

@section('title', 'Edit Jurusan')

@section('content')
<div class="mx-20 mt-6">
    <h2 class="font-extrabold text-3xl mb-5 text-center">Edit Jurusan</h2>
    <hr class="border-t-2 md:border-t-4 border-black my-3 md:my-4 mx-auto">

    <div class="bg-white px-6 pb-6 pt-2 rounded-lg shadow-md">

        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.jurusan.update', $jurusan->id_jurusan) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nama_jurusan" class="block text-lg font-semibold mb-2">Nama Jurusan</label>
                <input type="text" id="nama_jurusan" name="nama_jurusan" value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}"
                    class="w-full p-3 border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-[#fbfffd]" required>
            </div>

            <div>
                <label for="nama_kajur" class="block text-lg font-semibold mb-2">Nama Kajur</label>
                <input type="text" id="nama_kajur" name="nama_kajur" value="{{ old('nama_kajur', $jurusan->nama_kajur) }}"
                    class="w-full p-3 border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-[#fbfffd]" required>
            </div>

                    <!-- Tombol Aksi -->
        <div class="flex justify-end space-x-5 pt-6">
            <a href="{{ route('admin.jurusan.index') }}" 
               class="px-6 py-2 bg-blue-600 hover:bg-blue-900 text-white font-semibold rounded-lg transition duration-200">
                Kembali
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-green-600 hover:bg-green-800 text-white font-semibold rounded-lg transition duration-200">
                Simpan
            </button>
        </div>

        </form>
    </div>
</div>
@endsection
