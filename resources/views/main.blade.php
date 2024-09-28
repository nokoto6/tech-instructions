@php
    $search = app('request')->input('search');
    $page = app('request')->input('page');

    if(!isset($instructions)) { $instructions = []; }
    if(!isset($page)) { $page = 1; }
@endphp

<div class="main-container">
    <h1 class="main-title">Инструкции для техники</h1>
    
    <div class="main-button-content">
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
    </div>

    @if( $instructions )
        <div class="instruction-list-container">
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
        </div>

        @if ($instructions->total() > $instructions->perPage())
            <div class="paginate-selector-container">
                @if ($page > 1)
                    <a class="simple-input simple-input__button simple-input__link" href="{{ route('main', ['search' => $search, 'page' => $page-1]) }}"><-</a>
                @endif
                <span>{{ $page }} из {{ ceil($instructions->total() / $instructions->perPage()) }}</span>
                @if ($instructions->hasMorePages())
                    <a class="simple-input simple-input__button simple-input__link" href="{{ route('main', ['search' => $search, 'page' => $page+1]) }}">-></a>
                @endif
            </div>
        @endif
    @endif
</div>
