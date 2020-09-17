@extends('layouts.app')

@section('content')

{{-- メインビジュアル始め --}}
@guest
<div class="mv_cover">
    {{-- <img src="{{ asset('img/boardgameqr_mv.jpg')}}" class="w-100" alt=""> --}}
    <div class="mv_cover_filter">
        <div class="mv_inner">
            <div class="inner_left">
                <div class="mb-5">
                    <h1 class="logo"><span>ボードゲームルールQ&Aサイト</span>BoardgameQR</h1>
                </div>
                <div class="inner_body">
                    <h3 class="inner_body_maintxt">「このゲームのここがわからない」を解決する</h3>
                    <p>BoardgameQRは、ボードゲームのルールでわからないところを解決するQ＆Aサイトです。</p>
                </div>
            </div>
            <div class="inner_right">
                <div>
                <button class="btn btn-primary mv_mailbtn"><a href="{{ route('register')}}">メールアドレスで登録する</a></button>
                    <p class="inner_right_or">OR</p>
                </div>
                <p class="mv_snsregist">SNSアカウントで登録する</p>
            </div>
        </div>
    </div>
</div>
@endguest
{{-- メインビジュアルおしまい --}}

<div class="container main_content">
    <div class="mx-auto" style="max-width:960px">
        {{-- タブ始め --}}
        <ul class="tab_list flex w-75">
            @if($tab === "new")
                <li class="tab_new active"><a href="new">新着</a></li>
            @else
                <li class="tab_new"><a href="new">新着</a></li>
            @endif
            @if($tab === "solved")
                <li class="tab_solved active"><a href="solved">解決済</a></li>
            @else
                <li class="tab_solved"><a href="solved">解決済</a></li>
            @endif

            @if($tab === "unsolved")
                <li class="tab_unsolved active"><a href="unsolved">未解決</a></li>
            @else
                <li class="tab_unsolved"><a href="unsolved">未解決</a></li>
            @endif
        </ul>
        {{-- タブ終わり --}}

        {{-- コンテンツ始め --}}
        <div class="row">
            <div class="col-sm-9">
                <ul>
                    @foreach($posts as $post)
                            <li  class="question_list d-flex py-3">
                                <div class="question_list_head">
                                    @php
                                    global $flag;
                                    $flag = false;
                                    @endphp
                                    @foreach ( ($post->answers) as $answer)
                                        @if($answer->bestanswer_flag === 1)
                                            @php
                                                $flag =  true;
                                                break;
                                            @endphp
                                        @else
                                            @php
                                            $flag = false;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if($flag === true)
                                        <ul class="answer_count2">
                                            <li class="accept2  p-1 mb-1 text-white">解決済</li>
                                            <li class="answer2">回答</li>
                                            <li>{{ $posts->find($post->id)->answers->count()}}</li>
                                        </ul>
                                    @else
                                        <ul class="answer_count">
                                            <li class="accept  p-1 mb-1">受付中</li>
                                            <li class="answer">回答</li>
                                            <li>{{ $posts->find($post->id)->answers->count()}}</li>
                                        </ul>
                                    @endif
                                </div>
                                {{-- 回答受付マーク終わり --}}
                                <div class= "question_list_body pl-4 w-75">
                                    <a href="{{ Route('show',['id' => $post->id]) }}" class="">
                                        <h4 class="font-weight-bold">{{$post->title}}</h4>
                                    </a>
                                    <a href="{{ Route('boardgame',['id' => $post->boardgame_id]) }}" class="boardgame_tag">
                                        {{ $post->boardgame->name }}
                                    </a>
                                    <div class="d-flex justify-content-end user_content">
                                        <p><img src="{{ $post->user->profile_image }}" alt=""></p>
                                        <p class="mr-3">{{ $post->user->screen_name}}</p>
                                        <p>{{ $post->created_at->format('Y-m-d H:i') }}</p>
                                    </div>
                                </div>
                            </li>
                    @endforeach
                </ul>
            </div>
                
            {{-- サイドバー --}}
            <div class="col-sm-3">
                <div class="mb-5">
                    <p class="category_title">ボードゲームタグ</p>
                    @foreach ($boardgames as $boardgame)
                    <div class="boardgame_tag_wrap py-2 flex is-between">
                        <div>
                            <a href="{{ Route('boardgame',['id' => $boardgame->id]) }}" class="boardgame_tag">
                            {{ $boardgame->name }} </a>
                        </div>
                        <p>
                            <span class="boradgame_tag_post">{{ $boardgame->posts->count() }}</span> <span class="boradgame_tag_post">投稿</span>
                        </p>
                    </div>
                    @endforeach
                </div>

                <div class="user_ranking ">
                    <p class="category_title">ユーザーランキング</p>  
                    @foreach($users as $key => $user)
                        <div class="ranking_wrap py-2">
                            <div class="flex">
                                @if( $key === 0)
                                <p class="ranking_first">{{ $key + 1}}</p>
                                @elseif( $key === 1)
                                <p class="ranking_second">{{ $key + 1}}</p>
                                @elseif( $key === 2)
                                <p class="ranking_third">{{ $key + 1}}</p>
                                @endif
                                <img src=" {{ $user->profile_image }} " alt="" class="mr-2"></>
                                <div class="ranking_body">
                                    <a href="{{ Route('show_user',['id' => $user->id]) }}">{{ $user->screen_name}}</a>
                                    <p>score::{{ $user->ranking_point }}pt</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
<p class="center">{{$posts->links()}}</p>
@endsection