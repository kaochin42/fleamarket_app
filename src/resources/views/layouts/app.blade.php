<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>flea market</title>
</head>

<body>
    <header>
        <h1><a href="{{ route('item.index') }}">COACHTECH</a></h1>
        <input type="text" placeholder="なにをお探しですか？">
        @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">ログアウト</button>
        </form>
        <a href="{{ route('mypage.show') }}">マイページ</a>
        <a href="{{ route('item.create') }}">出品</a>
        @else
        <a href="{{ route('login') }}">ログイン</a>
        <a href="{{ route('register') }}">会員登録</a>
        @endauth
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>