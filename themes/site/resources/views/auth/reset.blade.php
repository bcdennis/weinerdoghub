@extends('site::app')

@section('content')
    <div class="forgot-password form-wrapper">
        <h2 class="form-title">{{ __('Password Recovery') }}</h2>
        <span class="form-subtitle">{{ __('Fill in the form below and you will have a new password.') }}</span>

        <form method="POST" action="{{ url('/password/reset') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input type="email" @if ($errors->has('email')) class="error" @endif name="email" id="email"  value="{{ old('email') }}" placeholder="name@email.com">
                @if ($errors->has('email'))
                    <span class="error-text">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" @if ($errors->has('password')) class="error" @endif name="password" id="password">
                @if ($errors->has('password'))
                    <span class="error-text">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="password_confirmation">{{ __('Confirm password') }}</label>
                <input type="password" @if ($errors->has('password_confirmation')) class="error" @endif name="password_confirmation" id="password_confirmation">
                @if ($errors->has('password_confirmation'))
                    <span class="error-text">
                        {{ $errors->first('password_confirmation') }}
                    </span>
                @endif
            </div>
            <div class="form-group form-actions">
                <button type="submit" class="btn btn-medium">{{ __('Reset password') }}</button>
            </div>
        </form>
    </div> <!-- end of forgot-password -->
@endsection