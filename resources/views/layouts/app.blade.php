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
    <div id="app">
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
        <main>
            @yield('content')
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
    </div>
</body>
</html>


