@extends('layouts.auth')

@section('content')
<h2>ログイン</h2>
<form method="post" action="{{ route('login') }}">
    @csrf

    <div>
        <label>メールアドレス</label>
        <input type="email" name="email">
    </div>

    <div>
        <label>パスワード</label>
        <input type="password" name="password">
    </div>

    <button type="submit">ログインする</button>
    
    <a href="{{ route('register') }}">会員登録はこちら</a>
</form>
@endsection