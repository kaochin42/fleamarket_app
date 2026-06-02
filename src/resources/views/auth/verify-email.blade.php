@extends('layouts.auth')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush
@section('content')
<div class="verify-email-inner">
    <div class="email-text">
        <p>登録していただいたメールアドレスに認証メールを送付しました。</p>
        <p>メール認証を完了してください。</p>

        @if(session('status') == 'verification-link-sent')
        <p>認証メールを再送信しました。</p>
        @endif
    </div>

    <a class="action-bar email-action-bar" href="http://localhost:8025" target="_blank">認証はこちらから</a>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="auth-link" type="submit">認証メールを再送する</button>
    </form>
</div>
@endsection