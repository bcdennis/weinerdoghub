<!DOCTYPE html>
<!--[if IE 9]><html lang="en" class="lte-ie9"><![endif]-->
<!--[if gt IE 9]><html lang="en" class="lte-ie9"><![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @section('seo')
        <meta name="description" content="{{ setting('branding.description') }}">
        <meta name="keywords" content="{{ setting('branding.keywords') }}">
    @show
    <meta name="author" content="Bitempest | bitempest.com">

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

    <title>
        @section('title')
            {{ setting('branding.title') }}
        @show
    </title>

    <link rel="stylesheet" href="{{ assetTheme('assets/css/main.css') }}">
</head>
<body>
<div class="container page-center">
    <div class="wrapper-center">
        <img src="{{ assetTheme('assets/img/404.png') }}" alt="page doesn't exist">
        <p>
            {{ __('The page you were looking for appears to have been moved, deleted or does not exist.') }}
            {{ __('You could') }}
            @if (URL::previous())
            {{ __('go back to') }} <a href="{{ URL::previous() }}">{{ __('where you were') }}</a> {{ __('or') }}
            @endif
            {{ __('head straight to our') }} <a href="{{ route('home') }}">{{ __('home page') }}</a>.
        </p>
        <form action="{{ route('search') }}" method="get">
            <div class="form-group">
                <label for="search" class="sr-only">{{ __('Or search for something else') }}</label>
                <input type="search" name="q" id="search" placeholder="{{ __('Search') }}...">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-medium">{{ __('Search') }}</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
