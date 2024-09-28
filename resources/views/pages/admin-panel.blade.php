@extends("body")

@php
    $currentUrl = explode("?",Request::url())[0];

    $adminPanelLinks = array(
        route('admin-instructions') => "Инструкции",
        route('admin-users') => "Пользователи",
        route('admin-complaints') => "Жалобы"
    );

    $filter = app('request')->input('filter');
@endphp

@section("content")
    <div class="admin-panel">
        <div class="admin-navigation">
            <span class="admin-nav-title">Навигация</span>
            <ul>
                @foreach($adminPanelLinks as $url => $title)
                    <li>
                        <a 
                            class="admin-nav-item @if($currentUrl === $url) active @endif" href="{{ $url }}" >
                            {{ $title }}
                        </a>
                        @if($currentUrl === $url & isset($filterNav)) 
                            <ul class="filter-nav">
                                @php $key = 0; @endphp
                                @foreach($filterNav as $filterUrl => $filterTitle)
                                    @php $key++; @endphp
                                    <li>
                                        <a 
                                            class="admin-nav-item @if($filter === $filterUrl || !$filter && $key == 1) active @endif" href="{{ url()->query($currentUrl, ['filter' => $filterUrl]) }}" >
                                            {{ $filterTitle }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="admin-main">
            @yield("admin-content")
        </div>
    </div>
@endsection
