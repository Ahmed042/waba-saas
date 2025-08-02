<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Contact;
use App\Models\ListModel;
use App\Models\Message;
use App\Helpers\WhatsappHelper;


class MessageController extends Controller
{
    // Show the send message form
    public function index($company)
    {
        $client = Client::where('company', $company)->firstOrFail();
        $lists = ListModel::where('client_id', $client->id)->get();
        $contacts = Contact::where('client_id', $client->id)->get();
   

        return view('client.send_message', compact('company', 'lists', 'contacts'));
    }

    // Send message to selected contacts/list
    public function send(Request $request, $company, $contactId)
{

    $client = Client::where('company', $company)->firstOrFail();
    $contact = Contact::where('client_id', $client->id)->where('id', $contactId)->firstOrFail();

    $request->validate([
        'message' => 'required|string|max:2000',
    ]);

    // 1. Save to your database
    Message::create([
        'client_id' => $client->id,
        'contact_id' => $contact->id,
        'message' => $request->message,
        'status' => 'pending',
        'direction' => 'sent',
    ]);
    

    // 2. SEND TO WHATSAPP VIA API (CALL HELPER HERE!)
   $response = WhatsappHelper::sendWhatsappTemplate(
    $contact->phone,
    'hello_world', // or your approved template name
    $client->access_token,
    $client->phone_id
);


    // 3. Redirect back as before
    return redirect()->route('client.inbox.chat', ['company' => $company, 'contact' => $contactId])
        ->with('success', 'Message sent.');
}
}
