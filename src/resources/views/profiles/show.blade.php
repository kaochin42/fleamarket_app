@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush
@section('content')

{{-- プロフィール情報 --}}
<div class="user-info">
    <img class="profile-img" src="{{ asset('storage/' . $user->profile_img) }}" alt="プロフィール画像">
    <p class="profile-name">{{ $user->name }}</p>
    <a class="action-bar-outline" href="{{ route('profile.edit') }}">プロフィールを編集</a>
</div>

{{-- タブ --}}
<div class="tab-outer">
    <div class="tab-area">
        <a class="tab-link {{ request('page') !== 'buy' ? 'tab-active' : '' }}" href="{{ route('mypage.show') }}?page=sell">出品した商品</a>
        <a class="tab-link {{ request('page') === 'buy' ? 'tab-active' : '' }}" href="{{ route('mypage.show') }}?page=buy">購入した商品</a>
    </div>
</div>

{{-- 商品一覧 --}}
<div class="products-row">
    @if(request('page') == 'buy')
    @foreach($buyItems as $item)
    <a class="product-card" href="{{ route('item.show', ['item_id' => $item->id]) }}">
        <div class="product-img-wrap">
            <img class="product-img" src="{{ Str::startsWith($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
        </div>
        <p class="product-name">{{ $item->name }}</p>
    </a>
    @endforeach
    @else
    @foreach($sellItems as $item)
    <a class="product-card" href="{{ route('item.show', ['item_id' => $item->id]) }}">
        <div class="product-img-wrap">
            <img class="product-img" src="{{ Str::startsWith($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
        </div>
        <p class="product-name">{{ $item->name }}</p>
    </a>
    @endforeach
    @endif
</div>

@endsection