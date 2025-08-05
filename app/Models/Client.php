<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'company_slug', 'company_name', 'email', 'password', 'role', 'phone',
        'callback_url', 'phone_id', 'access_token','waba_id', 'api_type', 'password_updated_at'
    ];

    protected $dates = ['password_updated_at'];
}
