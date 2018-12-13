@extends('site::app')

@section('title')
    {{ __('Confirmation') }} - @parent
@stop

@section('content')
    <div class="confirm-account small-wrapper">
        <h2>{{ __('Confirm Your Account') }}</h2>
        <p>
            {{ __('Before start using smile, please confirm your account.') }}
        </p>
        <p>
            <strong>{{ __('Tip') }}</strong>: {{ __('check your email :)') }}
        </p>
    </div>
@stop