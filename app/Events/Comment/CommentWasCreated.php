<?php namespace Smile\Events\Comment;

use Smile\Events\Event;
use Smile\Core\Persistence\Models\Comment;
use Smile\Core\Persistence\Models\Post;
use Smile\Core\Persistence\Models\User;
use Illuminate\Queue\SerializesModels;

class CommentWasCreated extends Event {

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
     * @var Comment
     */
    public $comment;

    /**
     * Create a new event instance.
     * @param User $user
     * @param Post $post
     * @param Comment $comment
     */
    public function __construct(User $user, Post $post, Comment $comment)
    {
        $this->user = $user;
        $this->post = $post;
        $this->comment = $comment;
    }

}
