<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Local Mortgage App</title>
</head>
<body>
    <h1>Hey, put your data right here!</h1>
    <div>
        <form action="">
            <input placeholder="Тип ипотеки">
        </form>
    </div>
    <div style="margin: 50px 0 0 0">
        @php
        dd($_REQUEST);
        @endphp
    </div>
</body>
</html>
