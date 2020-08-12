@extends('layouts.app')

@section('content')
@guest
<div class="mv_cover mb-4">
    {{-- <img src="{{ asset('img/boardgameqr_mv.jpg')}}" class="w-100" alt=""> --}}
    <div class="mv_cover_filter">
        <div class="mv_inner text-white d-flex justify-content-between">
            <div class="inner_left mr-4">
                <div class="mb-5">
                    <h1 class="logo"><span>ボードゲームルールQ&Aサイト</span>BoardgameQR</h1>
                </div>
                <div class="inner_body">
                    <h3>「このゲームのここがわからない」を解決する</h3>
                    <p>BoardgameQRは、ボードゲームのルールでわからないところを解決するQ＆Aサイトです。</p>
                </div>
            </div>
            <div class="inner_right">
                <div>
                    <button class="btn btn-primary"><a href="" class="text-white">メールアドレスで登録する</a></button>
                    <p class="text-center">OR</p>
                </div>
                <div>
                    <p>SNSアカウントで登録する</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endguest
<div class="container-fluid">
       <div class="">
            <h1 class="text-center" style="color:#555555;font-size:1.2em; padding:24px 0px; font-weight:bold;">質問一覧</h1>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-9">
                            @foreach($posts as $post)
                                     <div class="card mx-auto w-75 mb-3">
                                         <div class="card-body">
                                         <a href="{{ Route('boardgame',['id' => 1]) }}">
                                             このゲームがまとめられている質問へ
                                             </a>
                                             <h4 class="card-title">{{$post->boardgamename}}</h4>
                                             <div class="card-text text-primary font-weight-bold">{{$post->text}}</div>
                                             <img src="/image/{{$post->imgpath}}" alt="">
                                             <div class="d-flex justify-content-end">
                                                 <p class="mr-3">{{ $post->user->screen_name}}</p>
                                                 <p>{{ $post->created_at->format('Y-m-d H:i') }}</p>
                                             </div>
                                             <a href="{{ Route('show',['id' => $post->id]) }}" class="btn btn-primary">
                                             詳細へ</a>
                                         </div>
                                     </div>
                                 {{-- </a> --}}
                                 @endforeach
                    </div>
                    <div class="col-sm-3">
                         <div class="card">
                             <div class="card-body">
                                 <h4 class="card-title">
                                     ユーザーランキング
                                 </h4>
                             </div>
                         </div>
                         <div class="card">
                             <div class="card-body">
                                 <h4 class="card-title">
                                     ボードゲームタグ
                                 </h4>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection