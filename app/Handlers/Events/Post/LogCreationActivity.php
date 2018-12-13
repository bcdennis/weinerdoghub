<?php

namespace Smile\Handlers\Events\Post;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Smile\Events\Post\PostWasCreated;
use Smile\Core\Persistence\Repositories\ActivityContract;
use Smile\Core\Persistence\Repositories\PostContract;
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
     * @var PostContract
     */
    private $post;

    /**
     * Create the event handler.
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
	 * @param  PostWasCreated  $event
	 * @return void
	 */
	public function handle(PostWasCreated $event)
	{
        $this->activity->create($event->user, $event->post, 'post.create');

        $this->user->update($event->user, [
            'posts' => $this->post->countPosts($event->user)
        ]);
	}

}
