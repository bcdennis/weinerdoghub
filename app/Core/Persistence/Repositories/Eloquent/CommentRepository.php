<?php

namespace Smile\Core\Persistence\Repositories\Eloquent;

use Smile\Core\Persistence\Models\Comment;
use Smile\Core\Persistence\Models\User;
use Smile\Core\Persistence\Repositories\CommentContract;

class CommentRepository extends BaseRepository implements CommentContract
{
    use VoteableTrait;

    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new comment
     *
     * @param array $data
     * @return Comment
     */
    public function create(array $data)
    {
        $comment = $this->getNew();
        $comment->fill($data);
        $comment->save();

        return $comment;
    }

    /**
     * Delete the comment
     *
     * @param Comment $comment
     * @return bool|null
     */
    public function delete(Comment $comment)
    {
        return $comment->delete();
    }

    /**
     * Update comment
     *
     * @param Comment $comment
     * @param array $data
     * @return mixed
     */
    public function update(Comment $comment, array $data)
    {
        $comment->fill($data);
        $comment->save();

        return $comment;
    }

    /**
     * Find comment by id
     *
     * @param $id
     * @param User $user
     * @return null|Comment
     */
    public function findById($id, User $user = null)
    {
        return $this->model->with(['post', 'parent', 'votes' => function ($query) use ($user) {
            $query->where('user_id', $user ? $user->id : null);
        }])->where('id', $id)->first();
    }


    /**
     * Find comments by post id
     *
     * @param $id
     * @param User $user
     * @param int $perPage
     * @param int $limit
     * @return mixed
     */
    public function findByPostId($id, User $user = null, $perPage = 10, $limit = 2)
    {
        $comments = $this->model->with(['children', 'user',
            'votes' => function ($query) use ($user) {
                $query->where('user_id', $user ? $user->id : null);
            }
        ])
        ->where('post_id', $id)
        ->where('parent_id', null)
        ->orderBy('id', 'desc');

        return $comments->paginate($perPage);
    }

    /**
     * Get comments for a given parent_id
     *
     * @param $id
     * @param User $user
     * @param null $last
     * @param int $perPage
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findByParentId($id, User $user = null, $last = null, $perPage = 5)
    {
        $comments = $this->model->with(['user', 'votes' => function ($query) use ($user) {
            $query->where('user_id', $user ? $user->id : null);
        }])->where('parent_id', $id);

        if ($last) {
            $comments = $comments->where('id', '<', $last);
        }

        $comments = $comments->orderBy('id', 'desc');

        return $comments->paginate($perPage);
    }

}