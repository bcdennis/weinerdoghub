<!DOCTYPE html>
<!--[if IE 9]><html lang="en" class="lte-ie9"><![endif]-->
<!--[if gt IE 9]><html lang="en" class="lte-ie9"><![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @section('seo')
        <meta name="description" content="{{ setting('branding.description') }}">
        <meta name="keywords" content="{{ setting('branding.keywords') }}">
        <meta property="og:site_name" content="{{ setting('branding.title') }}"/>
    @show

    @if (setting('favicon'))
        <link rel="icon" href="{{ media(setting('favicon')) }}">
    @else
        <link rel="apple-touch-icon" sizes="57x57" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ assetTheme('assets/img/favicon/apple-touch-icon-180x180.png') }}">
        <link rel="icon" type="image/png" href="{{ assetTheme('assets/img/favicon/favicon-32x32.png') }}" sizes="32x32">
        <link rel="icon" type="image/png" href="{{ assetTheme('assets/img/favicon/favicon-194x194.png') }}" sizes="194x194">
        <link rel="icon" type="image/png" href="{{ assetTheme('assets/img/favicon/favicon-96x96.png') }}" sizes="96x96">
        <link rel="icon" type="image/png" href="{{ assetTheme('assets/img/favicon/android-chrome-192x192.png') }}" sizes="192x192">
        <link rel="icon" type="image/png" href="{{ assetTheme('assets/img/favicon/favicon-16x16.png') }}" sizes="16x16">
        <link rel="manifest" href="{{ assetTheme('assets/img/favicon/manifest.json') }}">
    @endif
    <meta name="apple-mobile-web-app-title" content="Smile">
    <meta name="application-name" content="Smile">
    <meta name="msapplication-TileColor" content="#fdfdfd">
    <meta name="msapplication-TileImage" content="{{ assetTheme('assets/img/favicon/mstile-144x144.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="root" content="{{ route('home') }}">
    <meta name="lang.cancel" content="{{ __('Cancel') }}">
    @widget('meta-section')
    <title>
    @section('title')
        {{ setting('branding.title') }}
    @show
    </title>
    <link rel="stylesheet" href="{{ assetTheme('assets/css/main.css') }}">
    @widget('css-section')
</head>
<body>
<!-- [if lt IE 9]
<div class="legacy-ie">
    <p>
        <strong>Unsupported browser!</strong> This site was designed for modern browsers and tested with Internet Explorer version 9 and later. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
    </p>
</div>
<![endif] -->
<header class="page-header">
    <div class="logo">
        <a href="{{ route('home') }}">
            <img src="{{ setting('mobile-logo') ? media(setting('mobile-logo')) : assetTheme('assets/img/logo-mobile.png') }}" alt="Smile Logo">
        </a>
    </div>
    <div class="header-actions">
        @if (auth()->check())
            <a href="{{ route('notifications') }}" class="notifications">
                <img src="{{ assetTheme('assets/img/mobile-notifications.png') }}" alt="notifications">
                @if ($unread > 0)
                    <span class="badge">{{ $unread }}</span>
                @endif
            </a>
            <a href="#" class="btn-upload btn-upload-ways">+</a>
            @include('site::upload.ways-logged-in')
        @else
            <a href="#" class="btn-upload btn-upload-ways">+</a>
            @include('site::upload.ways-logged-out')
        @endif
    </div>
</header>

<div class="container">
    <aside class="col-1"> <!-- left sidebar -->
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ setting('logo') ? media(setting('logo')) : assetTheme('assets/img/logo.png') }}" alt="Smile Logo">
            </a>
        </div>
        @if (auth()->user())
        <div class="logged-in">
            <img src="{{ avatar(auth()->user()->avatar) }}" alt="User Avatar">
            <span class="user-name">{{ auth()->user()->name }}</span>
        </div>
        @endif
        <nav class="global-navigation">
            <ul>
                @widget('left-sidebar.before')

                <li {!! setActive('home') !!}>
                    <a href="{{ route('home') }}">{{ lower(__('Home')) }}</a>
                </li>
                @if (auth()->user())
                    <li {!!  setActive('profile.overview') !!}>
                        <a href="{{ route('profile.overview', auth()->user()->name) }}">{{ lower(__('Profile')) }}</a>
                    </li>
                    <li {!! setActive('account.settings') !!}>
                        <a href="{{ route('account.settings') }}">{{ lower(__('Settings')) }}</a>
                    </li>
                @endif
                @if (canContact())
                    <li {!!  setActive('contact') !!}>
                        <a href="{{ route('contact') }}">{{ lower(__('Contact Us')) }}</a>
                    </li>
                @endif
                <li {!! setActive('about') !!}>
                    <a href="{{ route('about') }}">{{ lower(__('About Us')) }}</a>
                </li>
                @if ( ! auth()->check())
                    <li><a href="#" class="modal-trigger" data-target=".modal-sign-up">{{ lower(__('Sign Up')) }}</a></li>
                    <li><a href="#" class="modal-trigger" data-target=".modal-log-in">{{ lower(__('Log In')) }}</a></li>
                @else
                    <li><a href="{{ route('logout') }}">{{ lower(__('Log out')) }}</a></li>
                @endif

                @widget('left-sidebar.after')
            </ul>
        </nav>
    </aside> <!-- end left sidebar -->

    <div class="main-content col-2">
        <header class="menu">
            <a href="{{ route('home') }}" class="fixed-logo">
                <img src="{{ setting('mobile-logo') ? media(setting('mobile-logo')) : assetTheme('assets/img/logo-mobile.png') }}" alt="Mobile Logo">
            </a>
            <nav class="menu-items">
                <ul>
                    @foreach ($categories as $pos => $category)
                        @if ($pos < 4)
                        <li @if (activeCategory($category, $pos)) class="active" @endif>
                            <a href="{{ route('home', $category->slug) }}">
                                {{ $category->title }}
                            </a>
                        </li>
                        @endif
                    @endforeach
                    @if ($categories->count() > 4)
                        <li>
                            <a href="#" class="btn-more-categories">{{ title(__('more')) }} <span class="caret"></span></a>
                        </li>
                    @endif
                    <li><a href="#" class="btn-more-popular">{{ __('Popular') }} <span class="caret"></span></a></li>
                </ul>
                <ul class="more-menu-items hide dropdown">
                    @foreach ($categories as $pos => $category)
                        @if ($pos > 3)
                        <li>
                            <a href="{{ route('home', $category->slug) }}">
                                {{ $category->title }}
                            </a>
                        </li>
                        @endif
                    @endforeach
                </ul>
                <ul class="popular-menu-items dropdown hide">
                    <li><a href="{{ route('top.weekly') }}">{{ __('This week') }}</a></li>
                    <li><a href="{{ route('top.monthly') }}">{{ __('This month') }}</a></li>
                    <li><a href="{{ route('top.yearly') }}">{{ __('This year') }}</a></li>
                </ul>
            </nav>
            <div class="user-functions">
                <button type="button" class="btn-trigger-search">{{ __('Search') }}</button>
                <form action="{{ route('search') }}" id="main-search">
                    <label for="search" class="sr-only">{{ __('Search') }}</label>
                    <input type="search" name="q" placeholder="{{ __('search') }}...">
                </form>
                @if (auth()->check())
                    @include('site::notifications.dropdown')
                @endif
                <a href="{{ route('random') }}" class="btn-random-post">{{ __('random post') }}</a>
                <span class="tooltip tooltip-bottom get-random-tooltip">{{ __('random post') }}</span>
                @if (auth()->check())
                    <button class="btn btn-small btn-upload-ways">{{ __('Upload') }}</button>
                    @include('site::upload.ways-logged-in')
                @else
                    <button class="btn btn-small btn-upload-ways">{{ __('Upload') }}</button>
                    @include('site::upload.ways-logged-out')
                @endif
            </div>
        </header> <!-- end of menu -->
        @yield('content')
    </div> <!-- end main-content -->

    <aside class="col-3"> <!-- right sidebar -->
        @if (setting('social.on', false))
            @include('site::partials.social')
        @endif
        @widget('right-sidebar.before')
        @include('site::partials.featured')
        @widget('right-sidebar.after')

        <div class="sidebar-footer">
            <nav>
                <ul>
                    @if (canContact())
                        <li><a href="{{ route('contact') }}">{{ __('Contact Us') }}</a></li>
                    @endif
                    <li><a href="{{ route('privacy') }}">{{ __('Privacy') }}</a></li>
                    <li><a href="{{ route('terms') }}">{{ __('Terms') }}</a></li>
                </ul>
            </nav>
            <p class="copyrights">{!! setting('branding.copyright') !!}</p>
        </div> <!-- end of sidebar-footer -->
    </aside> <!-- right sidebar -->

    <button class="btn-go-top"><span>^</span></button>
</div> <!-- end of container -->

<div class="mobile-menu">
    @if (auth()->check())
    <div class="mobile-logged-in">
        <div class="user-avatar">
            <img src="{{ avatar(auth()->user()->avatar) }}" alt="User Avatar">
        </div>
        <div class="user-meta">
            <span class="user-name">{{ auth()->user()->name }}</span>
            <span class="user-record">
                {{ auth()->user()->points }} <span class="text-accent">{{ __choice('smiles', auth()->user()->points) }}</span> {{ __choice('points generated', auth()->user()->points) }}
            </span>
        </div>
        <form action="#">
            <button type="submit"></button>
        </form>
    </div> <!-- end of mobile-logged-in -->
    @endif
    <nav>
        <ul>
            @widget('mobile-menu.before')
            <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
            @if ( ! auth()->check())
            <li><a href="#" class="modal-trigger" data-target=".modal-log-in">{{ __('Log In') }}</a></li>
            <li><a href="#" class="modal-trigger" data-target=".modal-sign-up">{{ __('Sign Up') }}</a></li>
            @endif
            @if (auth()->check())
                <li><a href="{{ route('profile.overview', auth()->user()->name) }}">{{ __('Profile') }}</a></li>
                <li><a href="{{ route('account.settings') }}">{{ __('Settings') }}</a></li>
            @endif
            @if (canContact())
                <li><a href="{{ route('contact') }}">{{ __('Contact Us') }}</a></li>
            @endif
            <li><a href="{{ route('about') }}">{{ __('About Us') }}</a></li>
            <li><a href="{{ route('privacy') }}">{{ __('Privacy') }}</a></li>
            <li><a href="{{ route('terms') }}">{{ __('Terms') }}</a></li>
            @if (auth()->check())
                <li><a href="{{ route('logout') }}">{{ __('Log out') }}</a></li>
            @endif
            @widget('mobile-menu.after')
        </ul>
    </nav>
    @if (setting('social.on'))
        <div class="mobile-social-media">
            <span>{{ __('Follow us on:') }}</span>
            <ul>
                @if (setting('social.facebook'))
                    <li>
                        <a href="{{ setting('social.facebook') }}">
                            <span class="mobile-facebook-icon"></span>
                        </a>
                    </li>
                @endif
                @if (setting('social.twitter'))
                    <li>
                        <a href="https://twitter.com/{{ setting('social.twitter.name') }}">
                            <span class="mobile-twitter-icon"></span>
                        </a>
                    </li>
                @endif
                @if (setting('social.google'))
                    <li>
                        <a href="{{ setting('social.google') }}">
                            <span class="mobile-gplus-icon"></span>
                        </a>
                    </li>
                @endif
            </ul>
        </div> <!-- end of social media -->
    @endif
    <p class="mobile-copyrights">{{ setting('branding.copyright') }}</p>
</div> <!-- end of mobile-menu -->
<div class="mobile-categories">
    <div class="mobile-search">
        <form action="{{ route('search') }}">
            <label for="search-mobile-categories" class="sr-only">{{ __('Search') }}</label>
            <input type="search" name="q" id="search-mobile-categories" placeholder="{{ __('search') }}">
        </form>
    </div> <!-- mobile search -->
    <span class="mobile-headline">{{ __('Categories') }}</span>
    <nav class="categories">
        <ul>
            <li><a href="{{ route('top.weekly') }}">{{ __('This week top') }}</a></li>
            <li><a href="{{ route('top.monthly') }}">{{ __('This month top') }}</a></li>
            <li><a href="{{ route('top.yearly') }}">{{ __('This year top') }}</a></li>
            @foreach ($categories as $pos => $category)
                @if ($pos >= 3)
                <li>
                    <a href="{{ route('home', $category->slug) }}">{{ $category->title }}</a>
                </li>
                @endif
            @endforeach
        </ul>
    </nav>
</div> <!-- end of mobile-categories -->
<footer class="page-footer">
    <nav class="mobile-nav">
        <ul>
            <li>
                <a href="#" class="btn-mobile-menu">
                    <span class="menu-icon"></span>
                    {{ __('menu') }}
                </a>
            </li>
            @foreach ($categories as $pos => $category)
                @if ($pos < 3)
                    <li>
                        <a href="{{ route('home', $category->slug) }}">
                            <img src="{{ $category->icon ? media($category->icon) : assetTheme('assets/img/categories/default.png') }}" class="category-icon" alt="Images Category">
                            {{ $category->title }}
                        </a>
                    </li>
                @endif
            @endforeach
            <li>
                <a href="#" class="btn-mobile-categories">
                    <span class="more-icon"></span>
                    {{ __('more') }}
                </a>
            </li>
        </ul>
    </nav>
</footer>

<!-- Modals -->
@include('site::modals.login')
@include('site::modals.register')
@include('site::modals.upload')

@section('js')
    <script src="{{ assetTheme('assets/vendors/js/libs.js') }}"></script>
    <script src="{{ assetTheme('assets/js/app.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @include('site::partials.social-scripts')

    @if (setting('analytics.code'))
        {!! setting('analytics.code')!!}
    @endif
    @widget('js-section')
@show
</body>
</html>
