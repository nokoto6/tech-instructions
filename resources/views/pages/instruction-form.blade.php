@php
    use App\Models\Category;

    $categories = Category::get();
    if( !$categories ) { $categories = []; }
@endphp

@extends("body")

@section('title', 'Создание инструкции')

@section("content")
    <div class="auth-container">
        <h1 class="main-title">Создание инструкции</h1>
        <form 
            class="auth-form"  
            method="POST" 
            action="{{ route('instruction-create') }}"
            enctype="multipart/form-data"
            onsubmit="submit()"
        >
            @csrf
            
            <div class="cute-input-text__container">
                <label for="item_name" class="cute-input-text__label">
                    <span>Название техники</span>
                    <span class="required">*</span>
                </label>
                <input class="cute-input-text__input" maxlength="40" type="text" name="item_name" id="item_name" value="" required>
            </div>

            <div class="cute-input-text__container">
                <label for="description" class="cute-input-text__textarea-label">
                    <span>Описание</span>
                </label>
                <textarea class="cute-input-text__textarea" maxlength="255" type="text" name="description" id="description" value=""></textarea>
            </div>

            <div class="cute-input-other__container">
                <label for="category_id" class="cute-input-category-label">
                    <span>Категория</span>
                    <span class="required required_always">*</span>
                </label>
                <div class="select-container select-container_form">
                    <div class="custom-select">
                        <select class="hidden-select" id="category_id" name="category_id">
                            @foreach($categories as $item)
                                <option value="{{$item->id}}">
                                    {{$item->item_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="cute-input-other__container">
                <label for="file" class="cute-input-category-label">
                    <span>Файл с инструкцией .PDF, не более 40мб</span>
                    <span class="required required_always">*</span>
                </label>
                <input class="cute-input-file" accept=".pdf" type="file" name="file" id="file" required>
            </div>

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
                <li class="invalid-feedback invalid-feedback_hint">Инструкция появится в общем доступе после одобрения администрации</li>
            @endif
            <button class="cute-button-form" type="submit">Добавить</button>
        </form>
    </div>

    <div class="loading">
        <span>Ожидайте, идет загрузка файла...</span>

        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>

        <a class="cute-button-link" href="{{route('instruction-form')}}">Отменить отправку</a> <br/>
    </div>

    <script src="/js/inputs.js"></script>
    <script src="/js/select.js"></script>

    <script>
        function submit() {
            document.querySelector('.loading').classList.add('loading_active');
        }
    </script>
@endsection