@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/item-show.css') }}">
@endpush

@section('content')

<div class="item-detail">
    {{-- 左カラム：商品画像 --}}
    <div class="item-img-col">
        <img class="item-main-img" src="{{ Str::startsWith($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
    </div>

    {{-- 右カラム --}}
    <div class="item-info-col">

        {{-- 商品名・ブランド・価格 --}}
        <div class="item-title-area">
            <h2 class="item-name">{{ $item->name }}</h2>
            <p class="item-brand">{{ $item->brand_name }}</p>
            <p class="item-price"><span class="item-tax">¥</span>{{ number_format($item->price) }}<span class="item-tax">（税込）</span></p>

            {{-- いいね・コメント --}}
            <div class="item-actions">
                <form method="POST" action="{{ route('like.toggle', ['item_id' => $item->id]) }}">
                    @csrf
                    <button class="action-icon-btn" type="submit">
                        @if($item->likes->contains('user_id', auth()->id()))
                        <img class="action-icon" src="{{ asset('images/ハートロゴ_ピンク.png') }}" alt="いいね済み">
                        @else
                        <img class="action-icon" src="{{ asset('images/ハートロゴ_デフォルト.png') }}" alt="いいね">
                        @endif
                    </button>
                    <span class="action-count">{{ $item->likes->count() }}</span>
                </form>
                <div class="action-icon-wrap">
                    <img class="action-icon" src="{{ asset('images/ふきだしロゴ.png') }}" alt="コメント">
                    <span class="action-count">{{ $item->comments->count() }}</span>
                </div>
            </div>
        </div>

        {{-- 購入ボタン --}}
        <a class="action-bar item-purchase-btn" href="{{ route('purchase.index', ['item_id' => $item->id]) }}">購入手続きへ</a>

        {{-- 商品説明 --}}
        <div class="item-section">
            <h3 class="item-section-title">商品説明</h3>
            <p class="item-description">{{ $item->description }}</p>
        </div>

        {{-- 商品の情報 --}}
        <div class="item-section">
            <h3 class="item-section-title">商品の情報</h3>
            <dl class="item-info-list">
                <div class="item-info-row">
                    <dt class="item-info-label">カテゴリー</dt>
                    <dd class="item-info-value">
                        @foreach($item->categories as $category)
                        <span class="category-badge">{{ $category->name }}</span>
                        @endforeach
                    </dd>
                </div>
                <div class="item-info-row">
                    <dt class="item-info-label">商品の状態</dt>
                    <dd class="item-info-value">{{ $item->condition->name }}</dd>
                </div>
            </dl>
        </div>

        {{-- コメント一覧 --}}
        <div class="item-section">
            <h3 class="comment-section-title">コメント({{ $item->comments->count() }})</h3>
            @foreach($item->comments as $comment)
            <div class="comment-item">
                <div class="comment-user">
                    @if($comment->user->profile_img)
                    <img class="comment-avatar" src="{{ asset('storage/' . $comment->user->profile_img) }}" alt="{{ $comment->user->name }}">
                    @else
                    <div class="comment-avatar"></div>
                    @endif
                    <p class="comment-username">{{ $comment->user->name }}</p>
                </div>
                <div class="comment-text">{{ $comment->comment }}</div>
            </div>
            @endforeach

            {{-- コメントフォーム --}}
            <h3 class="comment-form-title">商品へのコメント</h3>
            <form method="POST" action="{{ route('comment.store', ['item_id' => $item->id]) }}">
                @csrf
                <textarea class="comment-textarea" name="comment"></textarea>
                @error('comment')<p class="error">{{ $message }}</p>@enderror
                <button class="action-bar comment-submit-btn" type="submit">コメントを送信する</button>
            </form>
        </div>

    </div>
</div>

@endsection