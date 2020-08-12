<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Answer;
use App\Models\User;
use App\Models\Boardgame;

class PostController extends Controller
{
    //一覧ページ
    public function index()
    {   
        // $posts = Post::all();
        
        //Eagerローディング 
        $posts = Post::with('user')->get();
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
        if(isset($request->imgpath)){
            $file_name=$request->imgpath->getClientOriginalName();
            $form['imgpath']= $request->imgpath->storeAs('',$file_name,'public');
        }
    
        // fileメソッド使っても使わなくても一緒？
        // $file_name = $request->file('imgpath')->getClientOriginalName();
        // $img = $request->file('imgpath')->storeAs('',$file_name,''public);
        // $form['imgpath'] = $img;

        unset($form['_token']);
        $post->create($form);
        return redirect('/');
    }

    //質問詳細ページへ
    public function show_qr(Request $request, Answer $answer)
    {
        $post_id = $request->id;
        $questions = Post::find($post_id);
        $answers = Answer::where('post_id', $post_id)->get();
        

        $user_id = Auth::id();
        // flagに1が入っている場合はtrueを返す。
        $bestanswer_flag = Answer::where('post_id', $post_id)->where('bestanswer_flag', 1)->first();
        if($bestanswer_flag === null){
             $bestanswer_flag = false;
        }else{
             $bestanswer_flag = true;
        }
        return view('qr_info',['questions' => $questions,'answers' => $answers, 'bestanswer_flag' => $bestanswer_flag, 'user_id' => $user_id ]);

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

    // ユーザー詳細画面へ
    public function show_user(Request $request,Post $post, Answer $answer, User $user)
    {
        $user_id = $request->id;
        $questions = $post->getUserQuestions($user_id);
        $questions_count = $post->getQuestionCount($user_id);
        $answers = $answer->getUserAnswers($user_id);
        $answers_count = $answer->getAnswersCount($user_id);
        $user = User::find($user_id);
        return view('user_show',['questions' => $questions,'questions_count' => $questions_count, 'answers' => $answers, 'answers_count' => $answers_count, 'user' => $user]);
    }


    public function show_boardgame(Request $request)
    {
        $bd_id = $request->id;
        $boardgame = Boardgame::find($bd_id);
        return view('bg_show',['boardgame' => $boardgame]);
    }

    // ベストアンサーをつける
    public function store_bestanswer(Request $request , Answer $answer)
    {
        $answer_id = $request->answer_id;
        $answer = Answer::find($answer_id);
        $answer->bestanswer_flag = 1;
        $answer->save();
        return back();
    }
}

