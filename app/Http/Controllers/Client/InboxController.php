<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Message;

class InboxController extends Controller
{
    // Inbox landing: List contacts with recent messages
    public function index($company, $contactId = null)
{
    $client = Client::where('company', $company)->firstOrFail();

    // All contacts who have sent/received messages (even if name is null)
    $contacts = Contact::where('client_id', $client->id)
        ->whereHas('messages')
        ->with(['messages' => function($q) {
            $q->latest()->limit(1);
        }])
        ->get();
        

    $selectedContact = null;
    $messages = collect();
    if ($contactId) {
        $selectedContact = Contact::where('client_id', $client->id)->where('id', $contactId)->first();
        if ($selectedContact) {
            $messages = Message::where('client_id', $client->id)
                ->where('contact_id', $selectedContact->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }
    }

    return view('client.inbox', compact('company', 'contacts', 'selectedContact', 'messages'));
}


    // Show chat with a contact
    public function chat($company, $contactId)
    {
        $client = Client::where('company', $company)->firstOrFail();
        $contact = Contact::where('client_id', $client->id)->where('id', $contactId)->firstOrFail();

        // Show last 50 messages
        $messages = Message::where('client_id', $client->id)
            ->where('contact_id', $contact->id)
            ->orderBy('created_at', 'asc')
            ->limit(50)
            ->get();

        return view('client.chat', compact('company', 'contact', 'messages'));
    }

    // Send a message from chat
    public function send(Request $request, $company, $contactId)
    {
        $client = Client::where('company', $company)->firstOrFail();
        $contact = Contact::where('client_id', $client->id)->where('id', $contactId)->firstOrFail();

        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        Message::create([
            'client_id' => $client->id,
            'contact_id' => $contact->id,
            'message' => $request->message,
            'status' => 'pending',
            'direction' => 'sent',
        ]);

        // Optionally: send via WhatsApp API

        return redirect()->route('client.inbox.chat', ['company' => $company, 'contact' => $contactId])
            ->with('success', 'Message sent.');
    }
}
