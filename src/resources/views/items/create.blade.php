@extends('layouts.app')
@section('content')

<h2>商品の出品</h2>

@if($errors->any())
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif

<form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data">
    @csrf

    {{-- 商品画像 --}}
    <div>
        <input type="file" name="image">
    </div>

    {{-- カテゴリ（複数選択） --}}
    <div>
        <label>カテゴリー</label>
        @foreach($categories as $category)
        <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
        <label>{{ $category->name }}</label>
        @endforeach
    </div>

    {{-- 商品の状態 --}}
    <div>
        <label>商品の状態</label>
        <select name="condition_id">
            <option value="">選択してください</option>
            @foreach($conditions as $condition)
            <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>{{ $condition->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- 商品名 --}}
    <div>
        <label>商品名</label>
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    {{-- ブランド名 --}}
    <div>
        <label>ブランド名</label>
        <input type="text" name="brand_name" value="{{ old('brand_name') }}">
    </div>

    {{-- 商品の説明 --}}
    <div>
        <label>商品の説明</label>
        <textarea name="description">{{ old('description') }}</textarea>
    </div>

    {{-- 販売価格 --}}
    <div>
        <label>販売価格</label>
        <input type="text" name="price" value="{{ old('price') }}">
    </div>

    <button type="submit">出品する</button>
</form>

@endsection