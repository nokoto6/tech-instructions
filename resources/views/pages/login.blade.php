@extends("body")

@section("content")
    <h1 class="main-title">Авторизация</h1>
    
    <div class="auth-container">
        <form class="auth-form" method="POST" action="{{ route('authentication') }}">
            @csrf
            <div class="cute-input-text__container">
                <label for="email" class="cute-input-text__label">
                    <span>E-Mail</span>
                    <span class="required">*</span>
                </label>
                <input class="cute-input-text__input" maxlength="255" type="email" name="email" id="email" value="" required>
            </div>

            <div class="cute-input-text__container margin-bottom-20">
                <label for="password" class="cute-input-text__label">
                    <span>Пароль</span>
                    <span class="required">*</span>
                </label>
                <input class="cute-input-text__input" maxlength="255" type="password" name="password" id="password" value="" required>
            </div>
            <x-captcha-container />
            @if ($errors->any())
                <ul class="invalid-feedback">
                    @foreach ($errors->all() as $error)
                        <li>
                            <strong>{{ $error }}</strong>
                        </li>
                    @endforeach
                </ul>
            @endif
            <button class="cute-button-form" type="submit">Войти</button>
            <a class="cute-link-text" href="{{ route('register') }}">Нет аккаунта?</a>
        </form>
    </div>

    <script src="/js/inputs.js"></script>
@endsection