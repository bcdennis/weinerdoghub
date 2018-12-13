<?php namespace Smile\Handlers\Events\Comment;

use Smile\Events\Comment\CommentWasCreated;
use Smile\Core\Persistence\Repositories\NotificationContract;

class CreateNotification {
    /**
     * @var NotificationContract
     */
    private $notification;

    /**
     * Create the event handler.
     *
     * @param NotificationContract $notification
     */
    public function __construct(NotificationContract $notification)
    {
        //
        $this->notification = $notification;
    }

    /**
     * Handle the event.
     *
     * @param  CommentWasCreated  $event
     * @return void
     */
    public function handle(CommentWasCreated $event)
    {
        if ($event->user->id == $event->post->user_id ||
            ($event->comment->parent_id && $event->comment->parent->user_id == $event->user->id)) {
            return;
        }

        // Notification to post author
        $this->notification->create([
            'from_id' => $event->user->id,
            'user_id' => $event->post->user_id,
            'type' => 'comment',
            'url' => route('post', $event->post->slug),
        ]);

        if ($event->comment->parent_id) {
            $this->notification->create([
                'from_id' => $event->user->id,
                'user_id' => $event->comment->parent->user_id,
                'type' => 'reply',
                'url' => route('post', $event->post->slug),
            ]);
        }
    }

}
