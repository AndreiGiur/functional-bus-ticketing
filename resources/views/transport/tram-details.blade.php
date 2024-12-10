<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii Tramvai</title>
</head>
<body>
    <h1>Detalii despre linia de tramvai {{ $line }}</h1>
    <p>Traseu: {{ $route }}</p>
    <a href="{{ route('trams.list') }}">Înapoi la lista de tramvaie</a>
</body>
</html>
