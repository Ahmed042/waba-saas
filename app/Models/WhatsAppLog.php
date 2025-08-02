<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsAppLog extends Model
{
    protected $table = 'whatsapp_logs'; // ✅ NOT whats_app_logs
    protected $fillable = ['client_id', 'message', 'status'];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
