@extends('layouts.app')
@section('content')
<div class="auth-inner">
    <h2 class="title">メール認証</h2>

    <p>登録したメールアドレスに認証メールを送信しました。メール内のリンクをクリックして認証を完了してください。</p>

    @if(session('status') == 'verification-link-sent')
    <p>認証メールを再送信しました。</p>
    @endif

    <a class="action-bar" href="http://localhost:8025" target="_blank">認証はこちらから</a>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="action-bar-outline" type="submit">認証メールを再送する</button>
    </form>
</div>
@endsection