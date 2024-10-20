<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="refresh" content="4.9;url={{route('main')}}"/>
    <link rel="stylesheet" href="/css/redirect.css">
    <title>Перенаправление</title>
</head>
    <body>
        <style> body { display: none; } </style>

        <div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
         </div>

         @if ($errors->any())
            <h1 class="alert">
                {{$errors->first()}}
            </h1>
         @else
            <h1 class="alert alert_red">
                404...
            </h1>
            <h1 class="alert">
                Такой страницы ещё нет :(
            </h1>
         @endif

        <span class="text">
            Перенаправление через:
        </span>
        <div id="container"></div>
        <span class="text">
            или
        </span>
        <a class="cute-button-link" href="{{route('main')}}">Перейти на главную</a>

        <script src="/js/redirect.js"></script>

        <style> body { display: flex; } </style>
    </body>
</html>
