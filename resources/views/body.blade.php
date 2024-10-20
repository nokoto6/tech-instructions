<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/x-icon" href={{ asset('/public/favicon.ico') }}>
        <link rel="stylesheet" href="{{ asset('/public/css/template.css') }}">
        <link rel="stylesheet" href="{{ asset('/public/css/newstyle.css') }}">
        <link rel="stylesheet" href="{{ asset('/public/css/media.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        @hasSection('title') <title>@yield('title')</title> @else <title>Главная</title> @endif
        <x-captcha-js />
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
        
            ym(98678399, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true
            });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/98678399" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
    </head>
    <body>
        <style> body { display: none; } </style>
        
        @include("header")
        <div class="body">
            @section("content")
            @hasSection ('') @else @include("main") @endif
            @show
        </div>

        <script src="/public/js/header.js"></script>
        <style> body { display: block; } </style>
    </body>
</html>