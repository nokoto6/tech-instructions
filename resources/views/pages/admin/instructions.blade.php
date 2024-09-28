@php
    $page = app('request')->input('page');
    $filter = app('request')->input('filter');

    if(!isset($instructions)) { $instructions = []; }
    if(!isset($page)) { $page = 1; }
    if(!isset($filter)) { $filter = 'all'; }

    $filterNav = [
        'all' => 'Все',
        'accepted' => 'Одобренные',
        'notaccepted' => 'Неодобренные'
    ]
@endphp

@extends("pages/admin-panel")

@section("admin-content")
    @if(isset($filterNav) && isset($filterNav[$filter]) ) 
        <h1 class="mb_20">{{ $filterNav[$filter] }} инструкции</h1>
    @endif
    <a class="simple-input simple-input__button simple-input__link" href="{{ route('instruction-form') }}">Создать инструкцию</a> <br>
    <table class="instruction-list">
        <tr class="instruction-head">
            <th class="instruction-item_any" style="width:5%">Id</th>
            <th class="instruction-item_any" style="width:25%">Название техники</th>
            <th class="instruction-item_any">Описание</th>
            <th class="instruction-item_any" style="width:5%">Дата добавления</th>
            <th class="instruction-item_any" style="width:5%">*</th>
            <th class="instruction-item_any" style="width:5%">*</th>
        </tr>
        @foreach($instructions as $item)
            <tr class="instruction-item" onclick="window.location='{{ route('instruction-view', ['id' => $item->id]) }}';">
                <td class="instruction-item_any instruction-item_descr">{{ $item->id }}</td>
                <td class="instruction-item_any instruction-item_name">{{ $item->item_name }}</td>
                <td class="instruction-item_any instruction-item_descr">
                    <div class="description-show">
                        {{ $item->description }}
                    </div>
                </td>
                <td class="instruction-item_any instruction-item_date">{{ $item->created_at->format('d.m.Y') }}</td>
                <td>
                    @if(!$item->accepted)
                        <form method="post" action="{{ route('instruction-accept', ['id' => $item->id]) }}">
                            @csrf
                            <input 
                                class="simple-input simple-input__button simple-input__link simple-input__small" 
                                type="submit" 
                                name="submit" 
                                value="Одобрить">
                        </form>
                    @endif
                </td>
                <td>
                    <form method="post" action="{{ route('instruction-delete', ['id' => $item->id]) }}">
                        @csrf
                        <input 
                            class="simple-input simple-input__button simple-input__link simple-input__red simple-input__small" 
                            type="submit" 
                            name="submit" 
                            value="Удалить">
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    @if ($instructions->total() > $instructions->perPage())
        <div class="paginate-selector-container">
            @if ($page > 1)
                <a class="simple-input simple-input__button simple-input__link" href="{{ route('admin-instructions', ['filter' => $filter, 'page' => $page-1]) }}"><-</a>
            @endif
            <span>{{ $page }} из {{ ceil($instructions->total() / $instructions->perPage()) }}</span>
            @if ($instructions->hasMorePages())
                <a class="simple-input simple-input__button simple-input__link" href="{{ route('admin-instructions', ['filter' => $filter, 'page' => $page+1]) }}">-></a>
            @endif
        </div>
    @endif
@endsection