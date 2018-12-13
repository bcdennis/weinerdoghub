<div class="featured-posts">
    <h3>{{ __('Featured') }}</h3>
    @foreach ($featured as $post)
        <article>
            <div class="post-wrapper">
                <a href="{{ route('post', $post->slug) }}">
                    <img src="{{ media($post->featured) }}" alt="Post Image">
                    <div class="shadow"></div>
                    <span>{{ formatNumber($post->points) }} {{ __choice('smiles', $post->points) }} {{ __choice('points generated', $post->points) }}</span>
                </a>
            </div>
            <h4>
                <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
            </h4>
        </article>
    @endforeach
</div> <!-- end of featured posts -->
