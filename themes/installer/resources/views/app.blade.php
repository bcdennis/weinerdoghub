<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Bitempest | bitempest.com">

    <link rel="apple-touch-icon" sizes="57x57" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-57x57.png', 'installer') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-60x60.png', 'installer') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-72x72.png', 'installer') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-76x76.png', 'installer') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-114x114.png', 'installer') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-120x120.png', 'installer') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-144x144.png', 'installer') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-152x152.png', 'installer') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-180x180.png', 'installer') }}">
    <link rel="icon" type="image/png" href="{{ assetTheme('assets/img/favicon/favicon-32x32.png', 'installer') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ assetTheme('assets/img/favicon/favicon-194x194.png', 'installer') }}" sizes="194x194">
    <link rel="icon" type="image/png" href="{{ assetTheme('assets/img/favicon/favicon-96x96.png', 'installer') }}" sizes="96x96">
    <link rel="icon" type="image/png" href="{{ assetTheme('assets/img/favicon/android-chrome-192x192.png', 'installer') }}" sizes="192x192">
    <link rel="icon" type="image/png" href="{{ assetTheme('assets/img/favicon/favicon-16x16.png', 'installer') }}" sizes="16x16">
    <link rel="manifest" href="{{ assetTheme('assets/img/favicon/manifest.json', 'installer') }}">
    <meta name="apple-mobile-web-app-title" content="Smile">
    <meta name="application-name" content="Smile">
    <meta name="msapplication-TileColor" content="#fdfdfd">
    <meta name="msapplication-TileImage" content="assets/img/favicon/mstile-144x144.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Smile Installer</title>

    <link href="{{ assetTheme('assets/css/bootstrap.min.css', 'installer') }}" rel="stylesheet">
    <link href="{{ assetTheme('assets/css/default-style.css', 'installer') }}" rel="stylesheet">
    <link href="{{ assetTheme('assets/css/smile-style.css', 'installer') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="m-b-lg"></div>
                <div class="steps-wizard">
                    @include('installer::partials.nav')
                    @yield('content')
                </div> <!-- end of steps-wizard -->
            </div> <!-- end of col-md-12 -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
    <footer>
        <p class="m-t">Smile :) by <a href="#" class="text-danger">Bitempest</a></p>
    </footer>
    <script src="{{ assetTheme('assets/js/jquery-2.1.4.min.js', 'installer') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>
</html>
