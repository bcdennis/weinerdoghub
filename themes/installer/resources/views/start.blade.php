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

    <title>Smile Installer</title>

    <link href="{{ assetTheme('assets/css/bootstrap.min.css', 'installer') }}" rel="stylesheet">
    <link href="{{ assetTheme('assets/css/default-style.css', 'installer') }}" rel="stylesheet">
    <link href="{{ assetTheme('assets/css/smile-style.css', 'installer') }}" rel="stylesheet">
</head>

<body>
<div class="middle-box text-center installer-screen">
    <div class="logo-wrapper">
        <img src="{{ assetTheme('assets/img/logo.png', 'installer') }}" alt="Logo">
        <small>installer</small>
    </div>
    <div class="installer-message">
        <h2 class="m-b-md">Welcome to Smile, your daily dose of joy</h2>
        <p>
            In order to install Smile on your own server please hit the install button and follow the steps. If you encounter problems please check the <a href="{{ assetTheme('#', 'installer') }}" class="text-danger">documentation</a>. If the problems persist don't hesitate to ask for <a href="{{ assetTheme('#', 'installer') }}" class="text-danger">support</a>.
        </p>
        <p>Thanks for your purchase ^_^</p>
    </div> <!-- end of welcome-message -->
    <form action="{{ route('home') }}/" method="post">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="m-b-sm text-left @if ($errors->has('license')) has-error @endif">
            <label for="license" class="label-regular">
                Before starting the installation process please type in your <strong>license</strong>:
            </label>
            <input type="text" name="license" id="license" class="form-control" placeholder="e.g: 3a7fg77vdG4F8fgh58HD330">
            @if ($errors->has('license'))
                <span class="text-error help-block">
                    Invalid license provided. If you don't have one, please buy it from <a target="_blank" href="http://codecanyon.net/item/smile-media-an-entertainment-viral-platform/12613909">here</a>!
                </span>
            @endif
        </div>
        <button type="submit" class="btn btn-danger">Install</button>
    </form>
</div> <!-- end of middle-box -->
<footer>
    <p class="m-t">Smile :) by <a href="http://bitempest.com" class="text-danger">Bitempest</a></p>
</footer>
</body>
</html>
