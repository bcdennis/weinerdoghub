@if (count($activities) > 0)
    @foreach ($activities as $activity)
        <article>
            @include('site::partials.post', ['post' => $activity->post])
        </article>
        <div class="divider"></div>
    @endforeach
@else
    <article class="db-message">
        <p>{{ __('No more posts from :name!', ['name' => $user->name]) }}
    </article>
@endif
