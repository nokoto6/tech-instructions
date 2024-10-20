@php
    use App\Models\Category;

    $id = app('request')->input('id');

    $name = '';
    $symbol = '';

    if(!isset($id)) { 
        $id = null; 
    } else {
        $item = Category::whereKey($id)->get()->first();
        $name = $item->item_name;
        $symbol = $item->google_symbol_name;
    }
@endphp

@extends("body")

@if ($id) 
    @section('title', 'Редактирование категории')
@else
    @section('title', 'Создание категории')
@endif

@section("content")
    @if ($id) 
        <h1 class="main-title">Редактирование категории</h1>
    @else
        <h1 class="main-title">Создание категории</h1>
    @endif
    
    <a class="cute-button-link" href="{{url()->previous("/foo")}}">Назад</a> <br/>

    <div class="auth-container">
        <form 
            class="auth-form" 
            method="POST" 
            action="@if ($id) {{ route('category-create',['id' => $id]) }}
                    @else {{ route('category-create') }}
                    @endif">
            @csrf
            <div class="cute-input-text__container">
                <label for="item_name" class="cute-input-text__label">
                    <span>Название</span>
                    <span class="required">*</span>
                </label>
                <input class="cute-input-text__input" maxlength="80" type="text" name="item_name" id="item_name" value="{{$name}}" required>
            </div>

            <div class="cute-input-text__container">
                <label for="google_symbol_name" class="cute-input-text__label">
                    <span>Google символ</span>
                    <span class="required">*</span>
                    <span id="repeater" class="material-symbols-rounded">kitchen</span>
                </label>
                <input class="cute-input-text__input" maxlength="40" type="text" name="google_symbol_name" id="google_symbol_name" value="{{$symbol}}" required>
            </div>

            @if ($errors->any())
                <ul class="invalid-feedback">
                    @foreach ($errors->all() as $error)
                        <li class="invalid-feedback">
                            <strong>{{ $error }}</strong>
                        </li>
                    @endforeach
                </ul>
            @endif
            <button class="cute-button-form" type="submit">Сохранить</button>
        </form>
    </div>

    <script src="/public/js/inputs.js"></script>
    <script src="/public/js/input-symbol-repeater.js"></script>
@endsection