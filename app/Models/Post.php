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
    // answersテーブルへリレーション
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
        return $this::with(['user','boardgame','answers'])->where('user_id',$user_id)->get();
    }
    
    //突っ込んだユーザーIDの質問総数を取ってくる
    public function getQuestionCount($user_id){
        return $this->where('user_id',$user_id)->count();
    }

    // 質問を分ける。クエリスコープ
    public function scopeQuestion($query, $tab){
        if($tab === 'new'){
            return $query;
        }elseif($tab === 'solved'){
            return $query->whereIn('id', function($query) {
                return $query->select('post_id')
                             ->from('answers')
                             ->where('bestanswer_flag', '=' , 1);
            });
        }else{
            return $query->whereNotIn('id', function($query){
                return $query->select('post_id')
                             ->from('answers')
                             ->where('bestanswer_flag', '=' , 1);
            });
        }
    }
}
