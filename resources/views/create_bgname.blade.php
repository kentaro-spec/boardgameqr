@extends('layouts.app')

@section('content')
    <form action="{{route('add_newbg')}}" method="post">
        @csrf
        <input type="text" name="name">
        <input type="submit" value="新しくゲームを追加する">
    </form>
    @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
@endsection