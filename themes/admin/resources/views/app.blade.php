
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Bitempest | bitempest.com">

    <link rel="apple-touch-icon" sizes="57x57" href="{{ adminTheme('assets/img/favicon/apple-touch-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ adminTheme('assets/img/favicon/apple-touch-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ adminTheme('assets/img/favicon/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ adminTheme('assets/img/favicon/apple-touch-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ adminTheme('assets/img/favicon/apple-touch-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ adminTheme('assets/img/favicon/apple-touch-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ adminTheme('assets/img/favicon/apple-touch-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ adminTheme('assets/img/favicon/apple-touch-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ adminTheme('assets/img/favicon/apple-touch-icon-180x180.png') }}">
    <link rel="icon" type="image/png" href="{{ adminTheme('assets/img/favicon/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ adminTheme('assets/img/favicon/favicon-194x194.png') }}" sizes="194x194">
    <link rel="icon" type="image/png" href="{{ adminTheme('assets/img/favicon/favicon-96x96.png') }}" sizes="96x96">
    <link rel="icon" type="image/png" href="{{ adminTheme('assets/img/favicon/android-chrome-192x192.png') }}" sizes="192x192">
    <link rel="icon" type="image/png" href="{{ adminTheme('assets/img/favicon/favicon-16x16.png') }}" sizes="16x16">
    <link rel="manifest" href="{{ adminTheme('assets/img/favicon/manifest.json') }}">
    <meta name="apple-mobile-web-app-title" content="Smile">
    <meta name="application-name" content="Smile">
    <meta name="msapplication-TileColor" content="#fdfdfd">
    <meta name="msapplication-TileImage" content="{{ adminTheme('assets/img/favicon/mstile-144x144.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smile Admin</title>
    @section('css')
        <link href="{{ adminTheme('assets/css/main.css') }}" rel="stylesheet">
    @show
</head>

<body>
    <div class="primary-navigation border-bottom">
        <nav class="navbar">
            <div class="navbar-header">
                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <i class="fa fa-reorder"></i>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
                    <img src="{{ adminTheme('assets/img/logo-v2.png') }}" alt="Smile Logo">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li {!! adminSetActive('dashboard') !!}>
                        <a href="{{ route('admin.dashboard') }}">Dasboard</a>
                    </li>
                    <li {!! adminSetActive('users') !!}>
                        <a href="{{ route('admin.users') }}">Users</a>
                    </li>
                    <li {!! adminSetActive('categories') !!}>
                        <a href="{{ route('admin.categories') }}">Categories</a>
                    </li>
                    <li {!! adminSetActive('posts') !!}>
                        <a href="{{ route('admin.posts') }}">Posts</a>
                    </li>
                    <li {!! adminSetActive('reports.posts|reports.comments') !!}>
                        <a href="{{ route('admin.reports.posts') }}">Reports</a>
                    </li>
                    <li {!! adminSetActive('settings.*') !!}>
                        <a href="{{ route('admin.settings.appearance') }}">Settings</a>
                    </li>
                    <li {!! adminSetActive('extensions|extensions.*') !!}>
                        <a href="{{ route('admin.extensions') }}">Extensions</a>
                    </li>
                    <li {!! adminSetActive('license', 'license-link') !!}>
                        @if ( ! app('Smile\Core\Updater\Manager')->validate())
                            <span class="badge badge-danger">!</span>
                        @endif
                        <a href="{{ route('admin.license') }}">License</a>
                    </li>
                </ul>
                <ul class="nav navbar-right">
                    <li class="site-status">
                        <span>site is: </span>
                        <form action="#" class="site-on-off" role="form">
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" class="onoffswitch-checkbox" id="maintenance" @if(app()->isDownForMaintenance()) checked @endif data-url="{{ route('admin.settings.restrictions.maintenance') }}">
                                    <label class="onoffswitch-label" for="maintenance">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </li>
                    <li>
                        <form action="{{ route('admin.logout') }}" method="post">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <button type="submit">
                                <i class="fa fa-sign-out"></i> <span>Log out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div> <!-- end of row -->

    @yield('content')
<div class="footer">
    <p class="text-center">Smile :) &copy; 2015</p>
</div> <!-- end of footer -->

<!-- Mainly scripts -->
@section('js')
<script src="{{ adminTheme('assets/js/libs.js') }}"></script>
<script src="{{ adminTheme('assets/js/services.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@show
</body>
</html>
