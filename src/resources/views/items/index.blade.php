@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endpush

@section('content')
<div class="tab-area">
    <a class="tab-link" href="/">おすすめ</a>
    <a class="tab-link" href="/?tab=mylist">マイリスト</a>
</div>

<div class="products-row">
    @foreach($items as $item)
    <a class="product-card" href="{{ route('item.show', ['item_id' => $item->id]) }}">
        <div class="product-img-wrap">
            <img class="product-img" src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
            @if($purchasedItemIds->contains($item->id))
            <div class="sold-overlay">
                <p class="sold-text">sold</p>
            </div>
            @endif
        </div>
        <p class="product-name">{{ $item->name }}</p>
    </a>
    @endforeach
</div>
@endsection