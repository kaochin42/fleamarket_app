@extends('layouts.app')

@section('content')
<div>
    {{-- 商品画像 --}}
    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
</div>

<div>
    {{-- 商品名 --}}
    <h2>{{ $item->name }}</h2>

    {{-- ブランド名 --}}
    <p>{{ $item->brand_name }}</p>

    {{-- 価格 --}}
    <p>¥{{ $item->price }}(税込)</p>

    {{-- 購入ボタン --}}
    <a href="{{ route('purchase.index', ['item_id' => $item->id]) }}">購入手続きへ</a>

    {{-- 商品説明 --}}
    <h3>商品説明</h3>
    <p>{{ $item->description }}</p>

    {{-- 商品の情報 --}}
    <h3>商品の情報</h3>
    <dl>
        <dt>カテゴリー</dt>
        <dd>
            @foreach($item->categories as $category)
            <span>{{ $category->name }}</span>
            @endforeach
        </dd>
        <dt>商品の状態</dt>
        <dd>{{ $item->condition->name }}</dd>
    </dl>

    {{-- コメント一覧 --}}
    <h3>コメント({{ $item->comments->count() }})</h3>
    @foreach($item->comments as $comment)
    <div>
        <p>{{ $comment->user->name }}</p>
        <p>{{ $comment->comment }}</p>
    </div>
    @endforeach

    {{-- コメントフォーム --}}
    <form method="POST" action="{{ route('comment.store', ['item_id' => $item->id]) }}">
        @csrf
        <textarea name="comment"></textarea>
        <button type="submit">コメントを送信する</button>
    </form>
</div>
@endsection