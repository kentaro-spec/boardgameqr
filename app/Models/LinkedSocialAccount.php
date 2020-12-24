<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedSocialAccount extends Model
{
    protected $fillable = ['provider_id', 'provider_name'];

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
