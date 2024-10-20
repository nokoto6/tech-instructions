@php
    $page = app('request')->input('page');
    $filter = app('request')->input('filter');

    if(!isset($page)) { $page = 1; }

    if(!isset($filter)) { $filter = 'active'; }

    $filterNav = [
        'active' => 'Активные',
        'blocked' => 'Заблокированные'
    ];

    if( $users ) {
        $pageCount = ceil($users->total() / $users->perPage());
        $pagination = getPagination($page, $pageCount);
        $onEachSide = count($pagination);
    }
@endphp

@extends("pages/admin-panel")

@section("admin-content")
    @if(isset($filterNav) && isset($filterNav[$filter]) ) 
        <h1 class="main-title">{{ $filterNav[$filter] }} пользователи</h1>
    @endif

    @if ($users->total() > $users->perPage())
        <div class="paginate_container">
            @if ( $pageCount > 5 && $page > 3 )
                <a class="cute-paginate-box" href="{{ route('admin-users', ['filter' => $filter, 'page' => 1]) }}">
                    <div class="cute-paginate-box__text">1</div>
                </a>
                <div class="paginate-dots">
                    <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                </div>
            @endif
            
            @foreach($pagination as $pageNum)
                <a class="cute-paginate-box @if ($pageNum == $page) cute-paginate-box_active @endif" href="{{ route('admin-users', ['filter' => $filter, 'page' => $pageNum]) }}">
                    <div class="cute-paginate-box__text">{{$pageNum}}</div>
                </a>
            @endforeach
            
            @if ( $pageCount > 5 && ($pageCount - $page) > 2  )
                <div class="paginate-dots">
                    <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                </div>
                <a class="cute-paginate-box" href="{{ route('admin-users', ['filter' => $filter, 'page' => $pageCount]) }}">
                    <div class="cute-paginate-box__text">{{$pageCount}}</div>
                </a>
            @endif
        </div>
    @endif

    <ul class="cards-list">
        @foreach($users as $item)
            <li class="cute-border__template cards-item cards-item_admin">
                <div class="admin-cards__user-container">
                    <div>
                        <img class="user__logo" src="/public/images/avatar-placeholder.png"/>
                    </div>
                    <div class="cards-item_admin">
                        <span class="admin-cards__text admin-cards__text_name">
                            #{{ $item->id }} | {{ $item->name }}
                        </span>
                        <span class="admin-cards__text admin-cards__text_email">
                            E-Mail: {{ $item->email }}
                        </span>
                        <span class="admin-cards__text admin-cards__text_date">
                            Создан {{ $item->created_at->format('d.m.Y') }}
                        </span>
                    </div>
                </div>
                @if(!$item->is_admin)
                    <form method="post" action="{{ route('user-block', ['id' => $item->id, 'block' => !$item->blocked]) }}">
                        @csrf
                        <input 
                            class="cute-button-form cute-button-form_small" 
                            type="submit" 
                            name="submit" 
                            value="@if ($item->blocked) Разблокировать @else Заблокировать @endif">
                    </form>
                    <form method="post" action="{{ route('user-delete', ['id' => $item->id]) }}">
                        @csrf
                        <input 
                            class="cute-button-form cute-button-form_small cute-button-form_red" 
                            type="submit" 
                            name="submit" 
                            value="Удалить">
                    </form>
                @endif
            </li>
        @endforeach
    </ul>

    @if ($users->total() > $users->perPage())
        <div class="paginate_container">
            @if ( $pageCount > 5 && $page > 3 )
                <a class="cute-paginate-box" href="{{ route('admin-users', ['filter' => $filter, 'page' => 1]) }}">
                    <div class="cute-paginate-box__text">1</div>
                </a>
                <div class="paginate-dots">
                    <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                </div>
            @endif
            
            @foreach($pagination as $pageNum)
                <a class="cute-paginate-box @if ($pageNum == $page) cute-paginate-box_active @endif" href="{{ route('admin-users', ['filter' => $filter, 'page' => $pageNum]) }}">
                    <div class="cute-paginate-box__text">{{$pageNum}}</div>
                </a>
            @endforeach
            
            @if ( $pageCount > 5 && ($pageCount - $page) > 2  )
                <div class="paginate-dots">
                    <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                </div>
                <a class="cute-paginate-box" href="{{ route('admin-users', ['filter' => $filter, 'page' => $pageCount]) }}">
                    <div class="cute-paginate-box__text">{{$pageCount}}</div>
                </a>
            @endif
        </div>
    @endif
@endsection