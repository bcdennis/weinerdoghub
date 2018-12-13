@extends('site::app')

@section('title')
    {{ __('Confirmation') }} - @parent
@stop

@section('content')
    <div class="confirm-account small-wrapper">
        <h2>{{ __('Your account has been confirmed!') }}</h2>
        <p>
            {{ __('confirmation.success') }}
        </p>
    </div>
@stop