@extends('layouts.app')

@section('content')
<div class="container">
    <div class="qr_inner">
        <h2>質問の投稿</h2>  
        <form action="/" enctype="multipart/form-data" method="post">
            @csrf
            <ul  class="question_form">
                <li class="question_bgname">
                        <p>質問したいボードゲーム名<span>必須</span></p>
                        <select name="boardgame_id" required>
                                <option value="">ボードゲームを選択する</option>
                            @foreach ($boardgames as $boardgame)
                                <option value="{{ $boardgame->id }}">{{ $boardgame->name }}</option>
                            @endforeach
                            {{-- <input type="hidden" name="boardgame_id" value="{{ $boardgame->id}}"> --}}
                        </select>
                        <p>質問したいボードゲームがなかった場合は<a href="{{ Route("post_newbg")}}">こちら</a>から追加してください</p>
                </li>
                
                <li class="question_title">
                    <p>タイトル<span>必須</span></p>
                    <p>50文字以内で書いてください</p>
                    <input type="text" name="title" required>
                </li>
                <li>
                    <p>質問内容<span>必須</span></p> <textarea name="text" id="" cols="30" rows="10" required></textarea>
                </li>
                <li>
                    <p>問題の箇所の写真等</p>
                    <input type="file" name="imgpath">
                </li>
                <li>
                    <p>個人の解釈</p>
                    <textarea name="interpretation" id="" cols="30" rows="10"></textarea>
                    <input type="hidden" name="user_id" value="{{ Auth::id()}}">
                </li>
            </ul>
            @guest
                <div class="register_btn">
                    <div><a href="{{ route('register') }}">新規会員登録</a>・<a href="{{ route('login')}}">ログイン</a>して質問する。</div>
                    <p>新規会員登録・ログイン後に質問することができます。</p>
                </div>
            @endguest
            @auth
                <div class="question_btn"><input type="submit" value="質問する"></div>
            @endauth
        </form>
    </div>
</div>
@endsection