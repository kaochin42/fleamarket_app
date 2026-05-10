@extends('layouts.auth')

@section('content')
<h1>会員登録</h1>
<form method="post" action="{{ route('register') }}">
    @csrf

    <div>
        <label>ユーザー名</label>
        <input type="text" name="name">
    </div>

    <div>
        <label>メールアドレス</label>
        <input type="email" name="email">
    </div>

    <div>
        <label>パスワード</label>
        <input type="password" name="password">
    </div>

    <div>
        <label>確認用パスワード</label>
        <input type="password" name="password_confirmation">
    </div>

    <button type="submit">登録</button>
</form>
@endsection