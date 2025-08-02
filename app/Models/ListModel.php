<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListModel extends Model
{
    protected $table = 'lists';

    protected $fillable = ['client_id', 'name'];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_list', 'list_id', 'contact_id');
    }
}
