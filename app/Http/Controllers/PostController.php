<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Answer;
use App\Models\User;
use App\Models\Boardgame;
use Carbon\Carbon;

class PostController extends Controller
{
    //一覧ページ
    public function index($tab = 'new')
    {    
        
        // ユーザランキングのデータ 人数増えたら5人まで
        $users = User::orderBy('ranking_point','desc')->limit(3)->get();
        // ボードゲームタグのデータ こっちも質問が多いゲーム5人くらい
        $boardgames = Boardgame::with(['posts'])->orderBy('post_count','desc')->limit(5)->get();
        // dd($boardgames);
        //Eagerローディング
        $posts = Post::with(['user','boardgame','answers'])->question($tab)->orderBy('posts.created_at','desc')->paginate(6);
        // dd($posts);

        $times = [];

        foreach($posts as $post){
            Carbon::setLocale('ja');
            $carbon = Carbon::parse($post->created_at);
            $now = Carbon::now();
            $time = $carbon->diffForHumans($now);
            $times[] =  $time;
        };
        // dd($times);

        return view('post',compact('posts' , 'users' , 'boardgames','tab', 'times'));
    }
    //質問ページ
    public function qr()
    {
        // ボードゲームテーブルから全ボードゲームを引っ張ってくる(質問したいボードゲームの名前で使う)
        $boardgames = Boardgame::all();
        return view('qr',[ 'boardgames' => $boardgames]);
    }
    //質問内容をDBに挿入する
    public function insert_qr(Request $request, Post $post)
    {   
        // imgpath以外をとってくる
        $form = $request->only('title','text','interpretation','user_id','boardgame_id');
        // dd($form);
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
        // boardgameテーブルのpost_countにプラス1をする。
        $bg_id = $request->boardgame_id;
        $boardgame = Boardgame::find($bg_id);
        $boardgame->increment('post_count');
        return redirect('/');
    }

    //質問詳細ページへ
    public function show_qr(Request $request, Answer $answer)
    {
        $post_id = $request->id;
        $questions = Post::with(['boardgame'])->find($post_id);
        // dd($questions);
        $answers = Answer::with(['user'])->where('post_id', $post_id)->get();
        

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
        // 質問一覧をとってくる
        $posts = $post->getUserQuestions($user_id);
        $questions_count = $post->getQuestionCount($user_id);
        // 自分が回答した質問をとってくる
        $answers = $answer->getUserAnswers($user_id);
        // dd($answers);
        $answers_count = $answer->getAnswersCount($user_id);
        $user = User::find($user_id);
        return view('user_show',['posts' => $posts,'questions_count' => $questions_count, 'answers' => $answers, 'answers_count' => $answers_count, 'user' => $user]);
    }

    // ボードゲームカテゴリページへ
    public function show_boardgame(Request $request , Post $post)
    {
        $bd_id = $request->id;
        $boardgame = Boardgame::find($bd_id);
        $posts = Post::with(['boardgame','user'])->where('boardgame_id', $bd_id)->get();
        // dd($posts);
        return view('bg_show',['boardgame' => $boardgame, 'posts' => $posts]);
    }

    // ベストアンサーをつける
    public function store_bestanswer(Request $request , Answer $answer)
    {
        $answer_id = $request->answer_id;
        $answer = Answer::find($answer_id);
        $answer->bestanswer_flag = 1;
        $answer->save();

        // 質問者のランキングポイントにプラス1をする
        $user_id = $request->user_id;
        $user =  User::find($user_id)->first();
        $user->ranking_point += 1;
        $user->save();
        return back();
    }

    // 検索機能
    public function search_bgname(Request $request)
    {
        $bg_name = $request->bg_name;
        if( $bg_name !=''){
            $posts = Post::whereHas('boardgame', function($value) use ($bg_name){
                $value->where('name','like','%'.$bg_name.'%');})->get();
        }
        else{
            return back();
        }
        // dd($posts);
        return view('search',['posts' => $posts,'bg_name' => $bg_name]);
    }
    //新しくボードゲームを追加するページへ飛ばす。
    public function create_boardgame()
    {
        return view('create_bgname');
    }
    //新しくボードゲームをDBに追加する
    public function add_boardgame(Request $request ,Boardgame $boardgames)
    {
        $validate_rule = [
            'name' => 'unique:boardgames,name'
        ];
        $this->validate($request, $validate_rule);

        $bgname = $request->only(['name']);
        unset($bgname[('_token')]);

        $boardgames->create($bgname);
        return redirect('qr');
    }
}

