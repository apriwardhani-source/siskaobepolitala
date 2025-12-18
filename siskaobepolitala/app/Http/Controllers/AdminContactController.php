<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(20);
        $unreadCount = Contact::where('is_read', false)->count();
        
        return view('admin.contacts.index', compact('contacts', 'unreadCount'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        
        // Mark as read
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }
        
        return view('admin.contacts.detail', compact('contact'));
    }

    public function reply(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $request->validate([
            'reply_message' => 'required|string|max:5000',
        ]);

        $toEmail = $contact->email;

        $originalDate = $contact->created_at
            ? $contact->created_at->format('d M Y H:i')
            : '-';

        $replyDate = now()->format('d M Y H:i');

        $body  = "Halo {$contact->name},\n\n";
        $body .= "Berikut balasan dari admin untuk pesan Anda di sistem POLITALA OBE.\n\n";
        $body .= "---- Pesan Anda (dikirim pada {$originalDate}) ----\n";
        $body .= ($contact->message ?? '-') . "\n\n";
        $body .= "---- Balasan Admin ({$replyDate}) ----\n";
        $body .= $request->reply_message . "\n\n";
        $body .= "Salam,\nAdmin POLITALA OBE";

        try {
            Mail::raw($body, function ($message) use ($toEmail, $contact) {
                $message->to($toEmail)
                    ->subject('Balasan atas Pesan Anda di POLITALA OBE')
                    ->replyTo(config('mail.from.address'), config('mail.from.name'))
                    ->from(config('mail.from.address'), config('mail.from.name') ?: 'Admin POLITALA OBE');
            });

            $contact->update([
                'is_replied' => true,
                'is_read' => true,
            ]);

            return redirect()
                ->route('admin.contacts.show', $contact->id)
                ->with('success', 'Balasan berhasil dikirim ke ' . $toEmail);
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim balasan kontak', [
                'contact_id' => $contact->id,
                'email' => $toEmail,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.contacts.show', $contact->id)
                ->with('error', 'Kirim email gagal. Kemungkinan limit harian Gmail sudah tercapai atau konfigurasi email sedang bermasalah.');
        }
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan berhasil dihapus');
    }
}
