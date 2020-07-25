@extends('layouts.app')

@section('content')
<div class="container-fluid">
   <div class="">
       <div class="mx-auto" style="max-width:1200px">
           <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">質問投稿画面</h1>
           
           <div class="">
               <div class="d-flex flex-row flex-wrap">
                   
                <form action="/" method="post">
                    @csrf
                    <h4>質問したいボードゲームの名前</h4>
                    <input type="text" name="boardgamename">

                    <h4>質問内容を記入する</h4> <textarea name="text" id="" cols="30" rows="10"></textarea>
                    
                    <h4>問題の箇所（該当の説明書の写真)</h4>
                    <input type="file" name="imgpath">
                    <input type="submit" value="質問する">
                </form>

               </div>
           </div>
       </div>
   </div>
</div>
@endsection