@php
    $search = app('request')->input('search');
    $page = app('request')->input('page');

    if(!isset($instructions)) { $instructions = []; }
    if(!isset($page)) { $page = 1; }

    $pageCount = ceil($instructions->total() / $instructions->perPage());

    $pagination = getPagination($page, $pageCount);
@endphp

<div class="main-container">
    <h1 class="main-title">Инструкции для техники</h1>
    
    <template class="main-button-content">
        @if( $instructions )
            <form class="search-form">
                <input class="simple-input simple-input__fillable simple-input__search border-null-right" type="text" id="search" name="search" placeholder="Поиск инструкции"/>
                <button class="simple-input simple-input__button border-null-left" type="submit">Искать</button>
            </form>
            @if ($search)
                <a class="simple-input simple-input__button simple-input__link" href="/">Сброс</a>
            @endif
        @endif
        <a class="simple-input simple-input__button simple-input__link" href="{{ route('instruction-form') }}">Добавить инструкцию</a>
    </template>

    @if( $instructions )
        <form class="search-form">
            <input class="cute-border__template cute-border__input-search" type="text" id="search" name="search" placeholder="Поиск инструкций"/>
        </form>

        @if ($search)
            <span class="instruction-list_count">По вашему запросу '{{$search}}' результатов: {{ $instructions->total() }}</span>
        @else
            <span class="instruction-list_count">Всего инструкций: {{ $instructions->total() }}</span>
        @endif

        <ul class="instruction-list">
            @foreach($instructions as $item)
                <li class="cute-border__template instruction-item">
                    <div class="instruction-item__text-container">
                        <a href="/" class="instruction-item__text instruction-item__category">
                            Холодильники
                        </a>
                        <span class="instruction-item__text instruction-item__name">
                            {{$item->item_name}}
                        </span>
                        <span class="instruction-item__text instruction-item__description">
                            {{$item->description}}
                        </span>
                    </div>
                    <a href="" class="instruction-item__symbol-container">
                        <span href="/" class="material-symbols-rounded cute-border__symbol">
                            arrow_forward_ios
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    @if( $instructions )
        <template class="instruction-list-container">
            @if ($search)
                <span class="instruction-list_count">По вашему запросу '{{$search}}' результатов: {{ $instructions->total() }}</span>
            @else
                <span class="instruction-list_count">Результатов: {{ $instructions->total() }}</span>
            @endif
            <table class="instruction-list">
                <tr class="instruction-head">
                    <th class="instruction-item_any" style="width:30%">Название техники</th>
                    <th class="instruction-item_any" style="width:60%">Описание</th>
                    <th class="instruction-item_any">Дата добавления</th>
                </tr>
                @foreach($instructions as $item)
                    <tr class="instruction-item" onclick="window.location='{{ route('instruction-view', ['id' => $item->id]) }}';">
                        <td class="instruction-item_any instruction-item_name">{{ $item->item_name }}</td>
                        <td class="instruction-item_any instruction-item_descr">
                            <div class="description-show">
                                {{ $item->description }}
                            </div>
                        </td>
                        <td class="instruction-item_any instruction-item_date">{{ $item->created_at->format('d.m.Y') }}</td>
                    </tr>
                @endforeach
            </table>
        </template>

        @if ($instructions->total() > $instructions->perPage())
            <div class="paginate_container">
                @if ($page > 1)
                    <a class="cute-paginate-box" href="{{ route('main', ['search' => $search, 'page' => 1]) }}">
                        <div class="cute-paginate-box__symbol material-symbols-rounded">first_page</div>
                    </a>
                @endif
                
                @foreach($pagination as $pageNum)
                    <a class="cute-paginate-box @if ($pageNum == $page) cute-paginate-box_active @endif" href="{{ route('main', ['search' => $search, 'page' => $pageNum]) }}">
                        <div class="cute-paginate-box__text">{{$pageNum}}</div>
                    </a>
                @endforeach
                
                @if ($instructions->hasMorePages())
                    <a class="cute-paginate-box" href="{{ route('main', ['search' => $search, 'page' => $pageCount]) }}">
                        <div class="cute-paginate-box__symbol material-symbols-rounded">last_page</div>
                    </a>
                @endif
            </div>
        @endif
    @endif
</div>
