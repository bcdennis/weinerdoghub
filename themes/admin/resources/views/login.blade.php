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
    <title>Smile Admin | Login</title>
    <link href="{{ adminTheme('assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="gray-bg">
<div class="middle-box text-center loginscreen">
    <div>
        <div class="logo-wrapper">
            <img src="{{ adminTheme('assets/img/logo.png') }}" alt="">
            <small>admin panel</small>
        </div>
        <form class="m-t-xl" role="form" method="post" action="{{ route('admin.login') }}">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            @if ($errors->has('general'))
                <span class="text-danger help-block">
                    {{ $errors->first('general') }}
                </span>
            @endif
            <div class="form-group @if ($errors->has('email')) has-error @endif">
                <input type="email" class="form-control" name="email" placeholder="Email" required="">
                @if ($errors->has('email'))
                    <span class="help-block">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group @if ($errors->has('password')) has-error @endif">
                <input type="password" class="form-control" name="password" placeholder="Password" required="">
                @if ($errors->has('password'))
                    <span class="help-block">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-danger block full-width m-b">Login</button>
        </form>
        <p class="m-t"> <small>Smile :) &copy; 2015</small> </p>
    </div>
</div>
<script src="{{ adminTheme('assets/js/libs.js') }}"></script>
</body>
</html>
