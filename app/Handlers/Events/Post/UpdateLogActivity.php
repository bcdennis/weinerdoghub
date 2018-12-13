<?php namespace Smile\Handlers\Events\Post;

use Smile\Events\Post\PostWasAccepted;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Smile\Core\Persistence\Repositories\ActivityContract;
use Smile\Core\Persistence\Repositories\PostContract;
use Smile\Core\Persistence\Repositories\UserContract;

class UpdateLogActivity {

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
     * @param UserContract $user
     * @param PostContract $post
     */
    public function __construct(UserContract $user, PostContract $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    /**
     * Handle the event.
     *
     * @param  PostWasAccepted  $event
     * @return void
     */
    public function handle(PostWasAccepted $event)
    {
        $user = $event->post->user;

        $this->user->update($user, [
            'posts' => $this->post->countAcceptedPosts($user)
        ]);
    }

}
