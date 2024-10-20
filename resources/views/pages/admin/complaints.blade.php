@php
    $page = app('request')->input('page');
    $filter = app('request')->input('filter');

    if(!isset($complaints)) { $complaints = []; }
    if(!isset($page)) { $page = 1; }

    if( $complaints ) {
        $pageCount = ceil($complaints->total() / $complaints->perPage());
        $pagination = getPagination($page, $pageCount);
        $onEachSide = count($pagination);
    }
@endphp

@extends("pages/admin-panel")

@section("admin-content")
    <h1 class="main-title">Жалобы на инструкции</h1>

    @if ($complaints->total() > $complaints->perPage())
        <div class="paginate_container">
            @if ( $pageCount > 5 && $page > 3 )
                <a class="cute-paginate-box" href="{{ route('admin-complaints', ['page' => 1]) }}">
                    <div class="cute-paginate-box__text">1</div>
                </a>
                <div class="paginate-dots">
                    <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                </div>
            @endif
            
            @foreach($pagination as $pageNum)
                <a class="cute-paginate-box @if ($pageNum == $page) cute-paginate-box_active @endif" href="{{ route('admin-complaints', ['page' => $pageNum]) }}">
                    <div class="cute-paginate-box__text">{{$pageNum}}</div>
                </a>
            @endforeach
            
            @if ( $pageCount > 5 && ($pageCount - $page) > 2  )
                <div class="paginate-dots">
                    <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                </div>
                <a class="cute-paginate-box" href="{{ route('admin-complaints', ['page' => $pageCount]) }}">
                    <div class="cute-paginate-box__text">{{$pageCount}}</div>
                </a>
            @endif
        </div>
    @endif

    @if (count($complaints)) 
        <ul class="cards-list">
            @foreach($complaints as $item)
                <li class="cute-border__template cards-item cards-item_admin">
                    <span class="admin-cards__text admin-cards__text_name">
                        ID жалобы: {{ $item->id }}
                    </span>
                    <span class="admin-cards__text admin-cards__text_email">
                        Описание: {{ $item->description }}
                    </span>
                    <span class="admin-cards__text admin-cards__text_date">
                        Жалоба создана {{ $item->created_at->format('d.m.Y') }}
                    </span>
                    <span class="admin-cards__text admin-cards__text_date">
                        ID пожаловавшегося: {{ $item->uploader_id }}
                    </span>
                    <span class="admin-cards__text admin-cards__text_date">
                        ID инструкции: {{ $item->instruction_id }}
                    </span>
                    <a class="cute-button-link" href="{{route('instruction-view', ['id'=>$item->instruction_id])}}">Перейти к инструкции</a>
                    <form method="post" action="{{ route('complaint-delete', ['id' => $item->id]) }}">
                        @csrf
                        <input 
                            class="cute-button-form cute-button-form_small cute-button-form_red" 
                            type="submit" 
                            name="submit" 
                            value="Удалить">
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <span>Список пуст</span>
    @endif

    @if ($complaints->total() > $complaints->perPage())
        <div class="paginate_container">
            @if ( $pageCount > 5 && $page > 3 )
                <a class="cute-paginate-box" href="{{ route('admin-complaints', ['page' => 1]) }}">
                    <div class="cute-paginate-box__text">1</div>
                </a>
                <div class="paginate-dots">
                    <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                </div>
            @endif
            
            @foreach($pagination as $pageNum)
                <a class="cute-paginate-box @if ($pageNum == $page) cute-paginate-box_active @endif" href="{{ route('admin-complaints', ['page' => $pageNum]) }}">
                    <div class="cute-paginate-box__text">{{$pageNum}}</div>
                </a>
            @endforeach
            
            @if ( $pageCount > 5 && ($pageCount - $page) > 2  )
                <div class="paginate-dots">
                    <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                </div>
                <a class="cute-paginate-box" href="{{ route('admin-complaints', ['page' => $pageCount]) }}">
                    <div class="cute-paginate-box__text">{{$pageCount}}</div>
                </a>
            @endif
        </div>
    @endif
@endsection