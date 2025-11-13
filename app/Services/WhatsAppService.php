<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiKey;
    protected $apiUrl;
    protected $instanceName;
    protected $enabled;

    public function __construct()
    {
        // Check if WhatsApp is enabled (for development/production toggle)
        $this->enabled = env('WHATSAPP_ENABLED', true);
        
        // WhatsApp Service Config (whatsapp-web.js)
        $this->apiUrl = env('WHATSAPP_API_URL', 'http://localhost:3001');
        
        // Backward compatibility (Evolution API) - optional
        $this->apiKey = env('EVOLUTION_API_KEY', 'your_api_key_here');
        $this->instanceName = env('EVOLUTION_INSTANCE', 'politala-bot');
    }
    
    /**
     * Check if WhatsApp service is enabled
     * 
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Kirim pesan WhatsApp via WhatsApp Web.js Service
     * 
     * @param string $to Nomor tujuan (format: 628xxx)
     * @param string $message Isi pesan
     * @return array Response dari API
     */
    public function sendMessage($to, $message)
    {
        // Check if WhatsApp is enabled
        if (!$this->enabled) {
            Log::info('WhatsApp DISABLED - Message NOT sent (Development Mode)', [
                'to' => $to,
                'message' => $message,
                'note' => 'Set WHATSAPP_ENABLED=true in .env to enable'
            ]);

            return [
                'success' => true,
                'data' => ['message' => 'WhatsApp disabled in development mode'],
                'status' => 200,
                'development_mode' => true
            ];
        }

        try {
            // Send via whatsapp-web.js service (port 3001)
            $response = Http::timeout(15)->post("{$this->apiUrl}/send", [
                'number' => $to,
                'message' => $message,
            ]);

            $result = $response->json();

            // Log response
            Log::info('WhatsApp Message Sent (WhatsApp-Web.js)', [
                'to' => $to,
                'response' => $result
            ]);

            return [
                'success' => $response->successful() && isset($result['success']) && $result['success'],
                'data' => $result,
                'status' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp Send Error', [
                'error' => $e->getMessage(),
                'to' => $to
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Kirim notifikasi contact form ke admin
     * 
     * @param array $contactData Data kontak (name, email, message)
     * @return array Response
     */
    public function sendContactNotification($contactData)
    {
        $adminNumber = env('WHATSAPP_ADMIN_NUMBER');
        
        $message = "*🔔 PESAN BARU DARI WEBSITE POLITALA OBE*\n\n";
        $message .= "📝 *Nama:* {$contactData['name']}\n";
        $message .= "📧 *Email:* {$contactData['email']}\n";
        $message .= "📅 *Waktu:* " . now()->format('d M Y H:i') . "\n\n";
        $message .= "💬 *Pesan:*\n{$contactData['message']}\n\n";
        $message .= "---\n";
        $message .= "_Pesan ini dikirim otomatis dari sistem_";

        return $this->sendMessage($adminNumber, $message);
    }

    /**
     * Kirim notifikasi konfirmasi ke dosen saat input nilai mahasiswa
     * 
     * @param array $nilaiData Data nilai (mahasiswa, mata kuliah, nilai, dosen)
     * @return array Response
     */
    public function sendNilaiNotification($nilaiData)
    {
        // Kirim notifikasi ke nomor WhatsApp dosen
        $dosenNumber = $nilaiData['dosen_phone'] ?? null;
        
        if (!$dosenNumber) {
            Log::warning('Dosen tidak punya nomor WhatsApp', [
                'dosen' => $nilaiData['dosen_name']
            ]);
            
            return [
                'success' => false,
                'message' => 'Nomor WhatsApp dosen tidak terdaftar'
            ];
        }
        
        $message = "*✅ KONFIRMASI INPUT NILAI*\n\n";
        $message .= "Halo *{$nilaiData['dosen_name']}*,\n\n";
        $message .= "Nilai mahasiswa berhasil disimpan ke sistem:\n\n";
        $message .= "📚 *Mata Kuliah:* {$nilaiData['mata_kuliah']}\n";
        $message .= "📖 *Kode MK:* {$nilaiData['kode_mk']}\n\n";
        $message .= "👤 *Mahasiswa:* {$nilaiData['mahasiswa_name']}\n";
        $message .= "🆔 *NIM:* {$nilaiData['nim']}\n";
        $message .= "📝 *Teknik Penilaian:* {$nilaiData['teknik_penilaian']}\n";
        $message .= "✅ *Nilai:* {$nilaiData['nilai']}\n";
        $message .= "📅 *Tahun:* {$nilaiData['tahun']}\n\n";
        $message .= "⏰ *Waktu Input:* " . now()->format('d M Y H:i') . "\n\n";
        $message .= "---\n";
        $message .= "_Notifikasi otomatis dari Sistem OBE Politala_";

        return $this->sendMessage($dosenNumber, $message);
    }

    /**
     * Kirim notifikasi bulk input nilai ke dosen (untuk storeMultiple)
     * 
     * @param array $bulkData Data multiple nilai
     * @return array Response
     */
    public function sendBulkNilaiNotification($bulkData)
    {
        // Kirim notifikasi ke nomor WhatsApp dosen
        $dosenNumber = $bulkData['dosen_phone'] ?? null;
        
        if (!$dosenNumber) {
            Log::warning('Dosen tidak punya nomor WhatsApp', [
                'dosen' => $bulkData['dosen_name']
            ]);
            
            return [
                'success' => false,
                'message' => 'Nomor WhatsApp dosen tidak terdaftar'
            ];
        }
        
        $totalNilai = count($bulkData['nilai_list']);
        
        $message = "*✅ KONFIRMASI INPUT NILAI (MULTIPLE)*\n\n";
        $message .= "Halo *{$bulkData['dosen_name']}*,\n\n";
        $message .= "Beberapa nilai mahasiswa berhasil disimpan:\n\n";
        $message .= "📚 *Mata Kuliah:* {$bulkData['mata_kuliah']}\n";
        $message .= "📖 *Kode MK:* {$bulkData['kode_mk']}\n\n";
        $message .= "👤 *Mahasiswa:* {$bulkData['mahasiswa_name']}\n";
        $message .= "🆔 *NIM:* {$bulkData['nim']}\n";
        $message .= "📝 *Jumlah Nilai:* {$totalNilai} nilai\n";
        $message .= "📅 *Tahun:* {$bulkData['tahun']}\n\n";
        
        $message .= "*Detail Nilai:*\n";
        foreach ($bulkData['nilai_list'] as $index => $item) {
            $no = $index + 1;
            $message .= "{$no}. {$item['teknik']} = {$item['nilai']}\n";
        }
        
        $message .= "\n⏰ *Waktu Input:* " . now()->format('d M Y H:i') . "\n\n";
        $message .= "---\n";
        $message .= "_Notifikasi otomatis dari Sistem OBE Politala_";

        return $this->sendMessage($dosenNumber, $message);
    }

    /**
     * Check device status (opsional)
     * 
     * @return array Status device
     */
    public function checkDeviceStatus()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post('https://api.fonnte.com/status');

            return [
                'success' => $response->successful(),
                'data' => $response->json()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
