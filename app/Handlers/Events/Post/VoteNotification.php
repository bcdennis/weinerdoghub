<?php namespace Smile\Handlers\Events\Post;

use Smile\Events\Post\PostWasVoted;
use Smile\Core\Persistence\Repositories\NotificationContract;

class VoteNotification {
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
        $this->notification = $notification;
    }

    /**
     * Handle the event.
     *
     * @param  PostWasVoted  $event
     * @return void
     */
    public function handle(PostWasVoted $event)
    {
        if ($event->value != 1 || $event->user->id == $event->post->user_id) {
            return;
        }

        $this->notification->create([
            'from_id' => $event->user->id,
            'user_id' => $event->post->user_id,
            'type' => 'post.like',
            'url' => route('post', $event->post->slug),
        ]);
    }

}
