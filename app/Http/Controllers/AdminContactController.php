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

        Mail::raw($request->reply_message, function ($message) use ($toEmail, $contact) {
            $message->to($toEmail)
                ->subject('Balasan Pesan dari POLITALA OBE')
                ->replyTo(config('mail.from.address'), config('mail.from.name'))
                ->from(config('mail.from.address'), config('mail.from.name') ?: 'Admin POLITALA OBE');
        });

        return redirect()
            ->route('admin.contacts.show', $contact->id)
            ->with('success', 'Balasan berhasil dikirim ke ' . $toEmail);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan berhasil dihapus');
    }
}
