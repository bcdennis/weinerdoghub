@if (setting('auth.google.client_id') || setting('auth.facebook.client_id'))
    <div class="alternative">
        <span class="alternative-text">- {{ __('or') }} -</span>
        <div class="alternative-wrap @if ( ! setting('auth.google.client_id') || ! setting('auth.facebook.client_id')) one-alternative @endif">
            @if (setting('auth.facebook.client_id'))
                <a class="btn-log-fb" href="{{ route('auth.provider', 'facebook') }}">
                    <span class="icon-wrap"><span class="icon"></span></span>
                    <span class="text">Facebook</span>
                </a>
            @endif
            @if (setting('auth.google.client_id'))
                <a class="btn-log-gp" href="{{ route('auth.provider', 'google') }}">
                    <span class="icon-wrap"><span class="icon"></span></span>
                    <span class="text">Google</span>
                </a>
            @endif
        </div>
    </div>
@endif
