@php
    $page = app('request')->input('page');
    $filter = app('request')->input('filter');

    if(!isset($page)) { $page = 1; }

    if(!isset($filter)) { $filter = 'active'; }

    $filterNav = [
        'active' => 'Активные',
        'blocked' => 'Заблокированные'
    ]
@endphp

@extends("pages/admin-panel")

@section("admin-content")
    @if(isset($filterNav) && isset($filterNav[$filter]) ) 
        <h1 class="mb_20">{{ $filterNav[$filter] }} пользователи</h1>
    @endif
    <a class="simple-input simple-input__button simple-input__link" href="{{ route('user-create') }}">Добавить пользователя</a> <br>
    <table class="instruction-list">
    <tr class="instruction-head">
        <th class="instruction-item_any" style="width:5%">Id</th>
        <th class="instruction-item_any">Почта</th>
        <th class="instruction-item_any" style="width:15%">Имя</th>
        <th class="instruction-item_any" style="width:5%">Создан</th>
        <th class="instruction-item_any" style="width:5%">*</th>
        <th class="instruction-item_any" style="width:5%">*</th>
    </tr>
    @foreach($users as $user)
        <tr class="instruction-item">
            <td class="instruction-item_any instruction-item_descr">{{ $user->id }}</td>
            <td class="instruction-item_any instruction-item_name">{{ $user->email }}</td>
            <td class="instruction-item_any instruction-item_descr">{{ $user->name }}</td>
            <td class="instruction-item_any instruction-item_date">{{ $user->created_at->format('d.m.Y') }}</td>
            <td>
                <form method="post" action="{{ route('user-block', ['id' => $user->id, 'block' => !$user->blocked]) }}">
                    @csrf
                    <input 
                        class="simple-input simple-input__button simple-input__link simple-input__red simple-input__small" 
                        type="submit" 
                        name="submit" 
                        value="@if ($user->blocked)
                            Разблокировать
                        @else
                            Заблокировать
                        @endif">
                </form>
            </td>
            <td>
                <form method="post" action="{{ route('user-delete', ['id' => $user->id]) }}">
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

    @if ($users->total() > $users->perPage())
    <div class="paginate-selector-container">
        @if ($page > 1)
            <a class="simple-input simple-input__button simple-input__link" href="{{ route('admin-users', ['filter' => $filter, 'page' => $page-1]) }}"><-</a>
        @endif
        <span>{{ $page }} из {{ ceil($users->total() / $users->perPage()) }}</span>
        @if ($users->hasMorePages())
            <a class="simple-input simple-input__button simple-input__link" href="{{ route('admin-users', ['filter' => $filter, 'page' => $page+1]) }}">-></a>
        @endif
    </div>
    @endif
@endsection