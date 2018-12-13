<?php

namespace Smile\Core\Persistence\Repositories\Eloquent;

use Smile\Core\Persistence\Models\Comment;
use Smile\Core\Persistence\Models\CommentReport;
use Smile\Core\Persistence\Models\User;
use Smile\Core\Persistence\Repositories\CommentReportContract;

class CommentReportRepository extends BaseRepository implements CommentReportContract
{
    /**
     * @param CommentReport $model
     */
    public function __construct(CommentReport $model)
    {
        $this->model = $model;
    }

    /**
     * Creates a new comment report
     *
     * @param User $user
     * @param Comment $comment
     * @return CommentReport
     */
    public function create(User $user, Comment $comment)
    {
        $report = $this->getNew();
        $report->fill([
            'user_id' => $user->id,
            'comment_id' => $comment->id,
        ]);
        $report->save();

        return $report;
    }

    /**
     * Find reports by post id
     *
     * @param null $q
     * @param int $perPage
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function all($q = null, $perPage = 10)
    {
        $reports = $this->model->with(['comment.post.user', 'user'])
          ->orderBy('id', 'desc')
          ->groupBy('comment_id')
          ->whereHas('comment', function ($query) use ($q) {
              if ($q) {
                  $query->where('message', 'like', '%'.$this->escape($q).'%');
              }
          });

        return $reports->paginate($perPage);
    }

    /**
     * Find user
     *
     * @param User $user
     * @param Comment $comment
     * @return mixed
     */
    public function findByUserAndComment(User $user, Comment $comment)
    {
        return $this->model->where('user_id', $user->id)
                           ->where('comment_id', $comment->id)
                           ->first();
    }

    /**
     * Count post reports
     *
     * @return mixed
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * Close reports
     *
     * @param $id
     * @return bool|null
     */
    public function deleteByComment($id)
    {
        return $this->model->where('comment_id', $id)->delete();
    }

}
