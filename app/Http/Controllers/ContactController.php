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

            // Kirim notifikasi WHATSAPP ke admin (OTOMATIS & GRATIS!)
            $whatsappSent = false;
            $emailSent = false;
            
            // 1. Kirim via WhatsApp (Priority)
            try {
                $adminNumber = env('WHATSAPP_ADMIN_NUMBER', '6285754631899');
                $whatsappMessage = "📬 *Pesan Baru dari Website Politala OBE*\n\n";
                $whatsappMessage .= "👤 *Nama:* {$request->name}\n";
                $whatsappMessage .= "📧 *Email:* {$request->email}\n";
                $whatsappMessage .= "💬 *Pesan:*\n{$request->message}\n\n";
                $whatsappMessage .= "⏰ *Waktu:* " . now()->format('d/m/Y H:i') . "\n";
                $whatsappMessage .= "🔗 *Dashboard:* " . url('/admin/contacts');
                
                // Call WhatsApp Web.js service
                $response = \Illuminate\Support\Facades\Http::timeout(5)->post('http://localhost:3000/send', [
                    'number' => $adminNumber,
                    'message' => $whatsappMessage
                ]);
                
                if ($response->successful()) {
                    $whatsappSent = true;
                    Log::info('WhatsApp notification sent successfully', [
                        'contact_id' => $contact->id,
                        'admin_number' => $adminNumber
                    ]);
                }
            } catch (\Exception $whatsappError) {
                Log::warning('WhatsApp notification failed, trying email backup', [
                    'contact_id' => $contact->id,
                    'error' => $whatsappError->getMessage()
                ]);
            }
            
            // 2. Backup: Kirim via Email jika WhatsApp gagal
            if (!$whatsappSent) {
                try {
                    Mail::to(env('ADMIN_EMAIL', 'admin@politala.ac.id'))
                        ->send(new ContactNotification([
                            'name' => $request->name,
                            'email' => $request->email,
                            'message' => $request->message,
                        ]));
                    
                    $emailSent = true;
                    
                    Log::info('Email notification sent successfully (WhatsApp backup)', [
                        'contact_id' => $contact->id,
                        'admin_email' => env('ADMIN_EMAIL')
                    ]);
                } catch (\Exception $emailError) {
                    Log::error('Both WhatsApp and Email notification failed', [
                        'contact_id' => $contact->id,
                        'whatsapp_error' => $whatsappError->getMessage() ?? 'N/A',
                        'email_error' => $emailError->getMessage()
                    ]);
                }
            }

            $notificationMethod = $whatsappSent ? 'WhatsApp' : ($emailSent ? 'Email' : 'Database');
            
            return response()->json([
                'success' => true,
                'message' => "Pesan Anda berhasil dikirim! Admin akan segera diberitahu via {$notificationMethod}.",
                'data' => $contact,
                'whatsapp_sent' => $whatsappSent,
                'email_sent' => $emailSent
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

