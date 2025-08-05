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
    public function index($company, $contact = null)
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
    if ($contact) {
        $selectedContact = Contact::where('client_id', $client->id)->where('id', $contact)->first();
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
    public function chat($company, $contact)
    {
        $client = Client::where('company', $company)->firstOrFail();
        $contact = Contact::where('client_id', $client->id)->where('id', $contact)->firstOrFail();

        // Show last 50 messages
        $messages = Message::where('client_id', $client->id)
            ->where('contact_id', $contact->id)
            ->orderBy('created_at', 'asc')
            ->limit(50)
            ->get();

        return view('client.chat', compact('company', 'contact', 'messages'));
    }

    // Send a message from chat
   public function send(Request $request, $company, $contact)
{
    $client = Client::where('company', $company)->firstOrFail();
    $contact = Contact::where('client_id', $client->id)->where('id', $contact)->firstOrFail();

   $request->validate([
    'message' => 'nullable|string|max:2000', // make message nullable
    'audio' => 'nullable|file|mimes:mp3,wav,ogg,webm|max:2048', // 2MB, adjust as needed
]);
$audioPath = null;
if ($request->hasFile('audio')) {
    $audioPath = $request->file('audio')->store('voice', 'public');
}


    $msg = Message::create([
        'client_id' => $client->id,
        'contact_id' => $contact->id,
        'message' => $request->message,
        'audio' => $audioPath,
        'status' => 'pending',
        'direction' => 'sent',
    ]);

    if ($request->ajax()) {
        // Return rendered message bubble HTML for the just sent message
        $html = view('partials.single-message', ['msg' => $msg])->render();
        return response()->json(['html' => $html]);
    }

    // Fallback for non-AJAX
    return redirect()->route('client.inbox.chat', ['company' => $company, 'contact' => $contact])
        ->with('success', 'Message sent.');
}

public function getMessages($company, $contact)
{
    $messages = Message::where('contact_id', $contact)
        ->orderBy('created_at', 'asc')
        ->get();

    return response()->json([
        'html' => view('partials.chat-messages', compact('messages'))->render()
    ]);
}


}
