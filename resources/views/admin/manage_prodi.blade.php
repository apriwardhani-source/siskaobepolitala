<!-- resources/views/admin/manage_prodi.blade.php -->
<x-app-layout>
    <div class="min-h-screen bg-gray-100">
        <div class="flex">
            <!-- Sidebar -->
            @include('layouts.nav')

            <!-- Main Content -->
            <main class="flex-1 p-6">
                <div class="max-w-7xl mx-auto">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">Kelola Data Prodi</h1>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route('admin.create.prodi.form') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Prodi Baru
                        </a>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Prodi</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Prodi</th>
                                        <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th> -->
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($prodis as $prodi)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $prodi->kode_prodi }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $prodi->nama_prodi }}</td>
                                            <!-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <a href="#" class="text-red-600 hover:text-red-900 ml-2">Hapus</a>
                                            </td> -->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada data prodi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>