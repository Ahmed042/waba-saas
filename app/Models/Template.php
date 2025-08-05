<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'client_id', 'meta_id', 'name', 'language', 'body', 'status', 'meta_response'
    ];
}
