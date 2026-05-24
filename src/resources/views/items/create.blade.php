@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endpush
@section('content')

<div class="inner">
    <h2 class="title">商品の出品</h2>

    <form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- 商品画像 --}}
        <div class="sell-img-wrap">
            <p class="label">商品画像</p>
            <div class="sell-img-box">
                <label class="action-bar-outline sell-img-btn" for="image">画像を選択する</label>
                <input type="file" name="image" id="image" style="display:none;">
            </div>
            @error('image')<p class="error">{{ $message }}</p>@enderror
        </div>

        {{-- 商品の詳細 --}}
        <div class="sell-section">
            <h3 class="sell-section-title">商品の詳細</h3>

            {{-- カテゴリー --}}
            <div class="sell-form-group">
                <p class="label">カテゴリー</p>
                <div class="category-list">
                    @foreach($categories as $category)
                    <label class="category-item {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'category-active' : '' }}">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }} style="display:none;">
                        {{ $category->name }}
                    </label>
                    @endforeach
                </div>
                @error('categories')<p class="error">{{ $message }}</p>@enderror
            </div>

            {{-- 商品の状態 --}}
            <div class="sell-form-group">
                <p class="label">商品の状態</p>
                <select class="input sell-select" name="condition_id">
                    <option value="" disabled hidden selected>選択してください</option>
                    @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>{{ $condition->name }}</option>
                    @endforeach
                </select>
                @error('condition_id')<p class="error">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- 商品名と説明 --}}
        <div class="sell-section">
            <h3 class="sell-section-title">商品名と説明</h3>

            <div class="sell-form-group">
                <p class="label">商品名</p>
                <input class="input" type="text" name="name" value="{{ old('name') }}">
                @error('name')<p class="error">{{ $message }}</p>@enderror
            </div>

            <div class="sell-form-group">
                <p class="label">ブランド名</p>
                <input class="input" type="text" name="brand_name" value="{{ old('brand_name') }}">
            </div>

            <div class="sell-form-group">
                <p class="label">商品の説明</p>
                <textarea class="input sell-textarea" name="description">{{ old('description') }}</textarea>
                @error('description')<p class="error">{{ $message }}</p>@enderror
            </div>

            <div class="sell-form-group">
                <p class="label">販売価格</p>
                <div class="price-wrap">
                    <span class="price-yen">¥</span>
                    <input class="input price-input" type="text" name="price" value="{{ old('price') }}">
                </div>
                @error('price')<p class="error">{{ $message }}</p>@enderror
            </div>
        </div>

        <button class="action-bar sell-btn" type="submit">出品する</button>
    </form>
</div>

@endsection