<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WhatsappHelper
{
   public static function sendWhatsappTemplate($to, $templateName, $accessToken, $phoneId)
{
    $url = "https://graph.facebook.com/v19.0/$phoneId/messages";
    $payload = [
        "messaging_product" => "whatsapp",
        "to" => $to,
        "type" => "template",
        "template" => [
            "name" => $templateName,
            "language" => [
                "code" => "en_US"
            ]
        ]
    ];
    $response = \Http::withToken($accessToken)
        ->post($url, $payload);
    return $response->json();
}

}
