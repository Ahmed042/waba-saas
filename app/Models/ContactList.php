<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactList extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        // add more if you wish
    ];

    // Relation to Client (optional, but recommended)
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

     public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_list_contact', 'list_id', 'contact_id');
    }
}
