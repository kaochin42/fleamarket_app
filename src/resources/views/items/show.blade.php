@extends('layouts.app')

@section('content')
<div>
    {{-- 商品画像 --}}
    <img src="{{ $item->image_path }}" alt="{{ $item->name }}">
</div>

<div>
    {{-- 商品名 --}}
    <h2>●●●</h2>

    {{-- ブランド名 --}}
    <p>●●●</p>

    {{-- 価格 --}}
    <p>¥{{ ●●● }}</p>

    {{-- 購入ボタン --}}
    <a href="●●●">購入手続きへ</a>
</div>
@endsection