@if (count($activities) > 0)
    @foreach ($activities as $activity)
        <article>
            @include('site::partials.post', ['post' => $activity->post])
        </article>
        <div class="divider"></div>
    @endforeach
@else
    <article class="db-message">
        <p>{{ __(':name has no more smiles to give :(', ['name' => $user->name]) }}!</p>
    </article>
@endif
