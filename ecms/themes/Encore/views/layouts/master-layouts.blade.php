<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <title> @yield('title') | Super - Control de pasajeros y Vehículos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Control de pasajeros y Vehículos" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="{{ Theme::url('images/favicon.ico') }}">
        @include('layouts.head-css')
    </head>

<body data-layout="vertical" data-sidebar="dark">
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        @include('layouts.horizontal')

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
                @include('layouts.footer')
            </div>
        </div>
        @include('layouts.right-sidebar')
        @include('layouts.vendor-scripts')
    </body>
</html>
