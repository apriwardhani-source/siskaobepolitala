@extends('layouts.app')

@section('content')
    <div class="bg-white p-4 md:p-6 lg:p-8 rounded-lg shadow-md mx-2 md:mx-0">
        <div class="text-center mb-6 md:mb-8">
            <h1 class="text-xl md:text-3xl font-bold text-gray-700">Data User</h1>
            <hr class="border-t-2 md:border-t-4 border-black my-3 md:my-4 mx-auto">
        </div>

        @if (session('success'))
            <div id="alert" class="bg-green-500 text-white px-4 py-2 rounded-md mb-4 text-center relative w-full mx-auto">
                <span class="font-bold">{{ session('success') }}</span>
                <button onclick="document.getElementById('alert').style.display='none'"
                    class="absolute top-1 right-3 text-white font-bold text-lg">
                    &times;
                </button>
            </div>
        @endif

        @if (session('sukses'))
            <div id="alert" class="bg-red-500 text-white px-4 py-2 rounded-md mb-4 text-center relative w-full mx-auto">
                <span class="font-bold">{{ session('sukses') }}</span>
                <button onclick="document.getElementById('alert').style.display='none'"
                    class="absolute top-1 right-3 text-white font-bold text-lg">
                    &times;
                </button>
            </div>
        @endif

        @if (session('warning'))
            <div id="alertWarning" class="bg-yellow-500 text-white px-4 py-2 rounded-md mb-4 text-center relative w-full mx-auto">
                <span class="font-bold">{{ session('warning') }}</span>
                <button onclick="document.getElementById('alertWarning').style.display='none'"
                    class="absolute top-1 right-3 text-white font-bold text-lg">
                    &times;
                </button>
            </div>
        @endif

        @if (session('error'))
            <div id="alertError" class="bg-red-600 text-white px-4 py-2 rounded-md mb-4 text-center relative w-full mx-auto">
                <span class="font-bold">{{ session('error') }}</span>
                <button onclick="document.getElementById('alertError').style.display='none'"
                    class="absolute top-1 right-3 text-white font-bold text-lg">
                    &times;
                </button>
            </div>
        @endif

        <!-- Tab Filter Role -->
        <div class="mb-6 border-b border-gray-200">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.users.index', ['role' => 'all']) }}" 
                   class="px-4 py-2 text-sm font-medium {{ $role == 'all' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
                    Semua 
                    <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ $role == 'all' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600' }}">
                        {{ $roleCounts['all'] }}
                    </span>
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" 
                   class="px-4 py-2 text-sm font-medium {{ $role == 'admin' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
                    Admin
                    <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ $role == 'admin' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600' }}">
                        {{ $roleCounts['admin'] }}
                    </span>
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'wadir1']) }}" 
                   class="px-4 py-2 text-sm font-medium {{ $role == 'wadir1' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
                    Wadir1
                    <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ $role == 'wadir1' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600' }}">
                        {{ $roleCounts['wadir1'] }}
                    </span>
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'kaprodi']) }}" 
                   class="px-4 py-2 text-sm font-medium {{ $role == 'kaprodi' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
                    Kaprodi
                    <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ $role == 'kaprodi' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600' }}">
                        {{ $roleCounts['kaprodi'] }}
                    </span>
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'tim']) }}" 
                   class="px-4 py-2 text-sm font-medium {{ $role == 'tim' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
                    Admin Prodi
                    <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ $role == 'tim' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600' }}">
                        {{ $roleCounts['tim'] }}
                    </span>
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'dosen']) }}" 
                   class="px-4 py-2 text-sm font-medium {{ $role == 'dosen' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
                    Dosen
                    <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ $role == 'dosen' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600' }}">
                        {{ $roleCounts['dosen'] }}
                    </span>
                </a>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 md:mb-6 gap-3 md:gap-4">
            <div class="flex flex-wrap gap-2 w-full md:w-auto mb-3 md:mb-0">
                <a href="{{ route('admin.users.create') }}"
                    class="bg-green-600 hover:bg-green-800 text-white font-bold px-3 py-2 rounded-md inline-flex items-center justify-center text-sm md:text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 mr-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Tambah
                </a>
                
                @if($role === 'dosen')
                    <button onclick="document.getElementById('importModal').classList.remove('hidden')"
                        class="bg-blue-600 hover:bg-blue-800 text-white font-bold px-3 py-2 rounded-md inline-flex items-center justify-center text-sm md:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Import Dosen
                    </button>

                    <a href="{{ route('admin.users.downloadTemplate') }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-3 py-2 rounded-md inline-flex items-center justify-center text-sm md:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Template
                    </a>
                @endif
            </div>

            <!-- Search -->
            <div class="sm:min-w-[250px] w-full sm:w-auto">
                <div
                    class="flex items-center border border-black rounded-md focus-within:ring-2 focus-within:ring-green-500 bg-white">
                    <span class="pl-3 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="search" placeholder="Search..."
                        class="px-2 py-2 w-full focus:outline-none bg-transparent" />
                </div>
            </div>

        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if ($users->isEmpty())
                <div class="p-8 text-center text-gray-600">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                        @if($role === 'all')
                            Belum ada data user
                        @else
                            Belum ada user dengan role {{ ucfirst($role) }}
                        @endif
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if($role === 'dosen')
                            Mulai dengan menambahkan dosen secara manual atau import dari Excel
                        @else
                            Mulai dengan menambahkan user baru
                        @endif
                    </p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border border-black">
                        <thead class="bg-green-800 text-white">
                            <tr>
                                <th
                                    class="px-2 py-2 text-center text-xs md:text-sm font-medium uppercase border-r border-gray-200">
                                    No</th>
                                <th
                                    class="px-2 py-2 text-center text-xs md:text-sm font-medium uppercase border-r border-gray-200">
                                    NIP</th>
                                <th
                                    class="px-2 py-2 text-center text-xs md:text-sm font-medium uppercase border-r border-gray-200">
                                    Nama</th>
                                <th
                                    class="px-2 py-2 text-center text-xs md:text-sm font-medium uppercase border-r border-gray-200">
                                    NO HP</th>
                                <th
                                    class="px-2 py-2 text-center text-xs md:text-sm font-medium uppercase border-r border-gray-200">
                                    Email</th>
                                <th
                                    class="px-2 py-2 text-center text-xs md:text-sm font-medium uppercase border-r border-gray-200">
                                    Prodi</th>
                                <th
                                    class="px-2 py-2 text-center text-xs md:text-sm font-medium uppercase border-r border-gray-200">
                                    Role</th>
                                <th
                                    class="px-2 py-2 text-center text-xs md:text-sm font-medium uppercase border-r border-gray-200">
                                    Status</th>
                                <th class="px-2 py-2 text-center text-xs md:text-sm font-medium uppercase">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100">
                                    <td
                                        class="px-2 py-2 text-center border border-gray-200 text-xs md:text-sm">
                                        {{ $index + 1 }}</td>
                                    <td
                                        class="px-2 py-2 text-center border border-gray-200 text-xs md:text-sm">
                                        {{ $user->nip }}</td>
                                    <td
                                        class="px-2 py-2 text-center border border-gray-200 text-xs md:text-sm">
                                        {{ $user->name }}</td>
                                    <td
                                        class="px-2 py-2 text-center border border-gray-200 text-xs md:text-sm">
                                        {{ $user->nohp }}</td>
                                    <td
                                        class="px-2 py-2 text-center border border-gray-200 text-xs md:text-sm">
                                        {{ $user->email }}</td>
                                    <td
                                        class="px-2 py-2 text-center border border-gray-200 text-xs md:text-sm">
                                        {{ $user->prodi->nama_prodi ?? '-' }}</td>
                                    <td
                                        class="px-2 py-2 text-center border border-gray-200 text-xs md:text-sm">
                                        {{ ucfirst($user->role) }}</td>
                                    <td class="px-2 py-2 text-center border border-gray-200">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full 
                                {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $user->status }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-2 border border-gray-200">
                                        <div class="flex justify-center space-x-1 md:space-x-2">
                                            <a href="{{ route('admin.users.detail', $user->id) }}"
                                                class="bg-gray-600 hover:bg-gray-700 text-white p-1 md:p-2 rounded-md inline-flex items-center justify-center"
                                                title="Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-9-3a1 1 0 112 0 1 1 0 01-2 0zm2 5a1 1 0 10-2 0v2a1 1 0 102 0v-2z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="bg-blue-600 hover:bg-blue-800 text-white p-1 md:p-2 rounded-md inline-flex items-center justify-center"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-800 text-white p-1 md:p-2 rounded-md inline-flex items-center justify-center"
                                                    title="Hapus" onclick="return confirm('Hapus user ini?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <!-- Modal Import -->
    <div id="importModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Import Data Dosen</h3>
                <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            File Excel (.xlsx, .xls, .csv)
                        </label>
                        <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Max: 2MB</p>
                    </div>
                    
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mb-4">
                        <p class="text-sm text-blue-700">
                            <strong>Format Excel:</strong><br>
                            Kolom: nama, nip, nohp, email, password, kode_prodi<br>
                            <a href="{{ route('admin.users.downloadTemplate') }}" class="underline">Download template</a>
                        </p>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-800">
                            Upload & Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Search functionality
        document.getElementById('search').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = ['alert', 'alertWarning', 'alertError'];
            alerts.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });
        }, 5000);
    </script>
    @endpush
@endsection
