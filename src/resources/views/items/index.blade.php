<!DOCTYPE html>
<html>

<body>
    <h1>商品一覧ページ (items.index)</h1>
    <a href="{{ route('item.show', ['item_id' => 1]) }}">商品1の詳細を見る</a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
</body>

</html>