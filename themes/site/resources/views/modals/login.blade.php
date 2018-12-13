<div class="modal modal-log-in">
    <button class="modal-close"><span>x</span></button>
    <img src="{{ setting('logo') ? media(setting('logo')) : assetTheme('assets/img/logo.png') }}" class="modal-logo" alt="Smile Logo">
    <form action="{{ route('auth') }}" method="post" id="login-form">
        <span id="login-general-text" class="error-text error-hide">
        </span>
        <div class="form-group general">
        </div>
        <div class="form-group email">
            <label for="login-email" class="sr-only">{{ __('Email') }}</label>
            <input type="email" name="email" placeholder="{{ __('Email') }}" id="login-email">
        </div>
        <div class="form-group password">
            <label for="login-password" class="sr-only">{{ __('Password') }}</label>
            <input type="password" name="password" placeholder="{{ __('Password') }}" id="login-password">
        </div>

        <button class="btn btn-login" name="submit" type="submit">{{ __('Log In') }}</button>
    </form>
    @widget('modal.login.alternative')
    <div class="meta-information">
        <p class="new-account">
            {{ __('Not got an account yet?') }}
            <a href="#" class="inside-modal-trigger" data-target=".modal-sign-up">{{ __('Sign Up now :)') }}</a>
        </p>
        <a href="{{ url('/password/email') }}" class="forgot-password-link">{{ __('Forgot Password?') }}</a>
    </div>
</div>