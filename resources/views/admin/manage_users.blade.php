<!-- resources/views/admin/manage_users.blade.php -->
@extends('layouts.app')

@section('title', 'Kelola Akun Pengguna')

@section('content')
    <!-- Gunakan glass-card untuk wrapper utama konten -->
    <div class="glass-card rounded-xl p-6 shadow-lg">
        <h1 class="text-2xl font-bold text-white mb-6">Kelola Akun Pengguna</h1>

        @if (session('success'))
            <!-- Gunakan glass-card untuk alert juga -->
            <div class="glass-card rounded-lg p-4 mb-4 text-green-200 border border-green-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('admin.create.user.form') }}" class="glass-button text-lg">
                <i class="fas fa-user-plus me-2"></i>
                Tambah User Baru
            </a>
        </div>

        <!-- Gunakan glass-card untuk tabel -->
        <div class="glass-card rounded-lg overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <!-- Struktur table yang benar dengan kelas Tailwind -->
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Email
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Role
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-white">{{ $user->name }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-white">{{ $user->email }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-white capitalize">{{ $user->role }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                    <!-- Bungkus tombol dalam div untuk kelas action-buttons (opsional, bisa juga langsung ke button/link) -->
                                    <div class="action-buttons flex space-x-2">
                                        <!-- Tambahkan flex dan space-x untuk jarak -->
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.edit.user.form', $user->id) }}"
                                            class="glass-button-warning">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>

                                        <!-- Form Hapus -->
                                        <form action="{{ route('admin.delete.user', $user->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="glass-button-danger"
                                                onclick="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 whitespace-nowrap text-sm text-gray-300 text-center">
                                    Tidak ada data user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
