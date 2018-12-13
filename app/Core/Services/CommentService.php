<?php

namespace Smile\Core\Services;

use Illuminate\Database\Eloquent\Model;
use Smile\Events\Comment\CommentWasUnvoted;
use Smile\Events\Comment\CommentWasVoted;
use Smile\Core\Persistence\Models\Comment;
use Smile\Core\Persistence\Models\CommentReport;
use Smile\Core\Persistence\Models\Post;
use Smile\Core\Persistence\Models\User;
use Smile\Core\Persistence\Repositories\CommentContract;
use Smile\Core\Persistence\Repositories\CommentReportContract;
use Smile\Core\Persistence\Repositories\PostContract;
use Smile\Core\Persistence\Repositories\VoteContract;

class CommentService
{
	/**
	 * @var CommentContract
	 */
	private $comment;
    /**
     * @var VoteContract
     */
    private $vote;
    /**
     * @var CommentReportContract
     */
    private $commentReport;
    /**
     * @var PostContract
     */
    private $post;

    /**
     * @param CommentContract $comment
     * @param VoteContract $vote
     * @param CommentReportContract $commentReport
     * @param PostContract $post
     */
	public function __construct(CommentContract $comment,
                                VoteContract $vote,
                                CommentReportContract $commentReport,
                                PostContract $post)
	{
		$this->comment = $comment;
        $this->vote = $vote;
        $this->commentReport = $commentReport;
        $this->post = $post;
    }

    /**
     * @param User $user
     * @param Model $model
     * @param $value
     * @return mixed
     */
    public function vote(User $user, Model $model, $value)
    {
        $vote = $this->comment->getVote($model, $user->id);

        if (is_null($vote) && $value != 0) {
            $this->comment->vote($model, $user->id, $value);
            event(new CommentWasVoted($user, $model, $value));
        } else if ($value == 0 || $value == $vote->value) {
            $this->vote->delete($vote);
            event(new CommentWasUnvoted($user, $model, $value));
        } else {
            $this->vote->update($vote, $value);
            event(new CommentWasVoted($user,$model, $value));
        }

        return $this->comment->updateVotes($model);
    }

    /**
     * Delete comment by id
     *
     * @param $commentId
     * @return bool
     */
    public function delete($commentId)
    {
        $comment = $this->comment->findById($commentId);

        if ( ! $comment) {
            return false;
        }

        $sub = ! $comment->parent_id ? $comment->comments + 1 : 1;

        $this->post->update($comment->post, ['comments' => $comment->post->comments - $sub]);

        if ($comment->parent) {
            $this->comment->update($comment->parent, [
                'comments' => $comment->parent->comments - 1,
            ]);
        }

        return $this->comment->delete($comment);
    }

    /**
     * Report comment
     *
     * @param User $user
     * @param Comment $comment
     * @return mixed
     */
    public function report(User $user, Comment $comment)
    {
        return $this->commentReport->create($user, $comment);
    }

}
