@if ( ! isset($reply))
    <div class="comment" id="parent_{{ $comment->id }}">
@else
    <div class="comment reply-comment" id="comment-{{ $comment->id }}">
@endif
    <img src="{{ avatar($comment->user->avatar) }}" alt="user-avatar">
    <div class="payload">
        <div class="info">
            <a target="_blank" href="{{ route('profile.overview', $comment->user->name) }}" class="username">
                {{ $comment->user->name }}
            </a>
            <div class="divider"></div>
            @if ($post->user_id == $comment->user_id)
                <span class="text-success text-op">{{ __('OP') }}</span>
                <div class="divider"></div>
            @endif
            <span class="smiles">
                <span class="smiles-number-{{ $comment->id }}">
                {{ formatNumber($comment->likes - $comment->dislikes) }}
                </span> <span>{{ __choice('points', $comment->likes - $comment->dislikes) }}</span>
            </span>
            @if (auth()->check())
            <div class="comment-actions">
                <button class="btn-none btn-comm-actions">
                    <span class="caret"></span>
                </button>
                <div class="dropdown comm-actions-dropdown">
                    <ul>
                        <li>
                            @if ($comment->user_id == auth()->user()->id)
                                <button type="button" @if ( ! isset($reply)) data-type="parent" @else data-type="child" @endif data-url="{{ route('comments.delete', $comment->id) }}" data-id="{{ $comment->id }}" class="btn btn-text delete">{{ __('delete') }}</button>
                            @endif
                        </li>
                        <li>
                            @if ($comment->user_id != auth()->user()->id)
                                <button type="button" @if ( ! isset($reply)) data-type="parent" @else data-type="child" @endif data-url="{{ route('comments.report', $comment->id) }}" data-id="{{ $comment->id }}" class="btn btn-text report">{{ __('report') }}</button>
                            @endif
                        </li>
                    </ul>
                </div> <!-- end of dropdown -->
            </div> <!-- end of comments-actions -->
            @endif
        </div>
        <div class="content">
            <p>{!! parseComment($comment->message) !!}</p>
        </div>
        <div class="actions">
            <button type="button" data-post="{{ $comment->post_id }}" data-parent="{{ $comment->parent_id ?: $comment->id }}" data-id="{{ $comment->id }}" data-name="{{ $comment->user->name }}" class="btn btn-text btn-reply-comm">
                {{  __('Reply') }}
            </button>
            {!! voteButton($comment, 'like', Auth::user()) !!}
            <div class="divider"></div>
            {!! voteButton($comment, 'dislike', Auth::user()) !!}
        </div>
    </div>
</div>