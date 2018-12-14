@extends('site::app')

@section('js')
    @parent
    <script src="{{ assetTheme('assets/js/preview.js') }}"></script>
@stop

@section('title')
    {{ __('Settings') }} - @parent
@stop

@section('content')
    <div class="settings form-wrapper">
        <h2 class="form-title">{{ __('Settings') }}</h2>

        <form action="{{ route('account.settings') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group avatar-settings">
                <div>
                    <label for="avatar">{{ __('Avatar') }}</label>
                    <input @if($errors->has('avatar')) class="error" @endif type="file" name="avatar" id="avatar">
                    <a href="{{ route('account.settings.reset-avatar') }}" class="btn btn-text"
                       type="submit">{{ __('Use default') }}</a>
                    @if ($errors->has('avatar'))
                        <span class="error-text">{{ $errors->first('avatar') }}</span>
                    @endif
                </div>
                <div class="avatar-preview">
                    <img src="{{ avatar($user->avatar) }}" class="avatar" alt="Avatar Preview">
                </div>
            </div>

            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}">
                @if ($errors->has('name'))
                    <span class="error-text">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}">
                @if ($errors->has('email'))
                    <span class="error-text">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="newPassword">{{ __('Change Password') }}</label>
                <input type="password" name="password" id="newPassword" placeholder="{{ __('New Password') }}">
                @if ($errors->has('password'))
                    <span class="error-text">{{ $errors->first('password') }}</span>
                @endif

                <label for="repeatedPassword" class="sr-only">{{ __('Repeat the New Password') }}</label>
                <input type="password" name="password_confirmation" id="repeatedPassword"
                       placeholder="{{ __('Repeat the New Password') }}">
                @if ($errors->has('password_confirmation'))
                    <span class="error-text">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="set-lang">{{ __('Choose Language') }}</label>
                <select name="language" id="set-lang">
                    @foreach (languages() as $lang)
                        <option @if ($user->language == $lang) selected @endif value="{{ $lang }}">{{ $lang }}</option>
                    @endforeach
                </select>
                @if ($errors->has('language'))
                    <span class="error-text">{{ $errors->first('language') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="set-nsfw-access">{{ __('NSFW Posts') }}</label>
                <select name="nsfw" id="set-nsfw-access">
                    <option @if ($user->nsfw) selected @endif value="1">{{ __('I want to see them') }}</option>
                    <option @if (!$user->nsfw) selected @endif value="0">{{ __('I do NOT want to see them') }}</option>
                </select>
                @if ($errors->has('nsfw'))
                    <span class="error-text">{{ $errors->first('nsfw') }}</span>
                @endif
            </div>

            <div class="form-group form-actions">
                <a href="#" class="modal-trigger" data-target=".modal-settings">{{ __('Delete my account') }}</a>
                <button type="submit" class="btn btn-medium">{{ __('Save Changes') }}</button>
            </div>
        </form>
    </div> <!-- end of settings -->

    @include('site::modals.delete')
@stop