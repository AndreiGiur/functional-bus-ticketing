<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autobuze</title>
</head>
<body>
    <h1>Lista liniilor de autobuz</h1>
    <ul>
        @foreach ($buses as $bus)
            <li>
                <a href="{{ route('buses.details', ['line' => $bus['line']]) }}">
                    Linia {{ $bus['line'] }}: {{ $bus['route'] }}
                </a>
            </li>
        @endforeach
    </ul>
</body>
</html>
