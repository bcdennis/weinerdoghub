@foreach ($notifications as $notification)
    <li>
        <a target="_blank" href="{{ route('notifications.read', $notification->id) }}">
            @if ($notification->type == 'comment')
                <img src="{{ assetTheme('assets/img/comment-notification.png') }}" alt="comment">
            @elseif ($notification->type == 'reply')
                <img src="{{ assetTheme('assets/img/comment-notification.png') }}" alt="comment">
            @elseif ($notification->type == 'post.like')
                <img src="{{ assetTheme('assets/img/smile-notification.png') }}" alt="comment">
            @endif
            <div class="notification-meta">
                <span class="user-name">{{ $notification->from->name }}</span>
                @if ($notification->type == 'comment')
                    <span class="action">{{ __('commented on your post') }}</span>
                @elseif ($notification->type == 'reply')
                    <span class="action">{{ __('replied to your comment') }}</span>
                @elseif ($notification->type == 'post.like')
                    <span class="action">{{ __('smiled at your post') }}</span>
                @endif
            </div>
        </a>
    </li>
@endforeach