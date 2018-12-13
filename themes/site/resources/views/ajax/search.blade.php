@if (count($posts) > 0)
    @foreach ($posts as $post)
        <article>
            @include('site::partials.post', ['post' => $post])
        </article>
        <div class="divider"></div>
    @endforeach
@else
    <article class="db-message">
        <p>{{ __('That\'s all, we hope that your smile is larger than our database :)') }}</p>
    </article>
@endif