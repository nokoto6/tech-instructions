@extends("body")

@section("content")

    <a class="simple-input simple-input__button simple-input__link" href="{{url()->previous("/foo")}}">Назад</a>

    <div class="auth-container">
        <form 
            method="POST" 
            action="{{ route('instruction-create') }}"
            enctype="multipart/form-data"
        >
            @csrf
            <h1>Создание инструкции</h1>
            <input class="simple-input simple-input__fillable" maxlength="30" type="text" name="item_name" value="" placeholder="Название техники" required>
            <textarea class="simple-input simple-input__fillable simple-input__area" maxlength="255" name="description" placeholder="Описание" required></textarea>
            <input class="simple-input simple-input__link simple-input__file" accept=".pdf" type="file" name="file" required>
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
            @if (Auth::user()->is_admin)
                <li class="invalid-feedback notification__green">Инструкции администратора будут автоматически одобрены</li>
            @else
                <li class="invalid-feedback notification__blue">Инструкция появится в общем доступе только после одобрения администрации</li>
            @endif
            <button class="simple-input simple-input__button" type="submit">Добавить</button>
        </form>
    </div>
@endsection