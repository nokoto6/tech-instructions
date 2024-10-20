@extends("body")

@section('title', 'Категории')

@section("content")
    <h1 class="main-title">Категории</h1>

    @if ($categories)
        <ul class="category-list">
            @foreach($categories as $item)
                <li class="cute-border__template category-item">
                    <a href="{{ route('results', ['category' => $item->id]) }}" class="category-item__link">
                        <div href="" class="category-item__symbol-container">
                            <span class="material-symbols-rounded category-item__symbol">
                                {{$item->google_symbol_name}}
                            </span>
                        </div>
                        <div class="category-item__text-container">
                            <span class="category-item__text">
                                {{$item->item_name}}
                            </span>
                        </div>
                        <span class="category-item__arrow-container">
                            <span class="material-symbols-rounded category-item__arrow cute-border__symbol">
                                arrow_forward_ios
                            </span>
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection