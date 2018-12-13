@extends('site::app')

@section('title')
    {{ __('Contact Us') }} - @parent
@stop

@section('content')
<div class="contact form-wrapper">
    <h2 class="form-title">{{ __('Contact Us') }}</h2>
    <form action="{{ route('contact') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" @if ($errors->has('name')) class="error" @endif>
            @if ($errors->has('name'))
                <span class="error-text">
                    {{ $errors->first('name') }}
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input type="email" name="email" id="email" @if ($errors->has('email')) class="error" @endif>
            @if ($errors->has('email'))
                <span class="error-text">
                        {{ $errors->first('email') }}
                    </span>
            @endif
        </div>

        <div class="form-group">
            <label for="subject">{{ __('Subject') }}</label>
            <input type="text" name="subject" id="subject" @if ($errors->has('subject')) class="error" @endif>
            @if ($errors->has('subject'))
                <span class="error-text">
                    {{ $errors->first('subject') }}
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="text">{{ __('Message') }}</label>
            <textarea name="text" id="text" @if ($errors->has('text')) class="error" @endif></textarea>
            @if ($errors->has('text'))
                <span class="error-text">
                    {{ $errors->first('text') }}
                </span>
            @endif
        </div>
        <div class="form-group form-actions">
            @if (setting('captcha.secret'))
                {!! app('captcha')->display() !!}
            @endif
            <button type="submit" class="btn btn-medium">{{ __('Send') }}</button>
        </div>
    </form>
    @if (session('status'))
        <p class="send-password-notification">
            {{ __('Your email has been sent successfully!') }}
        </p>
    @endif
</div>
@stop