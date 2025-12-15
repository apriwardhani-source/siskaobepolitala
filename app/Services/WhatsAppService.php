<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * WhatsApp Service using Fonnte API
 * 
 * Fonnte adalah layanan WhatsApp API berbasis cloud
 * Tidak perlu Node.js, tidak perlu Puppeteer, bisa di shared hosting
 * 
 * @see https://fonnte.com
 */
class WhatsAppService
{
    protected $token;
    protected $apiUrl;
    protected $enabled;

    public function __construct()
    {
        // Check if WhatsApp is enabled
        $this->enabled = env('WHATSAPP_ENABLED', true);
        
        // Fonnte API Configuration
        $this->token = env('FONNTE_TOKEN', '');
        $this->apiUrl = 'https://api.fonnte.com';
    }
    
    /**
     * Check if WhatsApp service is enabled
     * 
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled && !empty($this->token);
    }

    /**
     * Format nomor WhatsApp ke format internasional (628xxx)
     * Mendukung berbagai format input:
     * - 08xxx → 628xxx
     * - +628xxx → 628xxx
     * - 628xxx → 628xxx (no change)
     * 
     * @param string|null $number Nomor telepon
     * @return string|null Nomor dalam format 628xxx atau null jika invalid
     */
    protected function formatPhoneNumber($number)
    {
        if (!$number) {
            return null;
        }

        // Remove spaces, dashes, and special characters
        $number = preg_replace('/[^\d]/', '', $number);

        // If starts with 0, replace with 62
        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        }

        // If doesn't start with 62, add it (assuming Indonesian number)
        if (substr($number, 0, 2) !== '62') {
            $number = '62' . $number;
        }

        // Validate length (Indonesian phone: 10-13 digits after 62)
        if (strlen($number) < 11 || strlen($number) > 15) {
            Log::warning('Invalid phone number length', ['number' => $number]);
            return null;
        }

        return $number;
    }

    /**
     * Kirim pesan WhatsApp via Fonnte API
     * 
     * @param string $to Nomor tujuan (support: 08xxx, 628xxx, +628xxx)
     * @param string $message Isi pesan
     * @return array Response dari API
     */
    public function sendMessage($to, $message)
    {
        // Format phone number to international format
        $formattedNumber = $this->formatPhoneNumber($to);
        
        if (!$formattedNumber) {
            Log::error('Invalid phone number format', ['original' => $to]);
            return [
                'success' => false,
                'error' => 'Invalid phone number format'
            ];
        }

        // Check if WhatsApp is enabled
        if (!$this->isEnabled()) {
            Log::info('WhatsApp DISABLED - Message NOT sent', [
                'to' => $formattedNumber,
                'message' => substr($message, 0, 100) . '...',
                'note' => 'Set WHATSAPP_ENABLED=true and FONNTE_TOKEN in .env to enable'
            ]);

            return [
                'success' => true,
                'data' => ['message' => 'WhatsApp disabled or token not set'],
                'status' => 200,
                'development_mode' => true
            ];
        }

        try {
            // Send via Fonnte API
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post("{$this->apiUrl}/send", [
                'target' => $formattedNumber,
                'message' => $message,
                'countryCode' => '62',
            ]);

            $result = $response->json();

            // Log response
            Log::info('WhatsApp Message Sent (Fonnte)', [
                'to' => $formattedNumber,
                'original' => $to,
                'status' => $result['status'] ?? 'unknown',
                'detail' => $result['detail'] ?? $result['reason'] ?? 'no detail'
            ]);

            // Fonnte returns status: true/false
            $isSuccess = isset($result['status']) && $result['status'] === true;

            return [
                'success' => $isSuccess,
                'data' => $result,
                'status' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp Send Error (Fonnte)', [
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
        
        if (!$adminNumber) {
            Log::warning('WHATSAPP_ADMIN_NUMBER not set in .env');
            return ['success' => false, 'error' => 'Admin number not configured'];
        }
        
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
     * Kirim notifikasi bulk input nilai ke dosen
     * 
     * @param array $bulkData Data multiple nilai
     * @return array Response
     */
    public function sendBulkNilaiNotification($bulkData)
    {
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
     * Check device/connection status via Fonnte
     * 
     * @return array Status device
     */
    public function checkDeviceStatus()
    {
        if (!$this->isEnabled()) {
            return [
                'success' => false,
                'status' => 'disabled',
                'error' => 'WhatsApp not configured'
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post("{$this->apiUrl}/device");

            $result = $response->json();

            return [
                'success' => $response->successful(),
                'status' => $result['status'] ?? 'unknown',
                'data' => $result
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'status' => 'error',
                'error' => $e->getMessage()
            ];
        }
    }
}
