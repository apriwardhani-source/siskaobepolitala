@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 py-8 px-4">
    <div class="container-fluid max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl blur opacity-75"></div>
                            <div class="relative bg-gradient-to-br from-green-500 to-green-600 text-white p-4 rounded-2xl">
                                <i class="fab fa-whatsapp text-4xl"></i>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent mb-1">WhatsApp Integration</h1>
                            <p class="text-gray-600 text-sm flex items-center gap-2">
                                <i class="fas fa-bell text-green-500"></i>
                                Notifikasi Otomatis untuk Pesan Website
                            </p>
                        </div>
                    </div>
                    <nav class="text-sm">
                        <ol class="flex items-center gap-2 text-gray-500">
                            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600 transition-colors flex items-center gap-1">
                                <i class="fas fa-home text-xs"></i> Dashboard
                            </a></li>
                            <li><i class="fas fa-chevron-right text-xs"></i></li>
                            <li class="text-green-600 font-semibold">WhatsApp Setup</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Quick Start Instructions Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl p-8 mb-8 shadow-2xl text-white">
            <div class="flex items-start gap-6">
                <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-4 flex-shrink-0">
                    <i class="fas fa-rocket text-4xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-2xl font-bold mb-3 flex items-center gap-2">
                        <span>Quick Start Guide</span>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-normal">3 Langkah Mudah</span>
                    </h3>
                    <p class="text-blue-100 mb-6">Setup WhatsApp dalam hitungan menit tanpa akses terminal</p>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-5 border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="bg-gradient-to-br from-green-400 to-green-500 rounded-xl w-10 h-10 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                    1
                                </div>
                                <h4 class="font-bold text-lg">Start Service</h4>
                            </div>
                            <p class="text-sm text-blue-100">Klik tombol hijau "Start Service" untuk menjalankan WhatsApp bot</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-5 border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="bg-gradient-to-br from-green-400 to-green-500 rounded-xl w-10 h-10 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                    2
                                </div>
                                <h4 class="font-bold text-lg">Scan QR Code</h4>
                            </div>
                            <p class="text-sm text-blue-100">Buka WhatsApp di HP → Linked Devices → Scan QR code yang muncul</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-5 border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="bg-gradient-to-br from-green-400 to-green-500 rounded-xl w-10 h-10 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                    3
                                </div>
                                <h4 class="font-bold text-lg">Test & Done!</h4>
                            </div>
                            <p class="text-sm text-blue-100">Klik "Test Message" untuk memastikan notifikasi berfungsi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Control Card -->
        <div class="bg-white rounded-3xl shadow-2xl mb-8 overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-700 text-white px-8 py-6">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-white/20 backdrop-blur-lg rounded-xl p-3">
                            <i class="fas fa-cogs text-3xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold mb-1">Service Controls</h2>
                            <p class="text-purple-100 text-sm">Kontrol WhatsApp service dengan 1 klik</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-8">
                <!-- Info Note for First Time Setup -->
                <div class="bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-500 rounded-lg p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-amber-500 text-xl mt-1"></i>
                        <div class="flex-1">
                            <h4 class="font-bold text-amber-900 mb-2">Catatan Penting</h4>
                            <p class="text-sm text-amber-800 mb-2">
                                Jika tombol <strong>"Start Service"</strong> tidak berfungsi, hubungi developer untuk aktivasi PM2 service di server (setup 1x saja).
                            </p>
                            <p class="text-xs text-amber-700">
                                Setelah service aktif, Anda dapat menggunakan tombol <strong>"Restart Service"</strong> dan <strong>"Refresh Status"</strong> kapan saja.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="grid md:grid-cols-3 gap-4">
                    <button onclick="startService()" class="group relative bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-5 px-6 rounded-2xl shadow-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl overflow-hidden">
                        <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                        <div class="relative flex items-center justify-center gap-3">
                            <i class="fas fa-play-circle text-2xl"></i>
                            <span>Start Service</span>
                        </div>
                    </button>
                    <button onclick="restartService()" class="group relative bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold py-5 px-6 rounded-2xl shadow-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl overflow-hidden">
                        <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                        <div class="relative flex items-center justify-center gap-3">
                            <i class="fas fa-redo text-2xl"></i>
                            <span>Restart Service</span>
                        </div>
                    </button>
                    <button onclick="checkStatus()" class="group relative bg-white border-2 border-purple-500 text-purple-600 hover:bg-gradient-to-r hover:from-purple-500 hover:to-indigo-500 hover:text-white hover:border-transparent font-bold py-5 px-6 rounded-2xl shadow-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                        <div class="relative flex items-center justify-center gap-3">
                            <i class="fas fa-sync-alt"></i>
                            <span>Refresh Status</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

    <!-- Status & QR Code Section -->
    <div class="grid lg:grid-cols-2 gap-8 mb-8">
        <!-- Status Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 backdrop-blur-lg rounded-xl p-3">
                        <i class="fab fa-whatsapp text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-1">Connection Status</h2>
                        <p class="text-green-100 text-sm">Real-time status monitoring</p>
                    </div>
                </div>
            </div>
            <div class="p-8">
                <div class="text-center mb-8">
                    <div class="inline-block">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r 
                                @if($status === 'connected') from-green-400 to-emerald-400
                                @elseif($status === 'connecting') from-yellow-400 to-orange-400
                                @else from-red-400 to-pink-400
                                @endif rounded-full blur opacity-50"></div>
                            <div class="relative bg-white rounded-full p-6 shadow-xl">
                                <i class="fab fa-whatsapp text-6xl 
                                    @if($status === 'connected') text-green-500
                                    @elseif($status === 'connecting') text-yellow-500
                                    @else text-red-500
                                    @endif"></i>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-gray-700 font-semibold mt-6 mb-3">Status Koneksi</h3>
                    <div id="statusBadge" class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-lg font-bold shadow-lg
                        @if($status === 'connected') bg-gradient-to-r from-green-500 to-emerald-500 text-white
                        @elseif($status === 'connecting') bg-gradient-to-r from-yellow-400 to-orange-400 text-white
                        @else bg-gradient-to-r from-red-500 to-pink-500 text-white
                        @endif">
                        @if($status === 'connected')
                            <i class="fas fa-check-circle"></i>
                            <span>CONNECTED</span>
                        @elseif($status === 'connecting')
                            <i class="fas fa-spinner fa-spin"></i>
                            <span>CONNECTING</span>
                        @else
                            <i class="fas fa-times-circle"></i>
                            <span>DISCONNECTED</span>
                        @endif
                    </div>
                </div>
                
                @if(isset($error))
                    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                            <div>
                                <h4 class="font-bold text-red-800 mb-1">Error</h4>
                                <p class="text-red-700 text-sm">{{ $error }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-500"></i>
                        Informasi Status
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span><strong class="text-green-600">CONNECTED</strong> = WhatsApp siap menerima notifikasi</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-times text-red-500 mt-1"></i>
                            <span><strong class="text-red-600">DISCONNECTED</strong> = Perlu scan QR code</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-shield-alt text-blue-500 mt-1"></i>
                            <span>Scan QR code hanya perlu 1x, session tersimpan otomatis</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-sync-alt text-purple-500 mt-1"></i>
                            <span>Klik "Restart Service" jika perlu QR code baru</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- QR Code Card -->
        <div id="qrSection" style="display: {{ $status !== 'connected' ? 'block' : 'none' }};">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-8 py-6">
                    <div class="flex items-center gap-4">
                        <div class="bg-white/20 backdrop-blur-lg rounded-xl p-3">
                            <i class="fas fa-qrcode text-3xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold mb-1">Scan QR Code</h2>
                            <p class="text-purple-100 text-sm">Hubungkan WhatsApp dengan sistem</p>
                        </div>
                    </div>
                </div>
                <div class="p-8">
                    <div class="text-center mb-8">
                        <div id="qrContainer" class="inline-block p-6 bg-white rounded-2xl shadow-xl border-4 border-gray-100">
                            <div class="flex flex-col items-center justify-center min-h-[300px]">
                                <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-purple-500"></div>
                                <p class="mt-4 text-gray-600 font-semibold">Memuat QR Code...</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 border border-indigo-100">
                        <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-mobile-alt text-purple-500 text-xl"></i>
                            Cara Scan QR Code
                        </h4>
                        <ol class="space-y-3">
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-7 h-7 bg-gradient-to-br from-purple-500 to-indigo-500 text-white rounded-full flex items-center justify-center font-bold text-sm">1</span>
                                <span class="text-gray-700"><strong>Buka WhatsApp</strong> di HP Anda</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-7 h-7 bg-gradient-to-br from-purple-500 to-indigo-500 text-white rounded-full flex items-center justify-center font-bold text-sm">2</span>
                                <span class="text-gray-700">Tap <strong>⋮</strong> (3 titik di pojok kanan atas)</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-7 h-7 bg-gradient-to-br from-purple-500 to-indigo-500 text-white rounded-full flex items-center justify-center font-bold text-sm">3</span>
                                <span class="text-gray-700">Pilih <strong>"Linked Devices"</strong> atau <strong>"Perangkat Tertaut"</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-7 h-7 bg-gradient-to-br from-purple-500 to-indigo-500 text-white rounded-full flex items-center justify-center font-bold text-sm">4</span>
                                <span class="text-gray-700">Tap <strong>"Link a Device"</strong> atau <strong>"Tautkan Perangkat"</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-7 h-7 bg-gradient-to-br from-purple-500 to-indigo-500 text-white rounded-full flex items-center justify-center font-bold text-sm">5</span>
                                <span class="text-gray-700"><strong>Scan QR code</strong> yang muncul di atas</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Test Message Card -->
    <div id="testSection" class="mb-8" style="display: {{ $status === 'connected' ? 'block' : 'none' }};">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-teal-500 to-cyan-600 text-white px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 backdrop-blur-lg rounded-xl p-3">
                        <i class="fas fa-paper-plane text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-1">Test WhatsApp Message</h2>
                        <p class="text-teal-100 text-sm">Kirim pesan test untuk memastikan koneksi berfungsi</p>
                    </div>
                </div>
            </div>
            <div class="p-8">
                <form id="testForm" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Nomor WhatsApp -->
                        <div>
                            <label for="testNumber" class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fas fa-phone text-teal-500 mr-2"></i>Nomor WhatsApp
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition-all duration-200 font-mono" 
                                   id="testNumber" 
                                   placeholder="628xxxxxxxxx" 
                                   value="{{ env('WHATSAPP_ADMIN_NUMBER', '6285754631899') }}"
                                   required>
                            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                <i class="fas fa-info-circle"></i>
                                Format: 628xxx (tanpa tanda +)
                            </p>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fas fa-bolt text-yellow-500 mr-2"></i>Quick Actions
                            </label>
                            <div class="flex flex-wrap gap-3">
                                <button type="button" 
                                        onclick="sendTest()" 
                                        class="flex-1 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                                    <i class="fab fa-whatsapp text-xl"></i>
                                    <span>Kirim Test</span>
                                </button>
                                <button type="button" 
                                        onclick="document.getElementById('testMessage').value = '🎉 Test dari Admin Dashboard Politala OBE!\n\nIni adalah pesan test untuk memastikan WhatsApp integration berjalan dengan baik.\n\nTerima kasih! 🙏'" 
                                        class="bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                                    <i class="fas fa-magic"></i>
                                    <span>Template</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Message Textarea -->
                    <div>
                        <label for="testMessage" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-comment-dots text-teal-500 mr-2"></i>Pesan
                        </label>
                        <textarea class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition-all duration-200 resize-none" 
                                  id="testMessage" 
                                  rows="6" 
                                  placeholder="Tulis pesan test Anda di sini..."
                                  required>🎉 Test dari Admin Dashboard Politala OBE!

Ini adalah pesan test untuk memastikan WhatsApp integration berjalan dengan baik.

Terima kasih! 🙏</textarea>
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-xs text-gray-500">
                                <i class="fas fa-keyboard mr-1"></i>Mendukung emoji dan multiline
                            </p>
                            <p class="text-xs text-gray-400" id="charCount">0 karakter</p>
                        </div>
                    </div>
                    
                    <!-- Result Alert -->
                    <div id="testResult"></div>
                </form>
                
                <!-- Info Box -->
                <div class="mt-6 bg-gradient-to-br from-teal-50 to-cyan-50 rounded-2xl p-6 border border-teal-100">
                    <h4 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-lightbulb text-yellow-500 text-xl"></i>
                        Tips Pengiriman Pesan
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-teal-500 mt-1"></i>
                            <span>Pastikan nomor WhatsApp aktif dan terdaftar</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-teal-500 mt-1"></i>
                            <span>Gunakan format internasional: <code class="bg-white px-2 py-1 rounded">628xxxxxxxxx</code></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-teal-500 mt-1"></i>
                            <span>Pesan akan terkirim langsung ke nomor yang dituju</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-teal-500 mt-1"></i>
                            <span>Cek HP Anda setelah klik "Kirim Test"</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #25D366, #128C7E);
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
    }
    #qrContainer img {
        max-width: 400px;
        border: 3px solid #25D366;
        border-radius: 10px;
        padding: 10px;
        background: white;
    }
</style>

<script>
// Start Service via Web Interface (No Terminal Needed!)
function startService() {
    if (!confirm('🚀 Start WhatsApp Service?\n\nService akan berjalan di background dengan PM2.')) {
        return;
    }
    
    const btn = event.target.closest('button');
    const originalHTML = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin text-2xl"></i><span>Starting...</span>';
    
    fetch('{{ route('admin.whatsapp.start') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            alert('❌ ' + data.message);
            btn.disabled = false;
            btn.innerHTML = originalHTML;
        }
    })
    .catch(error => {
        alert('❌ Error: ' + error.message);
        btn.disabled = false;
        btn.innerHTML = originalHTML;
    });
}

// Restart Service via Web Interface
function restartService() {
    if (!confirm('🔄 Restart WhatsApp Service?\n\nQR code baru akan di-generate. Anda perlu scan ulang jika belum connected.')) {
        return;
    }
    
    const btn = event.target.closest('button');
    const originalHTML = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin text-2xl"></i><span>Restarting...</span>';
    
    fetch('{{ route('admin.whatsapp.restart') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            alert('❌ ' + data.message);
            btn.disabled = false;
            btn.innerHTML = originalHTML;
        }
    })
    .catch(error => {
        alert('❌ Error: ' + error.message);
        btn.disabled = false;
        btn.innerHTML = originalHTML;
    });
}

// Character counter for message
function updateCharCount() {
    const textarea = document.getElementById('testMessage');
    const counter = document.getElementById('charCount');
    if (textarea && counter) {
        const length = textarea.value.length;
        counter.textContent = `${length} karakter`;
    }
}

// Load QR Code on page load
document.addEventListener('DOMContentLoaded', function() {
    loadQRCode();
    // Auto refresh status every 10 seconds
    setInterval(checkStatus, 10000);
    
    // Character counter
    const textarea = document.getElementById('testMessage');
    if (textarea) {
        updateCharCount();
        textarea.addEventListener('input', updateCharCount);
    }
});

// Load QR Code
function loadQRCode() {
    fetch('{{ route('admin.whatsapp.qr') }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('qrContainer').innerHTML = data.html;
            } else {
                document.getElementById('qrContainer').innerHTML = 
                    '<div class="alert alert-warning">QR Code tidak tersedia. WhatsApp mungkin sudah terhubung!</div>';
            }
        })
        .catch(error => {
            document.getElementById('qrContainer').innerHTML = 
                '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Error loading QR Code: ' + error.message + '</div>';
        });
}

// Check Status
function checkStatus() {
    fetch('{{ route('admin.whatsapp.status') }}')
        .then(response => response.json())
        .then(data => {
            const statusBadge = document.getElementById('statusBadge');
            const qrSection = document.getElementById('qrSection');
            const testSection = document.getElementById('testSection');
            
            if (data.status === 'connected') {
                statusBadge.className = 'badge bg-success';
                statusBadge.innerHTML = '<i class="fas fa-check-circle"></i> CONNECTED';
                qrSection.style.display = 'none';
                testSection.style.display = 'block';
            } else if (data.status === 'connecting') {
                statusBadge.className = 'badge bg-warning';
                statusBadge.innerHTML = '<i class="fas fa-spinner fa-spin"></i> CONNECTING';
                qrSection.style.display = 'block';
                testSection.style.display = 'none';
                loadQRCode(); // Reload QR if connecting
            } else {
                statusBadge.className = 'badge bg-danger';
                statusBadge.innerHTML = '<i class="fas fa-times-circle"></i> DISCONNECTED';
                qrSection.style.display = 'block';
                testSection.style.display = 'none';
                loadQRCode(); // Load QR for connection
            }
        })
        .catch(error => {
            console.error('Error checking status:', error);
        });
}

// Send Test Message
function sendTest() {
    const number = document.getElementById('testNumber').value;
    const message = document.getElementById('testMessage').value;
    const resultDiv = document.getElementById('testResult');
    
    resultDiv.innerHTML = `
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div>
            <div>
                <p class="font-semibold text-blue-800">Mengirim pesan...</p>
                <p class="text-sm text-blue-600">Mohon tunggu sebentar</p>
            </div>
        </div>
    `;
    
    fetch('{{ route('admin.whatsapp.test') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ number, message })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.message || 'HTTP Error: ' + response.status);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            resultDiv.innerHTML = `
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 flex items-start gap-3">
                    <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                    <div>
                        <h4 class="font-bold text-green-800 mb-1">Berhasil Terkirim!</h4>
                        <p class="text-green-700 text-sm">${data.message}</p>
                    </div>
                </div>
            `;
        } else {
            const errorDetail = data.error ? `<p class="text-xs text-red-600 mt-2 font-mono">${JSON.stringify(data.error)}</p>` : '';
            resultDiv.innerHTML = `
                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 flex items-start gap-3">
                    <i class="fas fa-times-circle text-red-500 text-2xl"></i>
                    <div>
                        <h4 class="font-bold text-red-800 mb-1">Gagal Mengirim</h4>
                        <p class="text-red-700 text-sm">${data.message}</p>
                        ${errorDetail}
                    </div>
                </div>
            `;
        }
    })
    .catch(error => {
        resultDiv.innerHTML = '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Error: ' + error.message + '</div>';
    });
}
</script>
    </div>
</div>
@endsection
