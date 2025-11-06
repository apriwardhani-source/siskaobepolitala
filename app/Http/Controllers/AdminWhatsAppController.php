<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminWhatsAppController extends Controller
{
    /**
     * Show WhatsApp connection page with QR code
     */
    public function connect()
    {
        try {
            // Check WhatsApp service status
            $response = Http::timeout(5)->get('http://localhost:3001/status');
            
            $status = $response->successful() ? $response->json() : ['status' => 'offline', 'hasQR' => false];
            
            return view('admin.whatsapp.connect', [
                'status' => $status['status'] ?? 'offline',
                'hasQR' => $status['hasQR'] ?? false
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to check WhatsApp status', [
                'error' => $e->getMessage()
            ]);
            
            return view('admin.whatsapp.connect', [
                'status' => 'offline',
                'hasQR' => false,
                'error' => 'WhatsApp service tidak berjalan. Jalankan: node whatsapp-service.cjs'
            ]);
        }
    }
    
    /**
     * Get QR code data
     */
    public function getQR()
    {
        try {
            $response = Http::timeout(10)->get('http://localhost:3001/qr');
            
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'html' => $response->body()
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch QR code'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Check connection status
     */
    public function status()
    {
        try {
            $response = Http::timeout(5)->get('http://localhost:3001/status');
            
            if ($response->successful()) {
                return response()->json($response->json());
            }
            
            return response()->json([
                'status' => 'offline',
                'hasQR' => false
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'offline',
                'hasQR' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Start WhatsApp Service (via PM2)
     */
    public function startService()
    {
        try {
            // Check if PM2 service already running
            $statusCheck = shell_exec('npx pm2 list 2>&1');
            
            if (strpos($statusCheck, 'whatsapp-service') !== false && strpos($statusCheck, 'online') !== false) {
                return response()->json([
                    'success' => true,
                    'message' => 'Service sudah running! Refresh halaman untuk lihat status.',
                ]);
            }
            
            // Start service
            $configPath = base_path('ecosystem.config.cjs');
            $result = shell_exec("npx pm2 start \"{$configPath}\" 2>&1");
            
            // Check if service started successfully
            if (strpos($result, 'online') !== false || 
                strpos($result, 'already') !== false || 
                strpos($result, 'launched') !== false ||
                strpos($result, 'whatsapp-service') !== false) {
                
                // Wait a bit for service to fully start
                sleep(2);
                
                return response()->json([
                    'success' => true,
                    'message' => 'WhatsApp Service berhasil dijalankan! Refresh halaman untuk scan QR code.',
                ]);
            }
            
            // If we get here, something went wrong
            return response()->json([
                'success' => false,
                'message' => 'Service mungkin sudah running. Coba klik "Refresh Status" untuk cek.',
                'details' => 'Jika masih bermasalah, hubungi developer untuk start PM2 service di server.'
            ], 500);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'details' => 'Pastikan PM2 sudah terinstall di server.'
            ], 500);
        }
    }
    
    /**
     * Restart WhatsApp Service
     */
    public function restartService()
    {
        try {
            // Delete service completely
            shell_exec('npx pm2 delete whatsapp-service 2>&1');
            
            // Wait for process to fully stop
            sleep(3);
            
            // Try to delete session folders
            $sessionPaths = [
                base_path('whatsapp-auth'),
                base_path('.wwebjs_auth'),
                base_path('.wwebjs_cache')
            ];
            
            $deletedFolders = [];
            foreach ($sessionPaths as $path) {
                if (file_exists($path)) {
                    try {
                        $this->deleteDirectory($path);
                        $deletedFolders[] = basename($path);
                    } catch (\Exception $e) {
                        // Ignore permission errors, continue anyway
                        \Log::warning('Could not delete session folder', ['path' => $path, 'error' => $e->getMessage()]);
                    }
                }
            }
            
            // Start service fresh
            $configPath = base_path('ecosystem.config.cjs');
            $result = shell_exec("npx pm2 start \"{$configPath}\" 2>&1");
            
            $message = 'Service berhasil direstart! ';
            if (count($deletedFolders) > 0) {
                $message .= 'Session di-clear (' . implode(', ', $deletedFolders) . '). ';
            }
            $message .= 'Refresh halaman untuk scan QR code baru.';
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'output' => $result
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Helper: Delete directory recursively
     */
    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
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
            $response = Http::timeout(15)->post('http://localhost:3001/send', [
                'number' => $request->number,
                'message' => $request->message
            ]);
            
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan berhasil dikirim!',
                    'data' => $response->json()
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pesan',
                'error' => $response->body()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
