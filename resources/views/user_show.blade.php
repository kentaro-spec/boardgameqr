@extends('layouts.app')

@section('content')
<div class="container mt-5">
            {{-- assetって何？ --}}
           {{-- <img src="{{ asset ('storage/prodile_image/'.$user->profile_image) }}" alt=""> --}}
           {{-- プロフィールページヘッダー始め --}}
           <div class="mypageHead flex">
                <div class="profile_wrap">
                   <img src="{{ $user->profile_image }}" class="rounded-circle">
                   <p class="profile_wrap_name">{{ $user->screen_name }}</p>
                   <p>score:{{ $user->ranking_point}}</p>
                   @auth
                    @if( $user->id === Auth::user()->id )
                    {{-- {{ Auth::user()->id }} --}}
                        <a href="{{ url('users/'.$user->id.'/edit')}}">プロフィールを編集する</a>
                    @endif
                   @endauth
                </div>
               <nav class="user_boxSelectTab">
                   <ul class=" flex">
                       <li class="user_btnQuestion">
                            <p><span>質問</span></p>
                            <p class="user_btnNum">{{ $questions_count }}</p>
                       </li>
                       <li class="user_btnAnswer">
                            <p><span>回答</span></p>
                            <p class="user_btnNum">{{ $answers_count }}</p>
                       </li>
                   </ul>
               </nav>
            </div>
        {{-- プロフィールページヘッダー終わり --}}
</div>
        {{-- コンテンツ始め --}}
            <div class="mypageBody">
                <div class="container">
                    
                    <div class="row">
                        <div class="user_question_wrap col-sm-9">
                            <p class="user_question_wrap_question">質問</p>
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
                                                        <li>{{ $post->answers->count()}}</li>
                                                    </ul>
                                                @else
                                                    <ul class="answer_count">
                                                        <li class="accept  p-1 mb-1">受付中</li>
                                                        <li class="answer">回答</li>
                                                        <li>{{ $post->answers->count()}}</li>
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
                                                    <p class="mr-3 "><a href="{{ Route('show_user',['id' => $post->user->id])}}">{{ $post->user->screen_name}}</a></p>
                                                    <p>{{ $post->created_at->format('Y-m-d H:i') }}</p>
                                                </div>
                                            </div>
                                        </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


 

            <div class="mypageBody">
                <div class="container">
                    <p>回答</p>

                    @foreach($answers as $answer)
                    {{-- {{ dd($answer)}} --}}
                    <li  class="question_list d-flex py-3">
                        <div class="question_list_head">
                            @php
                            global $flag;
                            $flag = false;
                            @endphp
                            @foreach ( ($answer->post->answers) as $answer)
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
                                    <li>{{ $answer->post->answers->count()}}</li>
                                </ul>
                            @else
                                <ul class="answer_count">
                                    <li class="accept  p-1 mb-1">受付中</li>
                                    <li class="answer">回答</li>
                                    <li>{{ $answer->post->answers->count()}}</li>
                                </ul>
                            @endif
                        </div>
                        {{-- 回答受付マーク終わり --}}
                        <div class= "question_list_body pl-4 w-75">
                            <a href="{{ Route('show',['id' => $answer->post->id]) }}" class="">
                                <h4 class="font-weight-bold">{{$answer->post->title}}</h4>
                            </a>
                            <a href="{{ Route('boardgame',['id' => $answer->post->boardgame_id]) }}" class="boardgame_tag">
                                {{ $answer->post->boardgame->name }}
                            </a>
                            <div class="d-flex justify-content-end user_content">
                                <p><img src="{{ $answer->post->user->profile_image }}" alt=""></p>
                                <p class="mr-3 "><a href="{{ Route('show_user',['id' => $answer->post->user->id])}}">{{ $answer->post->user->screen_name}}</a></p>
                                <p>{{ $answer->post->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                    </li>



                    {{-- <div class= "question_list_body pl-4 w-75">
                        <a href="{{ Route('show',['id' => $answer->post->name]) }}">
                            <h4 class="font-weight-bold">{{$answer->post->title}}</h4>
                        </a>
                        <a href="{{ Route('boardgame',['id' => $answer->post->boardgame_id]) }}" class="boardgame_tag">
                            {{ $answer->post->boardgame->name }}
                        </a>
                        <div class="d-flex justify-content-end user_content">
                            <p><img src="{{ $answer->post->user->profile_image }}" alt=""></p>
                            <p class="mr-3">{{ $answer->post->user->screen_name}}</p>
                            <p>{{ $answer->post->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div> --}}
                    @endforeach
                </div>
            </div>
@endsection