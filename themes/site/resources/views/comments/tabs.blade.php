<ul class="comments-tabs">
    @if (setting('comments.local.on', true))
        <li id="tab1" class="tab1 active">
            <a href="#">
                {{ __('Site Comments') }} (<span>{{ $post->comments }}</span>)
            </a>
        </li>
    @endif
    @if (setting('comments.facebook.on'))
        <li id="tab2" class="tab2 @if ( ! setting('comments.local.on')) active @endif" onclick='FB.XFBML.parse();'>
            <a href="#" id="fbBtn">
                {{ __('Facebook Comments') }} (<span class="fb-comments-count"
                                                     data-href="{{ route('post', $post->slug) }}"
                                                     data-version="v2.3">0</span>)
            </a>
        </li>
    @endif
    @if (setting('comments.disqus.on'))
        <li id="tab3" class="tab3">
            <a href="#" id="disBtn">
                {{ __('Disqus Comments') }} (<span class="disqus-comment-count"
                                                   data-disqus-url="{{ route('post', $post->slug) }}">0</span>)
            </a>
        </li>
    @endif
</ul>
<div class="comments-tab-content">
    @if (setting('comments.local.on', true))
        <div class="tab1 active">
            @include('site::comments.providers.local')
        </div>
    @endif
    @if (setting('comments.facebook.on'))
        <div class="tab2">
            @include('site::comments.providers.facebook')
        </div>
    @endif
    @if (setting('comments.disqus.on'))
        <div class="tab3">
            @include('site::comments.providers.disqus')
        </div>
    @endif
</div>
