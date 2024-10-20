@extends("body")

@section('title', 'Создать пользователя')

@section("content")
    <a class="simple-input simple-input__button simple-input__link" href="{{url()->previous("/foo")}}">Назад</a>

    <div class="auth-container">
        <form method="POST" action="{{ route('registerCreate', ['noAuth' => true]) }}">
            @csrf
            <h1>Создать пользователя</h1>
            <input class="simple-input simple-input__fillable" maxlength="40" type="text" name="name" value="" placeholder="Имя" required>
            <input class="simple-input simple-input__fillable" maxlength="255" type="email" name="email" value="" placeholder="E-Mail" required>
            <input class="simple-input simple-input__fillable" maxlength="255" type="password" name="password" value="" placeholder="Пароль" required>
            <div class="simple-input simple-input__fillable">
                <br/>
                <label for="is_admin">Имеет права администратора?</label>
                <input type="checkbox" id="is_admin" name="is_admin" value="1">
            </div>
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
            <button class="simple-input simple-input__button" type="submit">Создать</button>
        </form>
    </div>
@endsection