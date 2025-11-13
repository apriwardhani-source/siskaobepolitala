@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pengguna Pending</h1>
            <p class="mt-2 text-sm text-gray-600">Kelola persetujuan pendaftaran pengguna baru</p>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div id="alert-success" class="mb-6 rounded-lg bg-green-50 border-l-4 border-green-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-green-800">Berhasil!</h3>
                    <p class="mt-1 text-sm text-green-700">{{ session('success') }}</p>
                </div>
                <button onclick="this.closest('#alert-success').remove()" 
                        class="ml-4 text-green-500 hover:text-green-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            
            <!-- Content -->
            @if($pendingUsers->isEmpty())
                <!-- Empty State -->
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Tidak Ada Pengguna Pending</h3>
                    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                        Saat ini tidak ada pengguna yang menunggu persetujuan registrasi.
                    </p>
                </div>
            @else
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                            <tr>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-16">No</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">NIP</th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">No. HP</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Role</th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Prodi</th>
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-48">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pendingUsers as $index => $user)
                            <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                    {{ $user->name }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                                    {{ $user->nip }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                                    {{ $user->nohp }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">
                                    {{ $user->email }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                                 {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 
                                                    ($user->role == 'tim' ? 'bg-blue-100 text-blue-800' : 
                                                    'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                                    {{ $user->kode_prodi ?? '-' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                    <div class="flex justify-center space-x-2">
                                        <form action="{{ route('admin.pendingusers.approve', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 
                                                           text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md 
                                                           transition-all duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.pendingusers.reject', $user->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Yakin ingin menolak pengguna ini?')"
                                                    class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 
                                                           text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md 
                                                           transition-all duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Reject
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
</div>

@push('scripts')
<script>
// Auto-hide alerts
setTimeout(function() {
    const el = document.getElementById('alert-success');
    if (el) {
        el.classList.add('animate-fade-out');
        setTimeout(() => el.remove(), 300);
    }
}, 5000);
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fade-out {
    from { opacity: 1; }
    to { opacity: 0; }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

.animate-fade-out {
    animation: fade-out 0.3s ease-out;
}
</style>
@endpush
@endsection
