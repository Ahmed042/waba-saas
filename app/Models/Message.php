<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['client_id', 'contact_id', 'message','audio', 'status', 'direction'];

}
