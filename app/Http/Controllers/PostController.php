<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Answer;

class PostController extends Controller
{
    //一覧ページ
    public function index()
    {   
        $posts = Post::all();
        return view('post',compact('posts'));
    }
    //質問ページ
    public function qr()
    {
        return view('qr');
    }
    //質問内容をDBに挿入する
    public function insert_qr(Request $request, Post $post)
    {   
        // imgpath以外をとってくる
        $form = $request->only('boardgamename','text','interpretation');
        
        // storeでやる
        // $request->imgpath->store('public');
        // $form['imgpath']= $request->imgpath->hashName();

        // storeAsでやる
        // オリジナルのファイルネームをとってきて、その名前でstorage/app/publicフォルダに突っ込む
        //storeAsは第3引数まである。
        $file_name=$request->imgpath->getClientOriginalName();
        $form['imgpath']= $request->imgpath->storeAs('',$file_name,'public');
    
        // fileメソッド使っても使わなくても一緒？
        // $file_name = $request->file('imgpath')->getClientOriginalName();
        // $img = $request->file('imgpath')->storeAs('',$file_name,''public);
        // $form['imgpath'] = $img;

        unset($form['_token']);
        $post->create($form);
        return redirect('/');
    }

    //質問詳細ページへ
    public function show_qr(Request $request)
    {
        $post_id = $request->id;
        $questions = Post::find($post_id);
        $answers = Answer::where('post_id', $post_id)->get();
        return view('qr_info',['questions' => $questions,'answers' => $answers]);

    }

    // 回答内容をDBへ挿入する
    public function answer_qr(Request $request, Answer $answer)
    {   
        $form = $request->only(['text','post_id','user_id']);
        unset($form[('_token')]);
        $answer->create($form);
        
        $post_id = $request->post_id;
        // dd($post_id);

        return redirect()->route('show',['id' => $post_id]);
    }

}
