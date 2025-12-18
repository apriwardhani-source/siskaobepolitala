@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 py-8 px-4">
    <div class="container-fluid max-w-6xl mx-auto">
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
                                <i class="fas fa-cloud text-blue-500"></i>
                                Powered by Fonnte API (Cloud-Based)
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

        <!-- Fonnte Info Card -->
        <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl p-8 mb-8 shadow-2xl text-white">
            <div class="flex items-start gap-6">
                <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-4 flex-shrink-0">
                    <i class="fas fa-cloud text-4xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-2xl font-bold mb-3 flex items-center gap-2">
                        <span>Fonnte API - Cloud WhatsApp</span>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-normal">Cloud Based</span>
                    </h3>
                    <p class="text-green-100 mb-4">WhatsApp terintegrasi menggunakan Fonnte API. Tidak perlu Node.js atau server khusus!</p>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fas fa-check-circle text-xl"></i>
                                <h4 class="font-bold">Tanpa Server</h4>
                            </div>
                            <p class="text-sm text-green-100">Tidak perlu VPS atau Node.js</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fas fa-bolt text-xl"></i>
                                <h4 class="font-bold">Stabil & Cepat</h4>
                            </div>
                            <p class="text-sm text-green-100">Dikelola oleh Fonnte</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fas fa-server text-xl"></i>
                                <h4 class="font-bold">Shared Hosting OK</h4>
                            </div>
                            <p class="text-sm text-green-100">Bisa di hosting biasa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status & Configuration -->
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
                            <p class="text-green-100 text-sm">Status koneksi WhatsApp</p>
                        </div>
                    </div>
                </div>
                <div class="p-8">
                    <div class="text-center mb-6">
                        <div class="inline-block">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r 
                                    @if($isEnabled && $status === 'connected') from-green-400 to-emerald-400
                                    @elseif($isEnabled) from-yellow-400 to-orange-400
                                    @else from-gray-400 to-gray-500
                                    @endif rounded-full blur opacity-50"></div>
                                <div class="relative bg-white rounded-full p-6 shadow-xl">
                                    <i class="fab fa-whatsapp text-6xl 
                                        @if($isEnabled && $status === 'connected') text-green-500
                                        @elseif($isEnabled) text-yellow-500
                                        @else text-gray-400
                                        @endif"></i>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-gray-700 font-semibold mt-6 mb-3">Status Koneksi</h3>
                        <div id="statusBadge" class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-lg font-bold shadow-lg
                            @if($isEnabled && $status === 'connected') bg-gradient-to-r from-green-500 to-emerald-500 text-white
                            @elseif($isEnabled) bg-gradient-to-r from-yellow-400 to-orange-400 text-white
                            @else bg-gradient-to-r from-gray-400 to-gray-500 text-white
                            @endif">
                            @if(!$isEnabled)
                                <i class="fas fa-exclamation-circle"></i>
                                <span>NOT CONFIGURED</span>
                            @elseif($status === 'connected')
                                <i class="fas fa-check-circle"></i>
                                <span>CONNECTED</span>
                            @else
                                <i class="fas fa-times-circle"></i>
                                <span>CHECK FONNTE</span>
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

                    <button onclick="checkStatus()" class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-sync-alt"></i>
                        <span>Refresh Status</span>
                    </button>
                </div>
            </div>

            <!-- Configuration Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-8 py-6">
                    <div class="flex items-center gap-4">
                        <div class="bg-white/20 backdrop-blur-lg rounded-xl p-3">
                            <i class="fas fa-cog text-3xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold mb-1">Konfigurasi Fonnte</h2>
                            <p class="text-purple-100 text-sm">Setup WhatsApp dengan Fonnte API</p>
                        </div>
                    </div>
                </div>
                <div class="p-8">
                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-6 border border-purple-100 mb-6">
                        <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-list-ol text-purple-500"></i>
                            Langkah Setup Fonnte
                        </h4>
                        <ol class="space-y-3">
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-7 h-7 bg-gradient-to-br from-purple-500 to-indigo-500 text-white rounded-full flex items-center justify-center font-bold text-sm">1</span>
                                <span class="text-gray-700">Daftar di <a href="https://fonnte.com" target="_blank" class="text-purple-600 font-bold hover:underline">fonnte.com</a></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-7 h-7 bg-gradient-to-br from-purple-500 to-indigo-500 text-white rounded-full flex items-center justify-center font-bold text-sm">2</span>
                                <span class="text-gray-700">Hubungkan nomor WhatsApp di dashboard Fonnte</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-7 h-7 bg-gradient-to-br from-purple-500 to-indigo-500 text-white rounded-full flex items-center justify-center font-bold text-sm">3</span>
                                <span class="text-gray-700">Copy <strong>Token API</strong> dari dashboard</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-7 h-7 bg-gradient-to-br from-purple-500 to-indigo-500 text-white rounded-full flex items-center justify-center font-bold text-sm">4</span>
                                <span class="text-gray-700">Tambahkan ke file <code class="bg-white px-2 py-1 rounded">.env</code>:</span>
                            </li>
                        </ol>
                        
                        <div class="mt-4 bg-gray-900 rounded-xl p-4 font-mono text-sm text-green-400 overflow-x-auto">
                            <p class="text-gray-500"># WhatsApp Fonnte Configuration</p>
                            <p>WHATSAPP_ENABLED=true</p>
                            <p>FONNTE_TOKEN=your_fonnte_token_here</p>
                            <p>WHATSAPP_ADMIN_NUMBER=628xxxxxxxxxx</p>
                        </div>
                    </div>

                    <a href="https://fonnte.com" target="_blank" class="block w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300 text-center">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Buka Dashboard Fonnte
                    </a>
                </div>
            </div>
        </div>

        <!-- Test Message Card -->
        @if($isEnabled)
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 mb-8">
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
                                   value="{{ env('WHATSAPP_ADMIN_NUMBER', '') }}"
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
                                  rows="4" 
                                  placeholder="Tulis pesan test Anda di sini..."
                                  required>🎉 Test dari SISKAOBE Politala!

Ini adalah pesan test untuk memastikan WhatsApp integration (Fonnte) berjalan dengan baik.

Terima kasih! 🙏</textarea>
                    </div>
                    
                    <!-- Result Alert -->
                    <div id="testResult"></div>
                </form>
            </div>
        </div>
        @else
        <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-6 mb-8">
            <div class="flex items-start gap-4">
                <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl"></i>
                <div>
                    <h4 class="font-bold text-yellow-800 mb-2">WhatsApp Belum Dikonfigurasi</h4>
                    <p class="text-yellow-700">Set <code class="bg-yellow-100 px-2 py-1 rounded">FONNTE_TOKEN</code> dan <code class="bg-yellow-100 px-2 py-1 rounded">WHATSAPP_ENABLED=true</code> di file <code class="bg-yellow-100 px-2 py-1 rounded">.env</code> untuk mengaktifkan fitur WhatsApp.</p>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

<script>
// Check Status
function checkStatus() {
    fetch('{{ route('admin.whatsapp.status') }}')
        .then(response => response.json())
        .then(data => {
            const statusBadge = document.getElementById('statusBadge');
            
            if (!data.isEnabled) {
                statusBadge.className = 'inline-flex items-center gap-2 px-6 py-3 rounded-full text-lg font-bold shadow-lg bg-gradient-to-r from-gray-400 to-gray-500 text-white';
                statusBadge.innerHTML = '<i class="fas fa-exclamation-circle"></i><span>NOT CONFIGURED</span>';
            } else if (data.status === 'connected') {
                statusBadge.className = 'inline-flex items-center gap-2 px-6 py-3 rounded-full text-lg font-bold shadow-lg bg-gradient-to-r from-green-500 to-emerald-500 text-white';
                statusBadge.innerHTML = '<i class="fas fa-check-circle"></i><span>CONNECTED</span>';
            } else {
                statusBadge.className = 'inline-flex items-center gap-2 px-6 py-3 rounded-full text-lg font-bold shadow-lg bg-gradient-to-r from-yellow-400 to-orange-400 text-white';
                statusBadge.innerHTML = '<i class="fas fa-sync-alt"></i><span>CHECK FONNTE</span>';
            }
            
            alert('Status: ' + (data.status || 'unknown'));
        })
        .catch(error => {
            console.error('Error checking status:', error);
            alert('Error: ' + error.message);
        });
}

// Send Test Message
function sendTest() {
    const number = document.getElementById('testNumber').value;
    const message = document.getElementById('testMessage').value;
    const resultDiv = document.getElementById('testResult');
    
    if (!number || !message) {
        alert('Mohon isi nomor dan pesan terlebih dahulu');
        return;
    }
    
    resultDiv.innerHTML = `
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div>
            <div>
                <p class="font-semibold text-blue-800">Mengirim pesan via Fonnte...</p>
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
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.innerHTML = `
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 flex items-start gap-3">
                    <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                    <div>
                        <h4 class="font-bold text-green-800 mb-1">Berhasil Terkirim via Fonnte!</h4>
                        <p class="text-green-700 text-sm">${data.message}</p>
                    </div>
                </div>
            `;
        } else {
            resultDiv.innerHTML = `
                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 flex items-start gap-3">
                    <i class="fas fa-times-circle text-red-500 text-2xl"></i>
                    <div>
                        <h4 class="font-bold text-red-800 mb-1">Gagal Mengirim</h4>
                        <p class="text-red-700 text-sm">${data.message || data.error}</p>
                    </div>
                </div>
            `;
        }
    })
    .catch(error => {
        resultDiv.innerHTML = `
            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 flex items-start gap-3">
                <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                <div>
                    <h4 class="font-bold text-red-800 mb-1">Error</h4>
                    <p class="text-red-700 text-sm">${error.message}</p>
                </div>
            </div>
        `;
    });
}
</script>
@endsection
