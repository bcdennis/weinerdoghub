<?php namespace Smile\Events\Post;

use Illuminate\Queue\SerializesModels;
use Smile\Core\Persistence\Models\Post;
use Smile\Core\Persistence\Models\User;
use Smile\Events\Event;

class PostWasCreated extends Event
{

    use SerializesModels;

    /**
     * @var Post
     */
    public $post;
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     * @param User $user
     * @param Post $post
     */
    public function __construct(User $user, Post $post)
    {
        $this->post = $post;
        $this->user = $user;
    }

}
