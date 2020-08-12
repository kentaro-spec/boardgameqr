@extends('layouts.app')

@section('content')
<div class="container-fluid">
   <div class="">
       <div class="mx-auto" style="max-width:1200px">
           <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">ユーザー詳細画面</h1>

           <h2>アカウント名</h2>
           {{ $user->screen_name }}
           {{-- <img src="{{ asset ('storage/prodile_image/'.$user->profile_image) }}" alt=""> --}}
           <img src="{{ $user->profile_image }}" class="rounded-circle">

           @auth
           @if( $user->id === Auth::user()->id )
           {{-- {{ Auth::user()->id }} --}}
            <a href="{{ url('users/'.$user->id.'/edit')}}" class="btn btn-primary">プロフィールを編集する</a>
           @endif
           @endauth

           <div class="">
                   <h2>質問一覧</h2>
                   @foreach($questions as $question)
                   <p>{{ $question->text }}</p> <br>
                   @endforeach
                   <h2>質問数</h2>
                   <p>{{ $questions_count }}</p>
           </div>

           <div class="">
                   <h2>回答一覧</h2>
                   @foreach($answers as $answer)
                   <p>{{ $answer->text }}</p> <br>
                   @endforeach
                   <h2>回答数</h2>
                   <p>{{ $answers_count }}</p>
           </div>
       </div>
   </div>
</div>
@endsection