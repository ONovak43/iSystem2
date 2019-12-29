<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/helpers.css') }}" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <header class="d-flex flex-row">
        <div class="mr-auto">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-6 mr-auto p-0">
                        <a href="/"><img class="logo" src="/img/logo_HD.png" alt="KVD logo" /></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2 my-flex-item">
            <div class="container h-100">
                <div class="row align-items-center h-100 mr-2 mt-1">
                    <div class="col-sm-12">
                        @yield('room')
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="ml-2 mr-5 mt-5">
        <div class="row">
            <nav class="col-2 bg-light mr-5 pl-5 pt-4">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ action('Manager\RoomEventsController@index') }}">
                            <img src="/img/document.svg" class="ikonka-menu">
                            Rozvrhové akce
                        </a>
                    </li>
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ action('Manager\RoomsController@index') }}">
                                <img src="/img/briefcase.svg" class="ikonka-menu">
                                Místnosti
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ action('Manager\UsersController@index') }}">
                                <img src="/img/person.svg" class="ikonka-menu">
                                Uživatelé
                            </a>
                        </li>
                    @endif
                    <li>
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            <img src="/img/account-logout.svg" class="ikonka-menu">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>

                </ul>
            </nav>
            <div class="col-9">
                @yield('content')
            </div>
        </div>
    </main>
    <footer>
        <nav class="container">
            <div class="row">
                <a class="col-md-3 col-sm-12" href="https://portal.zcu.cz/portal/studium/prohlizeni.html" target="_blank">ZČU Portál - Prohlížení</a>
                <a class="col-md-3 col-sm-12" href="https://courseware.zcu.cz" target="_blank">ZČU Portál - Courseware</a>
                <a class="col-md-3 col-sm-12" href="https://portal.zcu.cz/portal/studium/moje-studium" target="_blank">ZČU Portál - Moje výuka</a>
                <a class="col-md-3 col-sm-12" href="https://www.kvd.zcu.cz/cz/" target="_blank">Katedra výpočetní a didaktické techniky</a>
            </div>
        </nav>
    </footer>
</body>
</html>



