@php
    use App\Models\User;
    use App\Models\Category;

    $categories = Category::get();
    if( !$categories ) { $categories = []; }
@endphp

@extends("body")

@section('title', 'Инструкция к ' . $item->item_name)

@section("content")
    <a class="cute-button-link" href="{{url()->previous("/foo")}}">Назад</a>

    <div class="view-container">
        <h1 class="main-title">Инструкция к {{ $item->item_name }}</h1>

        <div class="item-view__container">

            <div>
                <span class="cute-bold-text">Категория устройства: </span>
                <span>
                    {{ Category::whereKey($item->category_id)->get()->first()->item_name }}
                </span>
            </div>

            @if ($item->description)
                <div>
                    <span class="cute-bold-text">Описание: </span>
                    <div class="item__description">{{ $item->description }}</div>
                </div>
            @endif

            <div>
                <span class="cute-bold-text">Инструкцию выложил: </span>
                <span>{{ User::where(['id' => $item->uploader_id])->first()->name }}</span>
            </div>
            
            <iframe class="item_view-iframe" src="{{ $item['file'] }}" seamless></iframe>

            <a class="cute-button-link" href="{{ $item['file'] }}" target=”_blank” type="submit">Открыть файл в новой вкладке</a>
            <a class="cute-button-link" href="{{ $item['file'] }}" download type="submit">Скачать файл</a>
        </div>

        <div class="complaints__container">
            <div class="complaints-help__container">
                <h3 class="complaints-help__text">С инструкцией что-то не так? Отправьте жалобу, администрация рассмотрит Ваш вопрос в ближайшее время</h3>
            </div>

            <div class="complaints-content">
                <div class="complaints-header__container">
                    <h2 class="complaints-title">Отправить жалобу</h2>
                </div>
                <form 
                    method="POST" 
                    action="{{ route('complaint-create', ['instruction_id'=>$item->id]) }}"
                >
                    @csrf
                    <textarea class="cute-input-text__textarea" maxlength="255" name="description" placeholder="Описание" required></textarea>
                    <button class="cute-button-form" type="submit">Отправить</button>
                </form>
            </div>
        </div>
    </div>
@endsection