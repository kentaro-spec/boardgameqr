@extends('layouts.app')

@section('content')
<div class="container-fluid">
   <div class="">
       <div class="mx-auto" style="max-width:1200px">
           <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">詳細ページ</h1>

           <div class="mb-5">
               <h1>質問</h1>
               <p>投稿日時:{{ $questions->created_at->format('Y-m-d H:i') }}</p> 
    
               <div class="">
                   
                       <h2 style="font-size:1.1em; font-weight:bold; color:#555555;">該当のボードゲーム</h2>
                       <p>{{$questions->boardgamename}}</p>
                       <h2 style="font-size:1.1em; font-weight:bold; color:#555555;">発生している問題・質問</h2>
                       <div>{{$questions->text}}</div>
                       <h2 style="font-size:1.1em; font-weight:bold; color:#555555;">画像などあれば</h2>
                       {{-- <img src="/image/{{$questions->imgpath}}" alt=""> --}}
                       <img src=" {{ asset('storage/'.$questions->imgpath)}}">
                       <h2 style="font-size:1.1em; font-weight:bold; color:#555555;">個人の解釈</h2>
                       <div>{{$questions->interpretation}}</div>
               </div>
           </div>

           {{-- @if({{count($answers)}} < 1)
            
           @else     --}}
           <div class="mb-5"> 
               <h1>回答：{{count($answers)}}</h1>
               @foreach($answers as $answer)
               {{$answer->text}}
               @endforeach
           </div>

           <h1>この質問に回答する(ログインしてる奴だけに表示させたい)
           </h1>
        <form action="{{Route('show',['id' => $questions->id])}}" method="post">
               @csrf
               <textarea name="text" id="" cols="30" rows="10"></textarea>
                <input type="hidden" name="post_id" value="{{$questions->id}}">
                <input type="hidden" name="user_id" value= "1">
               <input type="submit" value="回答する">
        </form>
       </div>
   </div>
</div>
@endsection