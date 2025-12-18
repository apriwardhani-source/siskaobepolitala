<?php

namespace App\Http\Controllers;

use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Admin WhatsApp Controller
 * 
 * Menggunakan Fonnte API - tidak perlu QR code atau Node.js
 * Cukup setup token di .env
 */
class AdminWhatsAppController extends Controller
{
    protected $whatsapp;

    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    /**
     * Show WhatsApp settings page
     */
    public function connect()
    {
        // Check status via Fonnte API
        $status = $this->whatsapp->checkDeviceStatus();
        
        $isConnected = $status['success'] && isset($status['data']['device']) && $status['data']['device'] === 'connected';
        
        return view('admin.whatsapp.connect', [
            'status' => $isConnected ? 'connected' : 'disconnected',
            'deviceInfo' => $status['data'] ?? null,
            'isEnabled' => $this->whatsapp->isEnabled(),
            'error' => $status['error'] ?? null,
            // Fonnte tidak perlu QR code
            'hasQR' => false,
            'isFonnte' => true
        ]);
    }
    
    /**
     * Get connection status
     */
    public function status()
    {
        $status = $this->whatsapp->checkDeviceStatus();
        
        return response()->json([
            'status' => $status['status'] ?? 'unknown',
            'isEnabled' => $this->whatsapp->isEnabled(),
            'hasQR' => false, // Fonnte tidak pakai QR
            'data' => $status['data'] ?? null,
            'error' => $status['error'] ?? null
        ]);
    }
    
    /**
     * Get QR code - Tidak diperlukan untuk Fonnte
     */
    public function getQR()
    {
        return response()->json([
            'success' => false,
            'message' => 'Fonnte tidak memerlukan QR code. Silakan hubungkan di dashboard Fonnte.',
            'fonnte_url' => 'https://fonnte.com'
        ]);
    }
    
    /**
     * Start service - Tidak diperlukan untuk Fonnte
     */
    public function startService()
    {
        return response()->json([
            'success' => true,
            'message' => 'Fonnte adalah layanan cloud, tidak perlu start service manual. Pastikan token sudah dikonfigurasi di .env',
            'instructions' => [
                '1. Daftar di https://fonnte.com',
                '2. Hubungkan nomor WhatsApp di dashboard Fonnte',
                '3. Copy token API',
                '4. Set FONNTE_TOKEN=xxx di file .env',
                '5. Set WHATSAPP_ENABLED=true di file .env'
            ]
        ]);
    }
    
    /**
     * Restart service - Tidak diperlukan untuk Fonnte
     */
    public function restartService()
    {
        return response()->json([
            'success' => true,
            'message' => 'Untuk restart koneksi WhatsApp, silakan lakukan di dashboard Fonnte: https://fonnte.com',
        ]);
    }
    
    /**
     * Test send message
     */
    public function testSend(Request $request)
    {
        $request->validate([
            'number' => 'required|string',
            'message' => 'required|string'
        ]);
        
        try {
            $result = $this->whatsapp->sendMessage(
                $request->number,
                $request->message
            );
            
            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan berhasil dikirim via Fonnte!',
                    'data' => $result['data']
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pesan',
                'error' => $result['error'] ?? $result['data']['reason'] ?? 'Unknown error'
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('WhatsApp Test Send Error', [
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
