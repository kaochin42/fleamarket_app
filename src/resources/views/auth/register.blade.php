@extends('layouts.auth')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush
@section('content')
<div class="register-inner">
    <h2 class="title">会員登録</h2>

    <form method="post" action="{{ route('register') }}" novalidate>
        @csrf

        <div class="form-group">
            <label class="label">ユーザー名</label>
            <input class="input" type="text" name="name">
            @if($errors->has('name'))
            <p class="error">{{ $errors->first('name') }}</p>
            @endif
        </div>

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

        <div class="form-group">
            <label class="label">確認用パスワード</label>
            <input class="input" type="password" name="password_confirmation">
            @if($errors->has('password_confirmation'))
            <p class="error">{{ $errors->first('password_confirmation') }}</p>
            @endif
        </div>

        <button class="action-bar" type="submit">登録</button>
        <a class="auth-link" href="{{ route('login') }}">ログインはこちら</a>
    </form>
</div>
@endsection