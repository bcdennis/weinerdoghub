<div class="post-wrapper">
    @if( ! isset($isBig))
        <a target="_blank" href="{{ route('post', $post->slug) }}">
            <img src="{{ media(isset($isBig) ? $post->media : $post->thumbnail) }}" alt="Post Image">
        </a>
        @if ($post->resized)
            <a href="{{ route('post', $post->slug) }}" target="_blank" class="see-all">
                <span class="expand-icon"></span>
                {{ __('View Full Post') }}
            </a>
        @endif
    @endif
</div>