@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endpush

@section('content')
<div class="purchase-outer">

    {{-- 左カラム --}}
    <div class="purchase-left">

        {{-- 商品情報 --}}
        <div class="purchase-item">
            <img class="purchase-item-img" src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
            <div class="purchase-item-info">
                <p class="purchase-item-name">{{ $item->name }}</p>
                <p class="purchase-item-price">
                    <span class="purchase-price-yen">¥</span>
                    <span class="purchase-price-num">{{ number_format($item->price) }}</span>
                </p>
            </div>
        </div>



        {{-- 支払い方法 --}}
        <form method="GET" action="{{ route('purchase.index', ['item_id' => $item->id]) }}">
            <div class="purchase-section">
                <p class="label">支払い方法</p>
                <select class="input sell-select" name="payment" onchange="this.form.submit()">
                    <option value="" disabled hidden selected>選択してください</option>
                    <option value="コンビニ払い" {{ session('payment') == 'コンビニ払い' ? 'selected' : '' }}>コンビニ払い</option>
                    <option value="カード払い" {{ session('payment') == 'カード払い' ? 'selected' : '' }}>カード払い</option>
                </select>
            </div>
        </form>

        <form id="purchase-form" method="POST" action="{{ route('purchase.store', ['item_id' => $item->id]) }}">
            @csrf
            {{-- 配送先 --}}
            <div class="purchase-section">
                <div class="purchase-section-header">
                    <p class="label">配送先</p>
                    <a href="{{ route('address.edit', ['item_id' => $item->id]) }}" class="purchase-change-link">変更する</a>
                </div>
                <div class="purchase-address">
                    <p>〒{{ session('postcode', $user->postcode) }}</p>
                    <p>{{ session('address', $user->address) }}</p>
                    @if(!empty(session('building', $user->building)))
                    <p>{{ session('building', $user->building) }}</p>
                    @endif
                </div>
            </div>

        </form>
    </div>

    {{-- 右カラム --}}
    <div class="purchase-right">
        <dl class="purchase-confirm">
            <div class="purchase-confirm-row">
                <dt class="purchase-confirm-label">商品代金</dt>
                <dd class="purchase-confirm-value">¥{{ number_format($item->price) }}</dd>
            </div>
            <div class="purchase-confirm-row">
                <dt class="purchase-confirm-label">支払い方法</dt>
                <dd class="purchase-confirm-value">{{ session('payment', '-') }}</dd>
            </div>
        </dl>
        <button type="submit" form="purchase-form" class="action-bar purchase-btn">購入する</button>
    </div>

</div>
@endsection