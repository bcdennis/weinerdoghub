@if (count($notifications) > 0)
    @include('site::notifications.partials.loop')
@else
    <p class="thats-all">
    {{ __('There are no more notifications!') }}
    </p>
@endif