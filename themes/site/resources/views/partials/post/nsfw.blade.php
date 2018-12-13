<div class="post-wrapper">
    @if (auth()->check() && ! auth()->user()->nsfw)
        <a href="{{ route('post', $post->slug) }}" @if (!isset($isBig)) target="_blank" @endif>
    @else
        <a href="{{ route('post', $post->slug) }}" class="modal-trigger" data-target=".modal-log-in">
    @endif
        <img src="{{ assetTheme('assets/img/nsfw-bg.png') }}" alt="nsfw post">
        <div class="nsfw">
            <strong>{{ __('Not Safe For Work') }}</strong>
            <p>{{ __('Login to view this post.') }}</p>
        </div>
    </a>
</div>
