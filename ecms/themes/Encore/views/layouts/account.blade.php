<!DOCTYPE html>
<html lang="en" class="light-theme">
<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
            {{ Setting::get('core::site-name') }}
        @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="{{ asset('themes/adminlte/favicon.ico') }}">

    <!-- loader-->
    {!! Theme::style('css/pace.min.css?v='.config('app.version')) !!}
    {!! Theme::script('js/pace.min.js?v='.config('app.version')) !!}

    <!--plugins-->
    {!! Theme::style('plugins/simplebar/css/simplebar.css?v='.config('app.version')) !!}
    {!! Theme::style('plugins/perfect-scrollbar/css/perfect-scrollbar.css?v='.config('app.version')) !!}
    {!! Theme::style('plugins/metismenu/css/metisMenu.min.css?v='.config('app.version')) !!}

    <!-- CSS Files -->
    {!! Theme::style('css/bootstrap.min.css?v='.config('app.version')) !!}
    {!! Theme::style('css/bootstrap-extended.css?v='.config('app.version')) !!}
    {!! Theme::style('css/style.css?v='.config('app.version')) !!}
    {!! Theme::style('css/icons.css?v='.config('app.version')) !!}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

</head>
<body class="bg-white">

<!--start wrapper-->
<div class="wrapper">
    <div class="">
    @yield('content')
    </div>
</div>
<!--end wrapper-->

<!-- JS Files-->
{!! Theme::script('js/jquery.min.js?v='.config('app.version')) !!}
{!! Theme::script('plugins/simplebar/js/simplebar.min.js?v='.config('app.version')) !!}
{!! Theme::script('plugins/metismenu/js/metisMenu.min.js?v='.config('app.version')) !!}
{!! Theme::script('js/bootstrap.bundle.min.js?v='.config('app.version')) !!}
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

<!--plugins-->
{!! Theme::script('plugins/perfect-scrollbar/js/perfect-scrollbar.js?v='.config('app.version')) !!}
{!! Theme::script('plugins/chartjs/chart.min.js?v='.config('app.version')) !!}
{!! Theme::script('js/index.js?v='.config('app.version')) !!}

<!-- Main JS-->
{!! Theme::script('js/main.js?v='.config('app.version')) !!}

@yield('scripts')

@stack('js-stack')
</body>
</html>
