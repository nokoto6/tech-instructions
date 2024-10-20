@php
    use App\Models\Category;

    $search = app('request')->input('search'); 
    $category = app('request')->input('category'); 
    $page = app('request')->input('page');

    if(!isset($page)) { $page = 1; }

    if(!isset($instructions)) { $instructions = []; }

    if( $instructions ) {
        $pageCount = ceil($instructions->total() / $instructions->perPage());

        $pagination = getPagination($page, $pageCount);
        $onEachSide = count($pagination);
    }

    $categories = Category::get();
    if( !$categories ) { $categories = []; }

    $categoryName = "";

    if( $category ) {
        $categoryName = Category::whereKey($category)->get()->first()->item_name;
    }
@endphp

@extends("body")

@section('title', 'Поиск инструкций')

@section("content")
    <div class="main-container">
        <h1 class="main-title">Поиск инструкций для техники</h1>

        <template class="categoryTemplate">{{$categoryName}}</template>

        <form class="search-form">
            <div class="search-form-container">
                <input class="cute-border__template cute-border__input-search" type="text" id="search" name="search" placeholder="Поиск инструкций"
                value="{{$search}}"
                />
                <div class="search-categories-button__container">
                    <div class="search-categories-button material-symbols-rounded">
                        settings
                    </div>
                </div>
            </div>
            <div class="select-container">
                <span class="select-label">
                    Искать в категории:
                </span>
                <div class="custom-select">
                    <select class="hidden-select" name="category">
                        @foreach($categories as $item)
                            <option value="{{$item->id}}">
                                {{$item->item_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        @if ($search || $category)
            <div class="clear-search-container">
                <a href="{{route('results')}}" class="cute-button-link">Сбросить поиск</a>
            </div>
        @endif

        @if( $instructions && count($instructions) )
            @if ($search)
                <span class="instruction-list_count">По вашему запросу '{{$search}}' результатов: {{ $instructions->total() }}</span>
            @else
                <span class="instruction-list_count">Всего инструкций: {{ $instructions->total() }}</span>
            @endif

            @if ($instructions->total() > $instructions->perPage())
                <div class="paginate_container">
                    @if ( $pageCount > 5 && $page > 3 )
                        <a class="cute-paginate-box" href="{{ route('results', ['search' => $search, 'category' => $category, 'page' => 1]) }}">
                            <div class="cute-paginate-box__text">1</div>
                        </a>
                        <div class="paginate-dots">
                            <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                        </div>
                    @endif
                    
                    @foreach($pagination as $pageNum)
                        <a class="cute-paginate-box @if ($pageNum == $page) cute-paginate-box_active @endif" href="{{ route('results', ['search' => $search, 'category' => $category, 'page' => $pageNum]) }}">
                            <div class="cute-paginate-box__text">{{$pageNum}}</div>
                        </a>
                    @endforeach
                    
                    @if ( $pageCount > 5 && ($pageCount - $page) > 2  )
                        <div class="paginate-dots">
                            <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                        </div>
                        <a class="cute-paginate-box" href="{{ route('results', ['search' => $search, 'category' => $category, 'page' => $pageCount]) }}">
                            <div class="cute-paginate-box__text">{{$pageCount}}</div>
                        </a>
                    @endif
                </div>
            @endif
            
            <ul class="cards-list">
                @foreach($instructions as $item)
                    <li class="cute-border__template">
                        <div class="cards-item" onclick="window.location.href='{{route('instruction-view', ['id'=>$item->id])}}'">
                            <div class="instruction-item__text-container">
                                <a href="{{ route('results', ['category' => $item->category_id]) }}" class="instruction-item__text instruction-item__category">
                                    {{ Category::whereKey($item->category_id)->get()->first()->item_name }}
                                </a>
                                <span class="instruction-item__text instruction-item__name">
                                    {{$item->item_name}}
                                </span>
                                <span class="instruction-item__text instruction-item__description">
                                    {{$item->description}}
                                </span>
                            </div>
                            <div class="instruction-item__symbol-container">
                                <span class="material-symbols-rounded cute-border__symbol">
                                    arrow_forward_ios
                                </span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="paginate_container">
                @if ($instructions->total() > $instructions->perPage())
                        @if ( $pageCount > 5 && $page > 3 )
                            <a class="cute-paginate-box" href="{{ route('results', ['search' => $search, 'category' => $category, 'page' => 1]) }}">
                                <div class="cute-paginate-box__text">1</div>
                            </a>
                            <div class="paginate-dots">
                                <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                            </div>
                        @endif
                        
                        @foreach($pagination as $pageNum)
                            <a class="cute-paginate-box @if ($pageNum == $page) cute-paginate-box_active @endif" href="{{ route('results', ['search' => $search, 'category' => $category, 'page' => $pageNum]) }}">
                                <div class="cute-paginate-box__text">{{$pageNum}}</div>
                            </a>
                        @endforeach
                        
                        @if ( $pageCount > 5 && ($pageCount - $page) > 2  )
                            <div class="paginate-dots">
                                <div class="cute-paginate-box__symbol material-symbols-rounded">more_horiz</div>
                            </div>
                            <a class="cute-paginate-box" href="{{ route('results', ['search' => $search, 'category' => $category, 'page' => $pageCount]) }}">
                                <div class="cute-paginate-box__text">{{$pageCount}}</div>
                            </a>
                        @endif
                @endif
            </div>
        @else
            <span class="instruction-list_count">По вашему запросу ничего не найдено</span>
        @endif
    </div>

    <script src="/public/js/select.js"></script>
    <script src="/public/js/search.js"></script>
@endsection