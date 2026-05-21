@extends('layouts.app')

@section('content')
<h2>住所の変更</h2>

@if($errors->any())
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif

<form method="POST" action="{{ route('address.update', ['item_id' => $item->id]) }}">
    @csrf

    <div>
        <label>郵便番号</label>
        <input type="text" name="postcode" value="{{ $user->postcode }}">
    </div>

    <div>
        <label>住所</label>
        <input type="text" name="address" value="{{ $user->address }}">
    </div>

    <div>
        <label>建物名</label>
        <input type="text" name="building" value="{{ $user->building }}">
    </div>

    <button type="submit">更新する</button>
</form>
@endsection