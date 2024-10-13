@extends("body")

@section("content")

    <div class="auth-container">
        <h1 class="main-title">Создание инструкции</h1>
        <form 
            class="auth-form"  
            method="POST" 
            action="{{ route('instruction-create') }}"
            enctype="multipart/form-data"
        >
            @csrf
            
            <div class="cute-input-text__container">
                <label for="item_name" class="cute-input-text__label">
                    <span>Название техники</span>
                    <span class="required">*</span>
                </label>
                <input class="cute-input-text__input" maxlength="30" type="text" name="item_name" id="item_name" value="" required>
            </div>

            <div class="cute-input-text__container">
                <label for="description" class="cute-input-text__textarea-label">
                    <span>Описание</span>
                    <span class="required">*</span>
                </label>
                <textarea class="cute-input-text__textarea" maxlength="255" type="text" name="item_name" id="item_name" value="" required></textarea>
            </div>

            <textarea class="simple-input simple-input__fillable simple-input__area" maxlength="255" name="description" placeholder="Описание" required></textarea>
            <input class="simple-input simple-input__link simple-input__file" accept=".pdf" type="file" name="file" required>
            <div class="auth-border"></div>
            @if ($errors->any())
                <ul class="invalid-feedback">
                    @foreach ($errors->all() as $error)
                        <li>
                            <strong>{{ $error }}</strong>
                        </li>
                    @endforeach
                </ul>
            @endif
            @if (Auth::user()->is_admin)
                <li class="invalid-feedback invalid-feedback_hint">Инструкции администратора будут автоматически одобрены</li>
            @else
                <li class="invalid-feedback invalid-feedback_hint">Инструкция появится в общем доступе только после одобрения администрации</li>
            @endif
            <button class="simple-input simple-input__button" type="submit">Добавить</button>
        </form>
    </div>

    <script src="/js/inputs.js"></script>
@endsection