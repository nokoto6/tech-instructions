@php
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon;

    $url = explode("?",Request::url())[0];

    if(preg_match('/^(http[s]?:\/\/[^\s\/]+\/[^\s\/]+)/', $url, $matches)) {
        $baseUrl = $matches[0];
    } else {
        $baseUrl = $url;
    }

    $routes = [
        [
            "name"  => "Главная",
            "link"  => route('main'),
            "symbol"   => "home"
        ],
        [
            "name"  => "Поиск",
            "link"  => route('results'),
            "symbol"   => "search"
        ],
        [
            "name"  => "Категории",
            "link"  => route('categories'),
            "symbol"   => "category"
        ],
        [
            "name"  => "Создать инструкцию",
            "link"  => route('instruction-form'),
            "symbol"   => "add_circle"
        ]
    ];

    if(Auth::user() && Auth::user()->is_admin) {
        array_push($routes,
        [
            "name"  => "Админ панель",
            "link"  => route('admin-panel'),
            "symbol"   => "admin_panel_settings"
        ]);
    }

    if(Auth::user()) {
        array_push($routes,
        [
            "name"  => "Выйти",
            "link"  => route('logout'),
            "symbol"   => "logout"
        ]);
    }


@endphp

<div class="top-header-phone">
    <div class="material-symbols-rounded burger">
        menu
    </div>
    <h2 class="main-title-phone"></h2>
</div>

<div class="overlay"></div>

<header class="header">
    <ul class="header__list">
        @if (Auth::user())
            <a href="{{route('redirect')}}" class="user__container">
                <img class="user__logo" src="/images/avatar-placeholder.png"/>
                <span class="user__name">{{Auth::user()->name}}</span>
            </a>
        @else
            <a href="{{route('login')}}" class="user__container">
                <img class="user__logo" src="/images/avatar-placeholder.png"/>
                <span class="user__name">Войти</span>
            </a>
        @endif

        @foreach ($routes as $item)
            <li class="header__item @if($baseUrl === $item['link']) header__item_active @endif">
                <a class="header__item-link" href="{{$item["link"]}}">
                    <span class="material-symbols-rounded">
                        {{$item["symbol"]}}
                    </span>
                    <span>{{$item["name"]}}</span>
                </a>
            </li>
        @endforeach
    </ul>
</header>
