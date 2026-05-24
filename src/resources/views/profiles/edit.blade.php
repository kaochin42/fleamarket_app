@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush
@section('content')

<div class="inner">
    <h2 class="title">プロフィール設定</h2>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        {{-- プロフィール画像 --}}
        <div class="profile-img-wrap">
            <img class="profile-img" src="{{ asset('storage/' . $user->profile_img) }}" alt="プロフィール画像">
            <label class="action-bar-outline" for="profile_img">画像を選択する</label>
            <input type="file" name="profile_img" id="profile_img" style="display: none;">
            @if($errors->has('profile_img'))
            <p class="error">{{ $errors->first('profile_img') }}</p>
            @endif
        </div>

        {{-- ユーザー名 --}}
        <div class="form-group form-group-name">
            <label class="label">ユーザー名</label>
            <input class="input" type="text" name="name" value="{{ $user->name }}">
            @if($errors->has('name'))
            <p class="error">{{ $errors->first('name') }}</p>
            @endif
        </div>

        {{-- 郵便番号 --}}
        <div class="form-group">
            <label class="label">郵便番号</label>
            <input class="input" type="text" name="postcode" value="{{ $user->postcode }}">
            @if($errors->has('postcode'))
            <p class="error">{{ $errors->first('postcode') }}</p>
            @endif
        </div>

        {{-- 住所 --}}
        <div class="form-group">
            <label class="label">住所</label>
            <input class="input" type="text" name="address" value="{{ $user->address }}">
            @if($errors->has('address'))
            <p class="error">{{ $errors->first('address') }}</p>
            @endif
        </div>

        {{-- 建物名 --}}
        <div class="form-group">
            <label class="label">建物名</label>
            <input class="input" type="text" name="building" value="{{ $user->building }}">
        </div>

        <button class="action-bar" type="submit">更新する</button>
    </form>
</div>

@endsection