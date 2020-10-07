@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="bg_show_wrap">
        {{-- ボードゲームのタイトル始め --}}
        <h1 class="bg_show_title">
            {{ $boardgame->name }}
        </h1>
        {{-- ボードゲームのタイトル終わり --}}
    </div>
    <div class="row">
        <div class="col-sm-8">
            {{-- {{ dd($post) }} --}}
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
                            <div class= "question_list_body pl-4 w-75">
                                {{-- <a href="{{ Route('boardgame',['id' => $post->boardgame_id]) }}">
                                    <h4 class="">{{ $post->boardgame->name }}</h4>
                                </a> --}}
                                <a href="{{ Route('show',['id' => $post->id]) }}" class="">
                                    <h4 class="font-weight-bold">{{$post->title}}</h4>
                                </a>
                                <div class="d-flex justify-content-end">
                                    <a class = 'mr-3 text-dark' href="{{ Route('show_user',['id' => $post->user->id]) }}">{{ $post->user->screen_name}}</a>
                                    <p>{{ $post->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                        </li>
                @endforeach
            </ul>
        </div>
</div>
@endsection
