<?php

namespace Smile\Handlers\Events\Comment;

use Smile\Events\Comment\CommentWasCreated;
use Smile\Core\Persistence\Repositories\ActivityContract;
use Smile\Core\Persistence\Repositories\UserContract;

class LogCreationActivity {

    /**
     * @var ActivityContract
     */
    private $activity;
    /**
     * @var UserContract
     */
    private $user;

    /**
     * Create the event handler.
     *
     * @param ActivityContract $activity
     * @param UserContract $user
     */
	public function __construct(ActivityContract $activity, UserContract $user)
	{
		$this->activity = $activity;
        $this->user = $user;
    }

	/**
	 * Handle the event.
	 *
	 * @param  CommentWasCreated  $event
	 * @return void
	 */
	public function handle(CommentWasCreated $event)
	{
        $this->activity->create($event->user, $event->post, 'post.comment');

        $comments = $this->activity->countActivities($event->user, 'post.comment');

        $this->user->update($event->user, [
            'comments' => $comments,
            'last_comment' => time(),
        ]);
	}

}
