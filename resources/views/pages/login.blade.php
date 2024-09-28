@extends("body")

@section("content")
    <div class="auth-container">
        <form method="POST" action="{{ route('authentication') }}">
            @csrf
            <h1>Авторизация</h1>
            <input class="simple-input simple-input__fillable" maxlength="255" type="email" name="email" value="" placeholder="E-Mail" required>
            <input class="simple-input simple-input__fillable" maxlength="255" type="password" name="password" value="" placeholder="Пароль" required>
            <x-captcha-container />
            <div class="auth-border"></div>
            @if ($errors->any())
                <ul class="invalid-feedback">
                    @foreach ($errors->all() as $error)
                        <li class="invalid-feedback">
                            <strong>{{ $error }}</strong>
                        </li>
                    @endforeach
                </ul>
            @endif
            <button class="simple-input simple-input__button" type="submit">Войти</button>
            <a href="{{ route('register') }}">Нет аккаунта?</a>
        </form>
    </div>
@endsection