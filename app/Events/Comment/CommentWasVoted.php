<?php namespace Smile\Events\Comment;

use Illuminate\Queue\SerializesModels;
use Smile\Core\Persistence\Models\Comment;
use Smile\Core\Persistence\Models\User;
use Smile\Events\Event;

class CommentWasVoted extends Event
{

    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var Comment
     */
    public $comment;

    /**
     * @var
     */
    public $value;

    /**
     * Create a new event instance.
     * @param User $user
     * @param Comment $comment
     * @param $value
     */
    public function __construct(User $user, Comment $comment, $value)
    {
        $this->user = $user;
        $this->comment = $comment;
        $this->value = $value;
    }

}
