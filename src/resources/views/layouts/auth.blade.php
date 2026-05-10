<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>flea market</title>
</head>

<body>
    <header>
        <h1><a href="{{ route('item.index') }}">COACHTECH</a></h1>
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>