<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $guarded = [
        "id"
    ];

    //リレーション
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function post() 
    {
        return $this->belongsTo('\App\Models\Post');
    }

    //突っ込んだユーザーIDの回答を取ってくる
    public function getUserAnswers($user_id){
        // dd($this->where('user_id',$user_id)->get());
        return $this->with('post')->where('user_id',$user_id)->get();
    }
    public function getAnswersCount($user_id){
        return $this->where('user_id',$user_id)->count();
    }
    
}
