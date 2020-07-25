@extends('layouts.app')

@section('content')
<div class="container-fluid">
   <div class="">
       <div class="mx-auto" style="max-width:1200px">
           <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">質問一覧</h1>
           <a class="btn btn-primary mb-3" href="{{ Route('qr')}}" role = "button">質問する</a>
           <div class="">
               <div class="d-flex flex-row flex-wrap">
                   @foreach($posts as $post)
                        <a href="{{ Route('show',['id' => $post->id]) }}" class="card mb-3" style="max-width: 18rem;">
                            <div class="card-body">
                                <h4 class="card-title">{{$post->boardgamename}}</h4>
                                <div class="card-text">{{$post->text}}</div>
                                <img src="/image/{{$post->imgpath}}" alt="">
                                <p>{{ $post->created_at->format('Y-m-d H:i') }}</p> 
                            </div>
                        </a>
                   @endforeach
               </div>
           </div>
       </div>
   </div>
</div>
@endsection