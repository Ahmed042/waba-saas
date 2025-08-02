<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['client_id', 'name', 'phone'];


    public function lists()
{
    return $this->belongsToMany(ListModel::class, 'contact_list', 'contact_id', 'list_id');
}

public function messages()
{
    return $this->hasMany(\App\Models\Message::class);
}

}
