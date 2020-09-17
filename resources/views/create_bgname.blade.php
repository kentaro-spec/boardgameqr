@extends('layouts.app')

@section('content')
    <form action="/qr" method="post">
        @csrf
        <input type="text" name="name">
        <input type="submit" value="新しくゲームを追加する">
    </form>
@endsection