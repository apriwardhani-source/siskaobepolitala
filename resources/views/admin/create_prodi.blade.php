<!-- resources/views/admin/create_prodi.blade.php -->
<x-app-layout>
    <div class="min-h-screen bg-gray-100">
        <div class="flex">
            <!-- Sidebar -->
            @include('layouts.nav')

            <!-- Main Content -->
            <main class="flex-1 p-6">
                <div class="max-w-2xl mx-auto">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Prodi Baru</h1>

                    <form method="POST" action="{{ route('admin.create.prodi') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="kode_prodi" class="block text-sm font-medium text-gray-700">Kode Prodi</label>
                            <input type="text" name="kode_prodi" id="kode_prodi" value="{{ old('kode_prodi') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('kode_prodi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nama_prodi" class="block text-sm font-medium text-gray-700">Nama Prodi</label>
                            <input type="text" name="nama_prodi" id="nama_prodi" value="{{ old('nama_prodi') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('nama_prodi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.manage.prodi') }}" class="mr-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>