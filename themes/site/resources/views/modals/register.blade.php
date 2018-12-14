<div class="modal modal-sign-up">
    <button class="modal-close"><span>x</span></button>
    <img src="{{ setting('logo') ? media(setting('logo')) : assetTheme('assets/img/logo.png') }}" class="modal-logo"
         alt="Smile Logo">
    <form action="{{ route('register') }}" method="post" id="register-form">
        <div class="form-group general"></div>
        <div class="form-group name">
            <label for="register-name" class="sr-only">{{ __('Name') }}</label>
            <input type="text" name="name" placeholder="{{ __('Name') }}" id="register-name">
        </div>
        <div class="form-group email">
            <label for="register-email" class="sr-only">{{ __('Email') }}</label>
            <input type="email" name="email" placeholder="{{ __('Email') }}" id="register-email">
        </div>
        <div class="form-group password">
            <label for="register-password" class="sr-only">{{ __('Password') }}</label>
            <input type="password" name="password" placeholder="{{ __('Password') }}" id="register-password">
        </div>
        @if (setting('captcha.secret'))
            <div class="form-group">
                {!! app('captcha')->display() !!}
            </div>
        @endif
        <button class="btn btn-login" type="submit">{{ __('Sign Up') }}</button>
    </form>
    @widget('modal.register.alternative')
    <div class="meta-information">
        <p>
            {{ __('By signing up, you agree to our') }}
            <a href="{{ route('terms') }}">{{ __('terms of use') }}</a>
            {{ __('and') }} <a href="{{ route('privacy') }}">{{ __('privacy policy.') }}</a>
        </p>
    </div>
</div> <!-- end of modal-sign-up -->