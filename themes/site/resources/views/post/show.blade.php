@extends('site::app')

@section('title')
    {{ $post->title }} - @parent
@stop

@section('seo')
    @parent
    <!-- Google -->
    <meta itemprop="name" content="{{ $post->title }}">
    <meta itemprop="description" content="{{ $post->title }}">
    <meta itemprop="image" content="{{ media($post->thumbnail) }}">
    <!-- Facebook -->
    <meta property="og:title" content="{{ $post->title }}" />
    <meta property="og:description" content="{{ $post->title }}" />
    <meta property="og:url" content="{{ URL::current() }}" />
    <meta property="og:image" content="{{ media($post->thumbnail ?: $post->featured) }}" />
    <meta property="og:type" content="article" />
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $post->title }}" />
    <meta name="twitter:description" content="{{ $post->title }}" />
    <meta name="twitter:image:src" content="{{ media($post->thumbnail ?: $post->featured) }}" />
    <meta name="author" content="{{ $post->user->name }}">
@stop

@section('content')
    <div class="post">
        <article>
            <h2 class="post-title">{{ $post->title }}</h2>
            <div class="post-meta">
                <p>
                    <span class="smiles-number-{{ $post->id }}">{{ formatNumber($post->points) }}</span>
                    <span class="text-accent">{{ __choice('smiles', $post->points) }}</span> {{ __choice('points', $post->points) }}
                </p>
                <span class="divide-meta">.</span>
                <p>{{ formatNumber($post->views) }} <span class="text-accent">{{ __choice('views', $post->views) }}</span></p>
            </div>

            @if ( ! $post->safe && ( ! auth()->check() || ! auth()->user()->nsfw))
                @include('site::partials.post.nsfw', ['isBig' => true])
            @else
                @include('site::partials.post.'.$post->type, ['isBig' => true])
            @endif

            <div class="post-description">
                {!! parseDescription($post->description) !!}
            </div>

            @if ($post->type == 'list')
                </article>

                @foreach ($post->items as $pos => $item)
                    <article>
                        <div class="list-item-heading">
                            <span class="item-counter">{{ $pos + 1 }}</span>
                            <h2 class="item-title">{{ $item->title }}</h2>
                        </div>
                        <div class="post-wrapper">
                            @if ( ! $post->safe && ( ! auth()->check() || ! auth()->user()->nsfw))
                                @include('site::partials.post.nsfw', ['post' => $item, 'isBig' => true])
                            @else
                                @include('site::partials.post.'.$item->type, ['post' => $item, 'isBig' => true])
                            @endif
                            <div class="post-description">
                                {!! parseDescription($item->description) !!}
                            </div>
                        </div>
                    </article>
                    @if ($pos + 1 < count($post->items))
                        <div class="divider"></div>
                    @endif
                @endforeach
                <article>
            @endif

            <div class="user-actions">
                <div class="vote">
                    {!! voteButton($post, 'like', auth()->user()) !!}
                    <div class="divider"></div>
                    {!! voteButton($post, 'dislike', auth()->user()) !!}
                </div>
                <div class="spread">
                    @include('site::partials.share', ['post' => $post])
                    @if ($next)
                        <div class="divider"></div>
                        <a href="{{ route('post', $next->slug) }}" class="btn btn-medium">
                            {{ __('Next Post') }} >
                        </a>
                    @endif
                </div>
            </div>
        </article>

        @widget('post.after')

        <div class="author">
            <a href="{{ route('profile.overview', $post->user->name) }}">
                {{ __('by') }} {{ $post->user->name }}
            </a>
            <div class="divider"></div>
            <a href="#" class="modal-trigger" data-target=".modal-report-post">{{ __('report') }}</a>
        </div>
        <div class="divider"></div>
    </div> <!-- end of post -->

    <div id="comments" class="comments-wrapper main-comment">
        @if (setting('comments.local.on') || setting('comments.facebook.on') || setting('comments.disqus.on'))
            @include('site::comments.tabs')
        @endif
    </div>
    <div class="modal modal-report-post">
        <button class="modal-close"><span>x</span></button>
        <h2>{{ __('Report Post :)') }}</h2>
        <form action="{{ route('posts.report', $post->id) }}" method="post" id="report-post-form">
            <div class="form-group">
                <label>
                    <input type="radio" name="reason" value="Contains a trademark or copyright violation">
                    {{ __('Contains a trademark or copyright violation') }}
                </label>
            </div>
            <div class="form-group">
                <label>
                    <input type="radio" name="reason" value="Spam, blatant advertising, or solicitation">
                    {{ __('Spam, blatant advertising, or solicitation') }}
                </label>
            </div>
            <div class="form-group">
                <label>
                    <input type="radio" name="reason" value="Contains offensive materials/nudity">
                    {{ __('Contains offensive materials/nudity') }}
                </label>
            </div>
            <div class="form-group">
                <label>
                    <input type="radio" name="reason" value="Repost of another post on Smile">
                    {{ __('Repost of another post on Smile') }}
                </label>
            </div>
            <button type="button" data-redirect="{{ route('post', $post->slug) }}" class="btn btn-full-width submit-report">
                {{ title(__('report')) }}
            </button>
        </form>
    </div> <!-- end of modal-report-post -->
@stop
