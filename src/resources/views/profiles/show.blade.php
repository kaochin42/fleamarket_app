@extends('layouts.app')
@section('content')

{{-- プロフィール情報 --}}
<div>
    <img src="{{ asset('storage/' . $user->profile_img) }}" alt="プロフィール画像">
    <p>{{ $user->name }}</p>
    <a href="{{ route('profile.edit') }}">プロフィールを編集</a>
</div>

{{-- タブ --}}
<div>
    <a href="{{ route('mypage.show') }}?page=sell">出品した商品</a>
    <a href="{{ route('mypage.show') }}?page=buy">購入した商品</a>
</div>

{{-- 商品一覧 --}}
@if(request('page') == 'buy')
@foreach($buyItems as $item)
<div>
    <img src="{{ $item->image_path }}" alt="{{ $item->name }}">
    <p>{{ $item->name }}</p>
</div>
@endforeach
@else
@foreach($sellItems as $item)
<div>
    <img src="{{ $item->image_path }}" alt="{{ $item->name }}">
    <p>{{ $item->name }}</p>
</div>
@endforeach
@endif

@endsection