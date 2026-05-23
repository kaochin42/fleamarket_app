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
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>