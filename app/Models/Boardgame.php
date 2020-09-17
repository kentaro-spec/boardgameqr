<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boardgame extends Model
{
    //
    protected $guarded = [
        'id'
    ];

    // postテーブルへリレーション
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }
}
