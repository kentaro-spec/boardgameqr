@extends('layouts.app')

@section('content')
<div class="container mt-5">
       <div class="mx-auto" style="max-width:1200px">
           {{-- <img src="{{ asset ('storage/prodile_image/'.$user->profile_image) }}" alt=""> --}}
           
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
    
               <nav>
                   <ul class="user_boxSelectTab flex">
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
    </div>
</div>

            <div class="mypageBody">
                <div class="container">
                    <div class="">
                        <h2>質問一覧</h2>
                        @foreach($questions as $question)
                        <p>{{ $question->text }}</p> <br>
                        @endforeach
                    </div>
    
                    <div class="">
                            <h2>回答一覧</h2>
                            @foreach($answers as $answer)
                            <p>{{ $answer->text }}</p> <br>
                            @endforeach
                    </div>
                </div>
            </div>

@endsection