<h3><span class="total-comments">{{ formatNumber($post->comments) }}</span> {{ __choice('comments', $post->comments) }}
</h3>
<form action="{{ route('posts.comment', $post) }}" id="comment-form" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        @if ( ! auth()->check())
            <img src="{{ assetTheme('assets/img/default.png') }}" class="user-avatar" alt="User Avatar">
        @else
            <img src="{{ avatar(Auth::user()->avatar) }}" class="user-avatar" alt="User Avatar">
        @endif
        <label for="comment" class="sr-only">Type in your comment</label>
        <textarea name="message" id="comment" placeholder="{{ __('Write your comment here') }}"></textarea>
    </div>
    <div class="right">
        @if (auth()->check())
            <button type="submit" class="btn btn-medium submit-btn">{{ title(__('post')) }}</button>
        @else
            <button type="button" disabled class="btn btn-medium modal-trigger"
                    data-target=".modal-log-in">{{ title(__('post')) }}</button>
        @endif
    </div>
</form>
<div class="comments" data-post="{{ $post->id }}" data-url="{{ route('comments.load', $post->id) }}">
    <div class="loading-comments" data-post="{{ $post->id }}">
        <img src="{{ assetTheme('assets/img/loading-black.gif') }}" alt="Comments are loading">
        <span>{{ __('Loading...') }}</span>
    </div> <!-- end of loading comments -->
</div>