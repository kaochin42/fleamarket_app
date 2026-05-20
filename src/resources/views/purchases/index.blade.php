@extends('layouts.app')

@section('content')
<div>
    {{-- 商品情報 --}}
    <img src="{{ $item->image_path }}" alt="{{ $item->name }}">
    <p>{{ $item->name }}</p>
    <p>¥{{ $item->price }}</p>
</div>

<form method="POST" action="{{ route('purchase.store', ['item_id' => $item->id]) }}">
    @csrf

    {{-- 支払い方法 --}}
    <div>
        <label>支払い方法</label>
        <select name="payment">
            <option value="">選択してください</option>
            <option value="コンビニ払い">コンビニ払い</option>
            <option value="カード払い">カード払い</option>
        </select>
    </div>

    {{-- 配送先 --}}
    <div>
        <p>{{ session('postcode', $user->postcode) }}</p>
        <p>{{ session('address', $user->address) }}</p>
        @if(!empty(session('building', $user->building)))
        <p>{{ session('building', $user->building) }}</p>
        @endif

        <a href="{{ route('address.edit', ['item_id' => $item->id]) }}">変更する</a>
    </div>

    <button type="submit">購入する</button>
</form>
@endsection