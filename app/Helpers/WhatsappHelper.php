<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Support\Facades\Http;

class WhatsappWebhookController extends Controller
{
    public function handle(Request $request)
    {
        \Log::info('WA Webhook ' . json_encode($request->all()));

        $entry = $request->input('entry')[0] ?? null;
        if (!$entry) return response()->json(['status' => 'no entry'], 400);

        $changes = $entry['changes'][0] ?? null;
        if (!$changes) return response()->json(['status' => 'no changes'], 400);

        $value = $changes['value'] ?? null;
        if (!$value) return response()->json(['status' => 'no value'], 400);

        $messages = $value['messages'][0] ?? null;
        if (!$messages) return response()->json(['status' => 'no messages'], 200);

        $from = $messages['from'] ?? '';
        $type = $messages['type'] ?? '';

        // TODO: Replace with actual logic to get client and contact IDs
        $client_id = 1;
        $contact_id = 1;

        $messageText = null;

        if ($type === 'text') {
            $messageText = $messages['text']['body'] ?? '';
        } 
        elseif ($type === 'audio') {
    $audio = $messages['audio'] ?? [];
    $mediaId = $audio['id'] ?? null;

    if (
        !$mediaId ||
        $mediaId === 'Over 9 levels deep, aborting normalization' ||
        strlen($mediaId) < 10
    ) {
        \Log::warning("Invalid audio media ID received: " . json_encode($mediaId));
        $messageText = '[Audio message received: media not available]';
    } else {
        // Fetch the media URL from WhatsApp
        $accessToken = env('WHATSAPP_ACCESS_TOKEN');
        $mediaUrl = $this->fetchMediaUrl($mediaId, $accessToken);

        if ($mediaUrl) {
            // Download and store the file locally (using Laravel storage)
            $audioContent = Http::withToken($accessToken)->withHeaders([
                'Accept' => 'application/octet-stream',
            ])->get($mediaUrl)->body();

            $audioFilename = 'voice/' . $mediaId . '.ogg'; // Always use .ogg for WhatsApp voice notes

            \Storage::disk('public')->put($audioFilename, $audioContent);

            // Save the local audio path (relative to /storage)
            $audioPath = $audioFilename;

            // Set messageText as null since this is an audio message only
            $messageText = null;
        } else {
            \Log::warning("Failed to fetch media URL for ID: " . $mediaId);
            $messageText = '[Audio message received: failed to fetch media]';
            $audioPath = null;
        }
    }
} else {
    $messageText = '[Unsupported message type: ' . $type . ']';
    $audioPath = null;
}

      // ... after your main message type detection logic

if (empty($messageText) || $messageText === null) {
    $messageText = '[Empty message received or not supported]';
}

// Now safe to insert
Message::create([
    'client_id' => $client_id,
    'contact_id' => $contact_id,
    'message' => $messageText,
    'audio' => $audioPath ?? null,  // <-- This is new!
    'status' => 'received',
    'direction' => 'received',
]);



        return response()->json(['status' => 'success']);
    }

    // Fetches the direct download URL for a media file from WhatsApp
    private function fetchMediaUrl($mediaId, $accessToken)
    {
        // Step 1: Get the actual media URL
        $url = "https://graph.facebook.com/v19.0/$mediaId";
        $response = Http::withToken($accessToken)->get($url);

        if (!$response->successful()) {
            \Log::warning('WhatsApp API fetchMediaUrl failed: ' . $response->body());
            return null;
        }

        $json = $response->json();
        if (empty($json['url'])) return null;

        $mediaUrl = $json['url'];

        // Step 2: Get the file itself (protected endpoint), return the download URL
        // WhatsApp requires the same bearer token for downloading
        // You can use this URL directly in your <audio> player

        return $mediaUrl;
    }
}
