@extends('layouts.auth')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush
@section('content')
<div class="login-inner">
    <h2 class="title">ログイン</h2>

    <form method="post" action="{{ route('login') }}" novalidate>
        @csrf

        <div class="form-group">
            <label class="label">メールアドレス</label>
            <input class="input" type="email" name="email">
            @if($errors->has('email'))
            <p class="error">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label class="label">パスワード</label>
            <input class="input" type="password" name="password">
            @if($errors->has('password'))
            <p class="error">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <button class="action-bar" type="submit">ログインする</button>

        <a class="auth-link" href="{{ route('register') }}">会員登録はこちら</a>
    </form>
</div>
@endsection