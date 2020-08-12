@extends('layouts.app')

@section('content')
<div class="container-fluid">
   <div class="">
       <div class="mx-auto" style="max-width:1200px">
           <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">詳細ページ</h1>

           <div class="mb-5">
               <h1>質問</h1>
               <p>投稿日時:{{ $questions->created_at->format('Y-m-d H:i') }}</p>
               <p>
                   質問者:
                   <a href="{{ Route('show_user',['id' => $questions->user_id]) }}">{{ $questions->user->screen_name}}</a>
               </p>
               <p> {{ $questions->user->name }}</p>
    
               <div class="">
                   
                       <h2 style="font-size:1.1em; font-weight:bold; color:#555555;">該当のボードゲーム</h2>
                       <p>{{$questions->boardgamename}}</p>
                       <h2 style="font-size:1.1em; font-weight:bold; color:#555555;">発生している問題・質問</h2>
                       <div>{{$questions->text}}</div>

                       @if(isset($questions->imgpath) )
                       <h2 style="font-size:1.1em; font-weight:bold; color:#555555;">画像などあれば</h2>
                       {{-- <img src="/image/{{$questions->imgpath}}" alt=""> --}}
                       <img src=" {{ asset('storage/'.$questions->imgpath)}}">
                       @endif

                       @if(isset($questions->interpretation))
                       <h2 style="font-size:1.1em; font-weight:bold; color:#555555;">個人の解釈</h2>
                       <div>{{$questions->interpretation}}</div>
                       @endif
               </div>
           </div>

           <div class="mb-5">
               <h1>回答：{{count($answers)}}</h1>
               @foreach($answers as $answer)
                <p>
                   {{$answer->text}}
                </p>
               {{-- ベストアンサー --}}
               {{-- $bestanserにtrueが入っている場合は、ベストアンサーだけ表示、falseが入っている場合は、どれをベストアンサーにするか選択できるように表示 --}}
               
                    @if( $bestanswer_flag === true)
                            @if($answer->bestanswer_flag === 1)
                            <button type="submit" class="btn p-0 border-0 text-danger" ><i class="material-icons">favorite</i></button>
                            @endif 
                    @else
                        @if( $user_id === $questions->user_id )
                            <form action=" {{ Route('bestanswer') }}">
                                @csrf
                                <input type="hidden" name="answer_id" value= {{ $answer->id }}>
                                <button type="submit" class="btn p-0 border-0 text-primary" ><i class="material-icons">favorite_border</i></button>
                            </form>
                        @endif
                    @endif

               @endforeach
           </div>

           @if(Auth::check())
           <h1>この質問に回答する
           </h1>
            <form action="{{Route('show',['id' => $questions->id])}}" method="post">
               @csrf
               <textarea name="text" id="" cols="30" rows="10"></textarea>
                <input type="hidden" name="post_id" value="{{$questions->id}}">
                <input type="hidden" name="user_id" value= "1">
               <input type="submit" value="回答する">
               
            </form>
            @else
            <p>質問・回答するにはログインしてください</p>
            <a href="/login">ログイン</a>|<a href="/register">新規登録</a>
            @endif
       </div>
   </div>
</div>
@endsection