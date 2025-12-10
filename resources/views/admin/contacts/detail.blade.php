@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.contacts.index') }}" 
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-arrow-left mr-2 text-xs"></i>
                kembali
            </a>
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-envelope-open-text text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Detail Pesan Kontak</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Lihat detail pesan yang dikirim melalui formulir kontak.
                    </p>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-info-circle mr-2 text-sm"></i>
                    Informasi Pesan
                </h2>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold
                             {{ $contact->is_read ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                    @if($contact->is_read)
                        <i class="fas fa-check mr-1"></i> Dibaca
                    @else
                        <i class="fas fa-envelope mr-1"></i> Belum Dibaca
                    @endif
                </span>
            </div>

            <div class="px-6 py-6 space-y-6">
                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Nama</p>
                        <p class="text-sm text-gray-800">
                            {{ $contact->name ?? '-' }}
                        </p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Email</p>
                        <p class="text-sm text-gray-800">
                            {{ $contact->email ?? '-' }}
                        </p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Tanggal</p>
                        <p class="text-sm text-gray-800">
                            {{ $contact->created_at ? $contact->created_at->format('d M Y H:i') : '-' }}
                        </p>
                    </div>
                </div>

                <div class="space-y-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase">Isi Pesan</p>
                    <div class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-sm text-gray-800 leading-relaxed">
                        {!! nl2br(e($contact->message ?? '-')) !!}
                    </div>
                </div>

                {{-- Form balas pesan --}}
                <div class="space-y-3 pt-4 border-t border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-reply mr-2 text-blue-500"></i>
                        Balas Pesan
                    </h3>
                    <form action="{{ route('admin.contacts.reply', $contact->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label for="reply_message" class="block text-xs font-semibold text-gray-600 mb-1">
                                Pesan balasan (akan dikirim ke: <span class="font-mono">{{ $contact->email }}</span>)
                            </label>
                            <textarea id="reply_message" name="reply_message" rows="4"
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      required>{{ old('reply_message') }}</textarea>
                            @error('reply_message')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-xs text-gray-500">
                                Balasan akan dikirim menggunakan pengaturan email di aplikasi (MAIL_FROM_ADDRESS).
                            </p>
                            <button type="submit"
                                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                <i class="fas fa-paper-plane mr-2 text-xs"></i>
                                Kirim Balasan
                            </button>
                        </div>
                    </form>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                            <i class="fas fa-trash-alt mr-2 text-xs"></i>
                            Hapus Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
