<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/template.css') }}">
    <link rel="stylesheet" href="{{ asset('css/newstyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/media.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Главная</title>
    <x-captcha-js />
</head>
<body>
    <div class="body-container">
        @include("header")
        <div class="body">
            @section("content")
            @hasSection ('') @else @include("main") @endif
            @show
        </div>
    </div>

    <script>
        const mainTitleElement = document.querySelector('.main-title');
        if(mainTitleElement) {
            const mainTitleText = mainTitleElement.textContent;
            const mainTitlePhoneElement = document.querySelector('.main-title-phone');
            if(mainTitlePhoneElement) {
                mainTitlePhoneElement.textContent = mainTitleText;
            } 
        } 
    </script>
</body>
</html>