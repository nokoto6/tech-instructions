@php
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon;
@endphp

<header class="header">
    <div class="header_item-list">
        <div class="header_item">
            <p class="logo-text"><a href="/">Tech Instructions</a></p>
        </div>
        
        <div class="header_item">
            @auth
                @if(Auth::user()->is_admin)
                    <a class="header_item-link" href="{{ route('admin-instructions') }}">Админ панель</a>
                @endif
                <a class="header_item-link" href="{{ route('logout') }}">Выйти</a>
                <div class="avatar-container">
                    <img class="avatar_img" src="/images/avatar.svg"/>
                    <p class="avatar_name">{{ Auth::user()->name }}</p>
                </div>
            @else
                <a class="header_item-link" href="{{ route('login') }}">Войти</a>
                <a class="header_item-link" href="{{ route('register') }}">Регистрация</a>
            @endauth
        </div>

    </div>
</header>