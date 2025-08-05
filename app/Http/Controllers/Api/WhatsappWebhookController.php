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
// --- VERIFICATION HANDLER ---
    if ($request->has('hub_mode') && $request->input('hub_mode') === 'subscribe') {
        $verify_token = 'rubattwhatsapp2025'; // (Must match what you enter in Meta)
        if ($request->input('hub_verify_token') === $verify_token) {
            return response($request->input('hub_challenge'), 200);
        }
        return response('Invalid verify token', 403);
    }

    // --- (Optional: Also handle GET requests) ---
    if ($request->has('hub_mode')) { // fallback
        return response('Missing or invalid', 403);
    }

        $data = $request->all();
        \Log::info('WA Webhook', $data); // For debugging

        // Loop through entries (handle bulk & single)
        if(isset($data['entry'])) {
            foreach ($data['entry'] as $entry) {
                foreach ($entry['changes'] as $change) {
                    $messages = $change['value']['messages'] ?? [];
                    foreach ($messages as $msg) {
    $waId = $msg['from'];
    $text = $msg['text']['body'] ?? null;

    // New: Handle audio messages
    $audioMediaId = null;
    if (($msg['type'] ?? null) === 'audio' && isset($msg['audio']['id'])) {
        $audioMediaId = $msg['audio']['id']; // This is WhatsApp's media ID, not a URL!
    }

    $client = Client::where('phone_id', $change['value']['metadata']['phone_number_id'])->first();
    if (!$client) continue;

    $contact = Contact::firstOrCreate(
        ['phone' => $waId, 'client_id' => $client->id],
        ['name' => $waId]
    );

    // Save incoming message (now supports audio or text)
    Message::create([
        'client_id' => $client->id,
        'contact_id' => $contact->id,
        'message' => $text,
        'audio' => $audioMediaId,   // Make sure your Message model/table has this column!
        'status' => 'received',
        'direction' => 'received',
    ]);
}

                }
            }
        }
        return response()->json(['status' => 'ok']);
        // \Log::info('Saved received message', ['client_id' => $client->id, 'contact_id' => $contact->id, 'msg' => $text]);

    }
}
