<?php namespace Smile\Events\Post;

use Illuminate\Queue\SerializesModels;
use Smile\Events\Event;
use Smile\Core\Persistence\Models\Post;
use Smile\Core\Persistence\Models\User;


class PostWasVoted extends Event {

    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var Post
     */
    public $post;

    /**
     * @var
     */
    public $value;

    /**
     * Create a new event instance.
     * @param User $user
     * @param Post $post
     * @param $value
     */
    public function __construct(User $user, Post $post, $value)
    {
        $this->user = $user;
        $this->post = $post;
        $this->value = $value;
    }

}
