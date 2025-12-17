<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ContactNotification;
use App\Services\WhatsAppService;
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

            // Kirim notifikasi WHATSAPP ke admin via Fonnte
            $whatsappSent = false;
            
            try {
                $whatsappService = new WhatsAppService();
                
                $result = $whatsappService->sendContactNotification([
                    'name' => $request->name,
                    'email' => $request->email,
                    'message' => $request->message
                ]);
                
                if ($result['success']) {
                    $whatsappSent = true;
                    Log::info('WhatsApp notification sent successfully via Fonnte', [
                        'contact_id' => $contact->id,
                        'result' => $result
                    ]);
                } else {
                    Log::warning('WhatsApp notification not sent', [
                        'contact_id' => $contact->id,
                        'result' => $result
                    ]);
                }
            } catch (\Exception $whatsappError) {
                Log::error('WhatsApp notification exception', [
                    'contact_id' => $contact->id,
                    'error' => $whatsappError->getMessage()
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

