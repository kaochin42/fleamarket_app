@extends('layouts.app')
@section('content')

<h2>プロフィール設定</h2>

<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf

    {{-- プロフィール画像 --}}
    <div>
        <img src="{{ asset('storage/' . $user->profile_img) }}" alt="プロフィール画像">
        <input type="file" name="profile_img">
    </div>

    {{-- ユーザー名 --}}
    <div>
        <label>ユーザー名</label>
        <input type="text" name="name" value="{{ $user->name }}">
    </div>

    {{-- 郵便番号 --}}
    <div>
        <label>郵便番号</label>
        <input type="text" name="postcode" value="{{ $user->postcode }}">
    </div>

    {{-- 住所 --}}
    <div>
        <label>住所</label>
        <input type="text" name="address" value="{{ $user->address }}">
    </div>

    {{-- 建物名 --}}
    <div>
        <label>建物名</label>
        <input type="text" name="building" value="{{ $user->building }}">
    </div>

    <button type="submit">更新する</button>
</form>

@endsection