@extends("body")

@php
    $currentUrl = explode("?",Request::url())[0];

    $adminPanelLinks = array(
        route('admin-instructions') => "Инструкции",
        route('admin-users') => "Пользователи",
        route('admin-complaints') => "Жалобы",
        route('admin-categories') => "Категории"
    );

    $filter = app('request')->input('filter');
@endphp

@section('title', 'Админ панель')

@section("content")
    <style>
        @media (max-width: 560px) {
            .body {
                padding: 0;
                padding-top: 50px;
            }
        }
    </style>
    
    <div class="admin-panel">
        <div class="admin-navigation">
            <ul class="admin-nav-list">
                @foreach($adminPanelLinks as $url => $title)
                    <li class="admin-nav-item">
                        <a 
                            class="admin-nav-link @if($currentUrl === $url) admin-nav-link_active @endif" href="{{ $url }}" >
                            {{ $title }}
                        </a>
                        @if($currentUrl === $url & isset($filterNav)) 
                            <ul class="filter-nav-list">
                                @php $key = 0; @endphp
                                @foreach($filterNav as $filterUrl => $filterTitle)
                                    @php $key++; @endphp
                                    <li class="admin-nav-item">
                                        <a 
                                            class="admin-nav-link @if($filter === $filterUrl || !$filter && $key == 1) admin-nav-link_active @endif" href="{{ url()->query($currentUrl, ['filter' => $filterUrl]) }}" >
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
