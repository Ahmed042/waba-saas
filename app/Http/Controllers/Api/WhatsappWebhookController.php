<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Client;
use App\Models\Contact;

class WhatsappWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $data = $request->all();
        \Log::info('WA Webhook', $data); // For debugging

        // Loop through entries (handle bulk & single)
        if(isset($data['entry'])) {
            foreach ($data['entry'] as $entry) {
                foreach ($entry['changes'] as $change) {
                    $messages = $change['value']['messages'] ?? [];
                    foreach ($messages as $msg) {
                        // Get sender phone and message
                        $waId = $msg['from'];
                        $text = $msg['text']['body'] ?? null;

                        // Find contact (by wa_id/phone) and client (by phone_id)
                        $client = Client::where('phone_id', $change['value']['metadata']['phone_number_id'])->first();
                        if (!$client) continue;

                        $contact = Contact::firstOrCreate(
                            ['phone' => $waId, 'client_id' => $client->id],
                            ['name' => $waId] // or empty/default name
                        );

                        // Save incoming message
                        Message::create([
                            'client_id' => $client->id,
                            'contact_id' => $contact->id,
                            'message' => $text,
                            'status' => 'received',
                            'direction' => 'received',
                        ]);
                    }
                }
            }
        }
        return response()->json(['status' => 'ok']);
        \Log::info('Saved received message', ['client_id' => $client->id, 'contact_id' => $contact->id, 'msg' => $text]);

    }
}
