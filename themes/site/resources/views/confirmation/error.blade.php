@extends('site::app')

@section('title')
    {{ __('Confirmation') }} - @parent
@stop

@section('content')
    <div class="confirm-account small-wrapper">
        <h2>{{ __('Confirmation error!') }}</h2>
        <p>
            {{ __('confirmation.error') }}
        </p>
    </div>
@stop