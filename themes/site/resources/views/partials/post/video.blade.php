<div class="post-wrapper has-video gif">
    <video preload="auto" poster="{{ media($post->thumbnail) }}" loop muted>
        <source src="{{ media(str_replace('jpeg', 'webm', $post->media)) }}" type="video/webm">
        <source src="{{ media(str_replace('jpeg', 'mp4', $post->media)) }}" type="video/mp4">
    </video>
</div>