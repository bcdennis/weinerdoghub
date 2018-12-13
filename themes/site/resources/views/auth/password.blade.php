@extends('site::app')

@section('content')
    <div class="forgot-password form-wrapper">
        <h2 class="form-title">{{ __('Password Recovery') }}</h2>
        <span class="form-subtitle">{{ __('Fill in the form below and you will receive an email with instructions.') }}</span>

        <form method="POST" action="{{ url('/password/email') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input type="email" @if ($errors->has('email')) class="error" @endif name="email" id="email"  value="{{ old('email') }}" placeholder="name@email.com">
                @if ($errors->has('email'))
                    <span class="error-text">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
            <div class="form-group form-actions">
                <button type="submit" class="btn btn-medium">{{ __('Send') }}</button>
            </div>
        </form>
        @if (session('status'))
            <p class="send-password-notification">
                {{ __('Password instructions were sent to your email address!') }}
            </p>
        @endif
    </div> <!-- end of forgot-password -->
@endsection