<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tramvaie</title>
</head>
<body>
    <h1>Lista liniilor de tramvai</h1>
    <ul>
        @foreach ($trams as $tram)
            <li>
                <a href="{{ route('trams.details', ['line' => $tram['line']]) }}">
                    Linia {{ $tram['line'] }}: {{ $tram['route'] }}
                </a>
            </li>
        @endforeach
    </ul>
</body>
</html>
