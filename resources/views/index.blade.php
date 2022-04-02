@extends('helloapp')

@section('title','Index')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')
    @if (Auth::check())
    <p>USER: {{$user->name . ' (' . $user->email . ')'}}</p>
    @else
    <p>※ログインしていません。(<a href="/login">ログイン</a>
    <a href="/register">登録</a>)</p>
    @endif
@endsection

@section('footer')
copyright 2020 tuyano.
@endsection