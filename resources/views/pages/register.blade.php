@extends("body")

@section('title', 'Регистрация')

@section("content")
    <h1 class="main-title">Регистрация</h1>
    
    <div class="auth-container">
        <form class="auth-form" method="POST" action="{{ route('registerCreate') }}">
            @csrf
            <div class="cute-input-text__container">
                <label for="name" class="cute-input-text__label">
                    <span>Имя</span>
                    <span class="required">*</span>
                </label>
                <input class="cute-input-text__input" maxlength="40" type="text" name="name" id="name" value="" required>
            </div>

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
                        <li class="invalid-feedback">
                            <strong>{{ $error }}</strong>
                        </li>
                    @endforeach
                </ul>
            @endif
            @if (DB::table('users')->count() == 0)
                <li class="invalid-feedback notification__green">Первому созданному пользователю будут выданы admin привелегии, либо воспользуйтесь 'php artisan db:seed'</li>
            @endif
            <button class="cute-button-form" type="submit">Зарегистрироваться</button>
            <a class="cute-link-text" href="{{ route('login') }}">Уже есть аккаунт?</a>
        </form>
    </div>

    <script src="/public/js/inputs.js"></script>
@endsection