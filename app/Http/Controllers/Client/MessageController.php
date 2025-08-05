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
        'audio' => $audioPath,
        'status' => 'pending',
        'direction' => 'sent',
    ]);
    

    // 2. SEND TO WHATSAPP VIA API (CALL HELPER HERE!)
 $response = WhatsappHelper::sendTextMessage(
    $contact->phone,
    $request->message,
    $client->access_token,
    $client->phone_id
);



    // 3. Redirect back as before
    return redirect()->route('client.inbox.chat', ['company' => $company, 'contact' => $contactId])
        ->with('success', 'Message sent.');
}
public function sendBulk(Request $request, $company)
{
    $client = Client::where('company', $company)->firstOrFail();

    // Updated validation: require contact_ids OR list_id
    $request->validate([
        'message' => 'required|string|max:2000',
        'contact_ids' => 'required_without:list_id|array',
        'contact_ids.*' => 'exists:contacts,id',
       'list_id' => 'required_without:contact_ids|nullable|exists:lists,id'

    ]);

    // Gather contact IDs
    $contactIds = $request->contact_ids ?? [];

    // If a list is selected, expand to all its contacts
    if ($request->filled('list_id')) {
        $list = ListModel::where('client_id', $client->id)->find($request->list_id);
        if ($list) {
            $listContactIds = $list->contacts()->pluck('contacts.id')->toArray();            // Merge selected contacts and list contacts, remove duplicates
            $contactIds = array_unique(array_merge($contactIds, $listContactIds));
        }
    }

    if (empty($contactIds)) {
        return redirect()->back()->withErrors(['You must select at least one contact or list.']);
    }

    foreach ($contactIds as $contactId) {
        $contact = Contact::where('client_id', $client->id)->where('id', $contactId)->first();
        if ($contact) {
            Message::create([
                'client_id' => $client->id,
                'contact_id' => $contact->id,
                'message' => $request->message,
                'status' => 'pending',
                'direction' => 'sent',
            ]);
            WhatsappHelper::sendTextMessage(
                $contact->phone,
                $request->message,
                $client->access_token,
                $client->phone_id
            );
        }
    }

    return redirect()->route('client.send_message', ['company' => $company])
        ->with('success', 'Messages sent.');
}

}
