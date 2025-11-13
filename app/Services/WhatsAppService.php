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
        
        // Evolution API Config (GRATIS!)
        $this->apiKey = env('EVOLUTION_API_KEY', 'your_api_key_here');
        $this->apiUrl = env('EVOLUTION_API_URL', 'http://localhost:8080');
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
     * Kirim pesan WhatsApp via Evolution API (Gratis!)
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
            $response = Http::withHeaders([
                'apikey' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/message/sendText/{$this->instanceName}", [
                'number' => $to,
                'text' => $message,
            ]);

            $result = $response->json();

            // Log response
            Log::info('WhatsApp Message Sent (Evolution API)', [
                'to' => $to,
                'response' => $result
            ]);

            return [
                'success' => $response->successful(),
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
     * Kirim notifikasi ke admin saat dosen input nilai mahasiswa
     * 
     * @param array $nilaiData Data nilai (mahasiswa, mata kuliah, nilai, dosen)
     * @return array Response
     */
    public function sendNilaiNotification($nilaiData)
    {
        $adminNumber = env('WHATSAPP_ADMIN_NUMBER');
        
        $message = "*📊 NILAI MAHASISWA BARU*\n\n";
        $message .= "👨‍🏫 *Dosen:* {$nilaiData['dosen_name']}\n";
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

        return $this->sendMessage($adminNumber, $message);
    }

    /**
     * Kirim notifikasi bulk input nilai (untuk storeMultiple)
     * 
     * @param array $bulkData Data multiple nilai
     * @return array Response
     */
    public function sendBulkNilaiNotification($bulkData)
    {
        $adminNumber = env('WHATSAPP_ADMIN_NUMBER');
        
        $totalNilai = count($bulkData['nilai_list']);
        
        $message = "*📊 INPUT NILAI MAHASISWA (BULK)*\n\n";
        $message .= "👨‍🏫 *Dosen:* {$bulkData['dosen_name']}\n";
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

        return $this->sendMessage($adminNumber, $message);
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
