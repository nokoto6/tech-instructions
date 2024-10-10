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
            "link"  => route('login'),
            "symbol"   => "search"
        ],
        [
            "name"  => "Категории",
            "link"  => route('login'),
            "symbol"   => "category"
        ],
        [
            "name"  => "Создать инструкцию",
            "link"  => route('instruction-form'),
            "symbol"   => "add_circle"
        ],
        [
            "name"  => "Админ панель",
            "link"  => route('admin-panel'),
            "symbol"   => "admin_panel_settings"
        ]
    ];
@endphp

<div class="top-header-phone">
    <div class="material-symbols-rounded burger">
        menu
    </div>
    <h2 class="main-title-phone">хуй</h2>
</div>

<header class="header">
    <ul class="header__list">
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

<script>
    const burger = document.querySelector('.burger');
    const header = document.querySelector('.header');

    function headerTransToggle(force) {
        header.classList.toggle('header_transition', force);
    }

    function toggleBurger() {
        if(!document.querySelector('.header_transition')) {
            const burgerActive = burger.classList.toggle('burger_active');
            header.classList.toggle('header_active', burgerActive);

            headerTransToggle(true)
            setTimeout(() => headerTransToggle(false), 550);
        }
    }

    burger.addEventListener('click', toggleBurger);
</script>