@extends("body")

@section("content")
    <div class="auth-container">
        <form method="POST" action="{{ route('registerCreate') }}">
            @csrf
            <h1>Регистрация</h1>
            <input class="simple-input simple-input__fillable" maxlength="40" type="text" name="name" value="" placeholder="Имя" required>
            <input class="simple-input simple-input__fillable" maxlength="255" type="email" name="email" value="" placeholder="E-Mail" required>
            <input class="simple-input simple-input__fillable" maxlength="255" type="password" name="password" value="" placeholder="Пароль" required>
            <x-captcha-container/>
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
            @if (DB::table('users')->count() == 0)
                <li class="invalid-feedback notification__green">Первому созданному пользователю будут выданы admin привелегии, либо воспользуйтесь семечком 'php artisan db:seed'</li>
            @endif
            <button class="simple-input simple-input__button" type="submit">Зарегистрироваться</button>
            <a href="{{ route('login') }}">Уже есть аккаунт?</a>
        </form>
    </div>
@endsection