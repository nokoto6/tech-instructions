@php
    use App\Models\Category;

    $page = app('request')->input('page');
    $filter = app('request')->input('filter');

    if(!isset($instructions)) { $instructions = []; }
    if(!isset($page)) { $page = 1; }
    if(!isset($filter)) { $filter = 'all'; }

    $filterNav = [
        'all' => 'Все',
        'accepted' => 'Одобренные',
        'notaccepted' => 'Неодобренные'
    ];

    if( $instructions ) {
        $pageCount = ceil($instructions->total() / $instructions->perPage());
        $pagination = getPagination($page, $pageCount);
        $onEachSide = count($pagination);
    }
@endphp

@extends("pages/admin-panel")

@section("admin-content")
    @if(isset($filterNav) && isset($filterNav[$filter]) ) 
        <h1 class="main-title">{{ $filterNav[$filter] }} инструкции</h1>
    @endif
    
    <a class="cute-button-link" href="{{ route('instruction-form') }}">Создать инструкцию</a>

    @if ($instructions->total() > $instructions->perPage())
        <div class="paginate_container">
            @if ( $pageCount > 5 && $page > 3 )
                <a class="cute-paginate-box" href="{{ route('admin-instructions', ['filter' => $filter, 'page' => 1]) }}">
                    <div class="cute-paginate-box__text">1</div>
                </a>
                <div class="paginate-dots">
                    <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                </div>
            @endif
            
            @foreach($pagination as $pageNum)
                <a class="cute-paginate-box @if ($pageNum == $page) cute-paginate-box_active @endif" href="{{ route('admin-instructions', ['filter' => $filter, 'page' => $pageNum]) }}">
                    <div class="cute-paginate-box__text">{{$pageNum}}</div>
                </a>
            @endforeach
            
            @if ( $pageCount > 5 && ($pageCount - $page) > 2  )
                <div class="paginate-dots">
                    <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                </div>
                <a class="cute-paginate-box" href="{{ route('admin-instructions', ['filter' => $filter, 'page' => $pageCount]) }}">
                    <div class="cute-paginate-box__text">{{$pageCount}}</div>
                </a>
            @endif
        </div>
    @endif

    <ul class="cards-list">
        @foreach($instructions as $item)
            <li class="cute-border__template cards-item">
                <div class="instruction-item__text-container">
                    <a href="/" class="instruction-item__text instruction-item__category">
                        {{ Category::whereKey($item->category_id)->get()->first()->item_name }}
                    </a>
                    <span class="instruction-item__text instruction-item__name">
                        #{{$item->id}} | {{$item->item_name}}
                    </span>
                    <span class="instruction-item__text instruction-item__description">
                        {{$item->description}}
                    </span>
                    <span class="instruction-item__text instruction-item__description">
                        Создано {{$item->created_at->format('d.m.Y')}}
                    </span>
                    <div class="instriction-item__admin-button-container">
                        @if(!$item->accepted)
                            <form method="post" action="{{ route('instruction-accept', ['id' => $item->id]) }}">
                                @csrf
                                <input 
                                    class="cute-button-form cute-button-form_small" 
                                    type="submit" 
                                    name="submit" 
                                    value="Одобрить">
                            </form>
                        @endif
                    </div>
                    <div class="instriction-item__admin-button-container">
                        <form method="post" action="{{ route('instruction-delete', ['id' => $item->id]) }}">
                            @csrf
                            <input 
                                class="cute-button-form cute-button-form_small cute-button-form_red" 
                                type="submit" 
                                name="submit" 
                                value="Удалить">
                        </form>
                    </div>
                </div>
                <a href="{{route('instruction-view', ['id'=>$item->id])}}" class="instruction-item__symbol-container">
                    <span class="material-symbols-rounded cute-border__symbol">
                        arrow_forward_ios
                    </span>
                </a>
            </li>
        @endforeach
    </ul>

    @if ($instructions->total() > $instructions->perPage())
        <div class="paginate_container">
            @if ( $pageCount > 5 && $page > 3 )
                <a class="cute-paginate-box" href="{{ route('admin-instructions', ['filter' => $filter, 'page' => 1]) }}">
                    <div class="cute-paginate-box__text">1</div>
                </a>
                <div class="paginate-dots">
                    <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                </div>
            @endif
            
            @foreach($pagination as $pageNum)
                <a class="cute-paginate-box @if ($pageNum == $page) cute-paginate-box_active @endif" href="{{ route('admin-instructions', ['filter' => $filter, 'page' => $pageNum]) }}">
                    <div class="cute-paginate-box__text">{{$pageNum}}</div>
                </a>
            @endforeach
            
            @if ( $pageCount > 5 && ($pageCount - $page) > 2  )
                <div class="paginate-dots">
                    <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                </div>
                <a class="cute-paginate-box" href="{{ route('admin-instructions', ['filter' => $filter, 'page' => $pageCount]) }}">
                    <div class="cute-paginate-box__text">{{$pageCount}}</div>
                </a>
            @endif
        </div>
    @endif
@endsection