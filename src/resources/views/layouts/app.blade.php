<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>flea market</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header">
        <h1 class="header-logo">
            <a href="{{ route('item.index') }}"><img class="header-logo-img" src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH"></a>
        </h1>
        <input class="header-search" type="text" placeholder="なにをお探しですか？">
        <nav class="header-nav">
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="nav-button" type="submit">ログアウト</button>
            </form>
            <a class="nav-link" href="{{ route('mypage.show') }}">マイページ</a>
            <a class="nav-sell" href="{{ route('item.create') }}">出品</a>
            @else
            <a class="nav-link" href="{{ route('login') }}">ログイン</a>
            <a class="nav-link" href="{{ route('register') }}">会員登録</a>
            @endauth
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>