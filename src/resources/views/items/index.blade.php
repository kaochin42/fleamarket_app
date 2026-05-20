@extends('layouts.app')

@section('content')
@foreach($items as $item)
<a href="{{ route('item.show', ['item_id' => $item->id]) }}">
    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
    <p>{{ $item->name }}</p>
</a>
@endforeach
@endsection