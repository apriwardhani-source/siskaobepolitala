<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiKey;
    protected $apiUrl;
    protected $instanceName;

    public function __construct()
    {
        // Evolution API Config (GRATIS!)
        $this->apiKey = env('EVOLUTION_API_KEY', 'your_api_key_here');
        $this->apiUrl = env('EVOLUTION_API_URL', 'http://localhost:8080');
        $this->instanceName = env('EVOLUTION_INSTANCE', 'politala-bot');
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
