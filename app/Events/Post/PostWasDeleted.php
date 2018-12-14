<?php namespace Smile\Events\Post;

use Illuminate\Queue\SerializesModels;
use Smile\Core\Persistence\Models\Post;
use Smile\Events\Event;

class PostWasDeleted extends Event
{

    use SerializesModels;
    /**
     * @var Post
     */
    public $post;

    /**
     * Create a new event instance.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

}
