@php
    $page = app('request')->input('page');
    $filter = app('request')->input('filter');

    if(!isset($complaints)) { $complaints = []; }
    if(!isset($page)) { $page = 1; }
@endphp

@extends("pages/admin-panel")

@section("admin-content")
    <h1 class="mb_20">Жалобы на инструкции</h1>

    <table class="instruction-list">
        <tr class="instruction-head">
            <th class="instruction-item_any" style="width:5%">Id</th>
            <th class="instruction-item_any" style="width:35%">Описание</th>
            <th class="instruction-item_any" style="width:5%">Id инструкции</th>
            <th class="instruction-item_any" style="width:7%">Id пожаловавшегося</th>
            <th class="instruction-item_any" style="width:5%">Дата добавления</th>
            <th class="instruction-item_any" style="width:5%">*</th>
        </tr>
        @foreach($complaints as $item)
            <tr class="instruction-item" onclick="window.location='{{ route('instruction-view', ['id' => $item->instruction_id]) }}';">
                <td class="instruction-item_any instruction-item_descr">{{ $item->id }}</td>
                <td class="instruction-item_any instruction-item_name">
                    <div class="description-show">
                        {{ $item->description }}
                    </div>
                </td>
                <td class="instruction-item_any instruction-item_descr">{{ $item->instruction_id }}</td>
                <td class="instruction-item_any instruction-item_descr">{{ $item->uploader_id }}</td>
                <td class="instruction-item_any instruction-item_date">{{ $item->created_at->format('d.m.Y') }}</td>
                <td>
                    <form method="post" action="{{ route('complaint-delete', ['id' => $item->id]) }}">
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

    @if ($complaints->total() > $complaints->perPage())
        <div class="paginate-selector-container">
            @if ($page > 1)
                <a class="simple-input simple-input__button simple-input__link" href="{{ route('admin-complaints', ['page' => $page-1]) }}"><-</a>
            @endif
            <span>{{ $page }} из {{ ceil($complaints->total() / $complaints->perPage()) }}</span>
            @if ($complaints->hasMorePages())
                <a class="simple-input simple-input__button simple-input__link" href="{{ route('admin-complaints', ['page' => $page+1]) }}">-></a>
            @endif
        </div>
    @endif
@endsection