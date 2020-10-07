@extends('layouts.app')

@section('content')
    <div class="qr_info_mv">
        <h2>説明書でもわからないところは、質問してみよう！</h2>
    </div>
<div class="questionWrap">
    <div class="container">
        <div class="question_inner">
            <div class="question">{{$questions->title}}</div>
            <div class="question_body flex is-between">
                <div class="question_left">
                    <div class="flex center">
                        @if($bestanswer_flag === true)
                        <p class="qr_info_answer_tag">解決済</p>
                        @else
                        <p class="qr_info_accept_tag">受付中</p>
                        @endif
                        <p class="question_left_answer">回答<span>{{count($answers)}}</span></p>
                        <p class="question_left_time">投稿{{ $questions->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                    <p class="question_left_bgname">該当のボードゲーム <a class="boardgame_tag" href="{{route('boardgame',['id' => $questions->boardgame_id])}}">{{$questions->boardgame->name}}</a> </p>
                </div>
                <div class="question_right">
                    <p><img src="{{$questions->user->profile_image}}" alt=""><a href="{{ Route('show_user',['id' => $questions->user_id]) }}">{{ $questions->user->screen_name}}</a></p>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-8">
            <ul class="questions_ul_wrap">
                <li>
                    <h2 class="qr_info_heading">質問</h2>
                    <p>{{$questions->text}}</p>
                </li>
                <li>
                    @if(isset($questions->interpretation))
                    <h2 class="qr_info_heading">個人の解釈</h2>
                    <div>{{$questions->interpretation}}</div>
                    @endif
                </li>
                <li>
                    @if(isset($questions->imgpath) )
                    <h2 class="qr_info_heading">画像など</h2>
                    {{-- <img src="/image/{{$questions->imgpath}}" alt=""> --}}
                    <img src=" {{ asset('storage/'.$questions->imgpath)}}">
                    @endif
                </li>
            </ul>

            <div class="answerWrap">
        @if(count($answers) === 0)
        <p class="not_answer">回答がまだついていません</p>
        @else
                <p class="qr_info_answer">回答<span>{{count($answers)}}</span>件</p>
            @foreach($answers as $answer)
                {{-- ベストアンサー --}}
                {{-- $bestanserにtrueが入っている場合は、ベストアンサーだけ表示、falseが入っている場合は、どれをベストアンサーにするか選択できるように表示 --}}
            @if( $bestanswer_flag === true)
                @if($answer->bestanswer_flag === 1)
                <div class="bestanswer_check flex">
                    <i class="text-danger material-icons">done</i>
                    <p>ベストアンサー</p>
                </div>
                @endif
                @else
                @if( $user_id === $questions->user_id )
                    <form action=" {{ Route('bestanswer') }}">
                        @csrf
                        <input type="hidden" name="user_id" value={{ $questions->user_id }}>
                        <input type="hidden" name="answer_id" value= {{ $answer->id }}>
                        <button type="submit" class="btn p-0 border-0 text-secondary" ><i class="material-icons">done</i>この回答をベストアンサーにする</button>
                    </form>
                @endif
            @endif
            <div class="answer_text">
                <p class="mb-3">{{$answer->text}}</p>
                <div class="d-flex justify-content-end">
                    <p>投稿{{ $answer->created_at }}</p>
                 <p><img src="{{ $answer->user->profile_image }}" alt=""></p> 
                   <p><a href="">{{ $answer->user->screen_name }}</a></p>
                </div>
            </div>
            @endforeach
        @endif
                {{-- 質問者は回答できないようにする --}}
            @if(Auth::check())
                @if(Auth::id() !== $questions->user_id)
                <div class="flex post_answer_wrap">
                    <div><img src="{{Auth::user()->profile_image}}" alt=""></div>
                    <div>
                        <p>この質問に回答する</p>
                        <form action="{{Route('show',['id' => $questions->id])}}" method="post">
                            @csrf
                            <textarea name="text" id="" cols="30" rows="10"></textarea>
                            <input type="hidden" name="post_id" value="{{$questions->id}}">
                            <input type="hidden" name="user_id" value= "{{ Auth::id()}}">
                            <div class="question_btn"><input type="submit" value="回答する" required></div>
                        </form>
                    </div>
                </div>
                @endif
            @else
                <div class="mt-5">
                    <p>質問・回答するにはログインしてください</p>
                    <a href="/login">ログイン</a>|<a href="/register">新規登録</a>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>

@endsection