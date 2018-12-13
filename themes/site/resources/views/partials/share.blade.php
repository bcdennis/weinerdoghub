<ul class="share-options">
    @widget('share.before')
    <li>
        <a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u={{ route('post', $post->slug) }}&amp;title={{ $post->title }}" class="share-fb-icon share-btn"></a>
    </li>
    <li>
        <a target="_blank" href="http://twitter.com/intent/tweet?status={{ $post->title .'+'.route('post', $post->slug) }}" class="share-tw-icon share-btn"></a>
    </li>
    <li>
        <a target="_blank" href="https://plus.google.com/share?url={{ route('post', $post->slug) }}" class="share-gp-icon share-btn"></a>
    </li>
    @widget('share.after')
</ul>