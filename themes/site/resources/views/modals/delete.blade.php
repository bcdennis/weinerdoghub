<div class="modal modal-settings">
    <button class="modal-close"><span>x</span></button>
    <img src="{{ setting('logo') ? media(setting('logo')) : assetTheme('assets/img/logo.png') }}" class="modal-logo" alt="Smile Logo">
    <form action="{{ route('account.delete') }}" method="post" id="delete-account-form">
        <label for="passwordForDelete" class="sr-only">{{ __('Type in your password to confirm:') }}</label>
        <input type="password" name="password" id="passwordForDelete" placeholder="{{ __('Password For Confirmation') }}">
        <button class="btn btn-full-width" type="submit">{{ __('Delete my account') }}</button>
    </form>
    <p>
        {{ __('Sorry Message') }}
    </p>
</div> <!-- end of modal-settings -->