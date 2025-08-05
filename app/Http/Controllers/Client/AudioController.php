<?php
namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AudioController extends Controller
{
    public function fetch($mediaId)
    {
        // 1. Get the client that received this message (to get token)
        // 2. Get media url from WhatsApp API (step 1)
        // 3. Download media and stream it (step 2)

        // Example (simplified, needs error handling):

        $client = \App\Models\Client::first(); // (Or use request param, or find by message)
        $token = $client->access_token;

        // Step 1: Get the real media URL
        $mediaResp = Http::withToken($token)
            ->get("https://graph.facebook.com/v18.0/{$mediaId}");
        if (!$mediaResp->ok()) {
            abort(404, "Media not found");
        }
        $mediaUrl = $mediaResp->json()['url'];

        // Step 2: Download media content
        $audioResp = Http::withToken($token)
            ->withHeaders(['Accept' => '*/*'])
            ->get($mediaUrl);

        if (!$audioResp->ok()) {
            abort(404, "Audio fetch failed");
        }

        // Step 3: Stream to browser
        return response($audioResp->body(), 200)
            ->header('Content-Type', $audioResp->header('Content-Type', 'audio/ogg'));
    }
}
