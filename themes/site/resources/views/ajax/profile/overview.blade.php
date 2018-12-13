@if (count($activities) > 0)
    @foreach ($activities as $activity)
        <article>
            <div class="activity">
                <span class="username">{{ $activity->user->name }}</span>
                @if ($activity->eventName == 'post.create')
                    {{ __('posted') }}
                @endif
                @if ($activity->eventName == 'post.vote.like')
                    {{ __('liked') }}
                @endif
                @if ($activity->eventName == 'post.vote.dislike')
                    {{ __('didn\'t like') }}
                @endif
                @if ($activity->eventName == 'post.comment')
                    {{ __('commented') }}
                @endif
            </div>
            @include('site::partials.post', ['post' => $activity->post])
        </article>
        <div class="divider"></div>
    @endforeach
@else
    <article class="db-message">
        <p>{{ __('No more activities from :name!', ['name' => $user->name]) }}</p>
    </article>
@endif
