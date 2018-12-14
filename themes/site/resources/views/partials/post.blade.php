<h2 class="post-title">
    <a href="{{ route('post', $post->slug) }}" target="_blank">
        {{ $post->title }}
    </a>
</h2>
<div class="post-meta">
    <p>
        <span class="smiles-number-{{ $post->id }}">{{ formatNumber($post->points) }}</span>
        <span class="text-accent">{{ __('smile') }}</span> {{ __choice('points', $post->points) }}
    </p>
    <span class="divide-meta">.</span>
    <p>{{ formatNumber($post->views) }} <span class="text-accent">{{ __choice('views', $post->views) }}</span></p>
</div>

@if (auth()->check() && $post->user_id == auth()->user()->id && Route::currentRouteName() == 'profile.posts')
    <div class="post-actions">
        <button type="button" class="btn-edit-post modal-trigger" data-edit="{{ route('posts.edit', $post->id) }}"
                data-info="{{ route('posts.info', $post->id) }}" data-id="{{ $post->id }}"
                data-target=".modal-edit-post"></button>
        <form action="{{ route('posts.delete', $post->id) }}" method="post">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="_method" value="delete">
            <button type="submit" class="btn-delete-post"></button>
        </form>
    </div>
@endif

@if ( ! $post->safe && ( ! auth()->check() || ! auth()->user()->nsfw))
    @include('site::partials.post.nsfw')
@else
    @include('site::partials.post.'.$post->type)
@endif

<div class="user-actions">
    <div class="vote">
        {!! voteButton($post, 'like', auth()->user()) !!}
        <div class="divider"></div>
        {!! voteButton($post, 'dislike', auth()->user()) !!}
    </div>
    <div class="spread">
        @include('site::partials.share', ['post' => $post])
        <button class="share" type="button">{{ __('Share') }}</button>
        <div class="divider"></div>
        <a target="_blank" href="{{ route('post', $post->slug) }}#comments" class="comment">
            {{ formatNumber($post->comments) }}
        </a>
    </div>
</div>