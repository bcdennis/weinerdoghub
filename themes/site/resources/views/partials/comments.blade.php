@foreach ($comments as $comment)
    <div id="block_parent_{{ $comment->id }}" data-name="{{ $comment->user->name }}">
        @include('site::partials.comment')
        @foreach ($comment->children as $id => $child)
            @include('site::partials.comment', ['reply' => '', 'post' => $post, 'comment' => $child])
            @if ($id == 1)
                <?php break; ?>
            @endif
        @endforeach
        @if ($comment->comments > 2)
            <div class="comment reply-comment more-{{ $comment->id }}">
                <a href="#" class="more" data-last="{{ $child->id }}" data-parent="{{ $comment->id }}"
                   data-url="{{ route('comments.more', $comment->id) }}">
                    {{ __('Load more replies') }}
                </a>
            </div>
        @endif
    </div>
@endforeach