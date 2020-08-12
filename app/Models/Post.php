<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $guarded = [
        'id'
    ];

    // usersテーブルへリレーション
    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

    public function answers()
    {
        return $this->hasMany('\App\Models\Answer');
    }
    // boardgamesテーブルへリレーション
    public function boardgame()
    {
        return $this->belongsTo('\App\Models\Boardgame');
    }

    //突っ込んだユーザーIDの質問を取ってくる
    public function getUserQuestions($user_id){
        return $this->where('user_id',$user_id)->get();
    }
    //突っ込んだユーザーIDの質問総数を取ってくる
    public function getQuestionCount($user_id){
        return $this->where('user_id',$user_id)->count();
    }
}
