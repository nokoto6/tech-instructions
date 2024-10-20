@php
    use App\Models\Instructions;
    
    $page = app('request')->input('page');
    $filter = app('request')->input('filter');

    if(!isset($categories)) { $categories = []; }
    if(!isset($page)) { $page = 1; }

@endphp

@extends("pages/admin-panel")

@section("admin-content")
    <h1 class="main-title">Категории</h1>

    <a class="cute-button-link" href="{{ route('category-form') }}">Создать категорию</a><br>

    @if (count($categories)) 
        <ul class="cards-list">
            @foreach($categories as $item)
                <li class="cute-border__template cards-item cards-item_admin">
                    <span class="admin-cards__text admin-cards__text_name">
                        #{{ $item->id }} | {{ $item->item_name }}
                    </span>
                    <span class="admin-cards__text admin-cards__text_symbol">
                        <span>
                            Google символы: {{$item->google_symbol_name}}
                        </span>
                        <span class="material-symbols-rounded category-item__symbol">
                            {{$item->google_symbol_name}}
                        </span>
                    </span>
                    <span class="admin-cards__text admin-cards__text_date">
                        Создано {{ $item->created_at->format('d.m.Y') }}
                    </span>
                    @if (!Instructions::where(['category_id' => $item->id])->get()->first())
                        <form method="post" action="{{ route('category-delete', ['id' => $item->id]) }}">
                            @csrf
                            <input 
                                class="cute-button-form cute-button-form_small cute-button-form_red" 
                                type="submit" 
                                name="submit" 
                                value="Удалить">
                        </form>
                    @else
                        <span class="admin-cards__text admin-cards__text_date">
                            Удаление невозможно, категория уже освоена
                        </span>
                    @endif
                    <a class="cute-button-link" href="{{ route('category-form', ['id' => $item->id]) }}">Редактировать</a>
                </li>
            @endforeach
        </ul>
    @else
        <span>Список пуст</span>
    @endif

@endsection