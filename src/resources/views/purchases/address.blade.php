@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endpush

@section('content')
<div class="inner">
    <h2 class="title">住所の変更</h2>

    <form method="POST" action="{{ route('address.update', ['item_id' => $item->id]) }}">
        @csrf

        <div class="form-group form-group-postcode">
            <label class="label">郵便番号</label>
            <input class="input" type="text" name="postcode" value="{{ old('postcode', $user->postcode) }}">
            @error('postcode')<p class="error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group form-group-address">
            <label class="label">住所</label>
            <input class="input" type="text" name="address" value="{{ old('address', $user->address) }}">
            @error('address')<p class="error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group form-group-building">
            <label class="label">建物名</label>
            <input class="input" type="text" name="building" value="{{ old('building', $user->building) }}">
            @error('building')<p class="error">{{ $message }}</p>@enderror
        </div>

        <button class="action-bar" type="submit">更新する</button>
    </form>
</div>
@endsection