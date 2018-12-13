<!-- notifications -->
<button type="button" class="btn-notifications" data-url="{{ route('notifications.read') }}">
    {{ __('Notifications') }}
    @if ($unread > 0)
        <span class="badge badge-notifications">{{ $unread }}</span>
    @endif
</button>
<div class="notifications-dropdown dropdown">
    <h5 class="notifications-header">{{ __('Notifications') }} (<span>{{ $notifications->total() }}</span>)</h5>
    <ul class="notifications-list">
        @if ($notifications->count())
            @include('site::notifications.partials.loop')
        @else
            <p class="no-notifications">
                {{ __('You don\'t have any notifications yet.') }}
            </p>
        @endif
    </ul>
    <a href="{{ route('notifications') }}" class="notifications-footer">{{ __('see all') }}</a>
</div>
<!-- end of notifications -->