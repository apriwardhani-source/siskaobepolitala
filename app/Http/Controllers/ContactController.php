<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ContactNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'message.required' => 'Pesan harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Simpan ke database
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
            ]);

            // Kirim notifikasi WHATSAPP ke admin (OTOMATIS!)
            $whatsappSent = false;
            
            // Kirim via WhatsApp
            try {
                $adminNumber = env('WHATSAPP_ADMIN_NUMBER', '6285754631899');
                $whatsappMessage = "📬 *Pesan Baru dari Website Politala OBE*\n\n";
                $whatsappMessage .= "👤 *Nama:* {$request->name}\n";
                $whatsappMessage .= "📧 *Email:* {$request->email}\n";
                $whatsappMessage .= "💬 *Pesan:*\n{$request->message}\n\n";
                $whatsappMessage .= "⏰ *Waktu:* " . now()->format('d/m/Y H:i') . "\n";
                $whatsappMessage .= "🔗 *Dashboard:* " . url('/admin/contacts');
                
                // Call WhatsApp Web.js service
                $response = \Illuminate\Support\Facades\Http::timeout(15)->post('http://localhost:3001/send', [
                    'number' => $adminNumber,
                    'message' => $whatsappMessage
                ]);
                
                if ($response->successful()) {
                    $whatsappSent = true;
                    Log::info('WhatsApp notification sent successfully', [
                        'contact_id' => $contact->id,
                        'admin_number' => $adminNumber,
                        'response' => $response->json()
                    ]);
                } else {
                    Log::error('WhatsApp API returned error', [
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                }
            } catch (\Exception $whatsappError) {
                Log::error('WhatsApp notification exception', [
                    'contact_id' => $contact->id,
                    'error' => $whatsappError->getMessage(),
                    'trace' => $whatsappError->getTraceAsString()
                ]);
            }
            
            $notificationMethod = $whatsappSent ? 'WhatsApp' : 'Database';
            
            return response()->json([
                'success' => true,
                'message' => "Pesan Anda berhasil dikirim! Admin akan segera diberitahu via {$notificationMethod}.",
                'data' => $contact,
                'whatsapp_sent' => $whatsappSent
            ], 200);

        } catch (\Exception $e) {
            Log::error('Contact form submission error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

