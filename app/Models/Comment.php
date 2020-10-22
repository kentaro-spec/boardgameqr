<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $guarded = [
        'id'
    ];

    //リレーション
    public function answer()
    {
        return $this->belongsTo('\App\Models\Answer');

    }
    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
}