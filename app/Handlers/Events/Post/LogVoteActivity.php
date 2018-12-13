<?php

namespace Smile\Handlers\Events\Post;

use Smile\Events\Post\PostWasVoted;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Smile\Core\Persistence\Repositories\ActivityContract;
use Smile\Core\Persistence\Repositories\PostContract;
use Smile\Core\Persistence\Repositories\UserContract;

class LogVoteActivity {
	/**
	 * @var ActivityContract
	 */
	private $activity;
	/**
	 * @var UserContract
	 */
	private $user;
    /**
     * @var PostContract
     */
    private $post;

    /**
     * Create the event handler.
     *
     * @param ActivityContract $activity
     * @param UserContract $user
     * @param PostContract $post
     */
	public function __construct(ActivityContract $activity,
                                UserContract $user,
                                PostContract $post)
	{
		$this->activity = $activity;
		$this->user = $user;
        $this->post = $post;
    }

	/**
	 * Handle the event.
	 *
	 * @param  PostWasVoted  $event
	 * @return void
	 */
	public function handle(PostWasVoted $event)
	{
        $eventName = $event->value == 1 ? 'post.vote.like' : 'post.vote.dislike';

        $this->activity->deleteByComposite($event->user, $event->post, 'post.vote.*');

        $this->activity->create($event->user, $event->post, $eventName);

		$likes = $this->activity->countActivities($event->user, 'post.vote.like');
		$dislikes = $this->activity->countActivities($event->user, 'post.vote.dislike');

		$this->user->update($event->user, [
			'likes' => $likes,
			'dislikes' => $dislikes,
		]);
	}

}
