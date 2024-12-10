<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii Autobuz</title>
</head>
<body>
    <h1>Detalii despre linia de autobuz {{ $line }}</h1>
    <p>Traseu: {{ $route }}</p>
    <a href="{{ route('buses.list') }}">Înapoi la lista de autobuze</a>
</body>
</html>
