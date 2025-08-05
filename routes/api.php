<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WhatsappWebhookController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/whatsapp/webhook', [App\Http\Controllers\Api\WhatsappWebhookController::class, 'handle']);
Route::match(['GET', 'POST'], '/whatsapp/webhook', [WhatsappWebhookController::class, 'handle']);