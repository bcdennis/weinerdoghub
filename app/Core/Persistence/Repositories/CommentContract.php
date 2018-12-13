<?php

namespace Smile\Core\Persistence\Repositories;

use Illuminate\Database\Eloquent\Model;
use Smile\Core\Persistence\Models\Comment;
use Smile\Core\Persistence\Models\User;
use Smile\Core\Persistence\Models\Vote;

interface CommentContract
{
    /**
     * Find comment by id
     *
     * @param $id
     * @param User $user
     * @return null|Comment
     */
    public function findById($id, User $user = null);

    /**
     * Find comments by post id
     *
     * @param $id
     * @param User $user
     * @param int $perPage
     * @param int $limit
     * @return mixed
     */
    public function findByPostId($id, User $user = null, $perPage = 10, $limit = 2);

    /**
     * Get comments for a given parent_id
     *
     * @param $id
     * @param User $user
     * @param null $last
     * @param int $perPage
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findByParentId($id, User $user = null, $last = null, $perPage = 5);


    /**
     * Vote comment
     *
     * @param Model $model
     * @param Vote $user
     * @param $value
     * @return mixed|void
     */
    public function vote(Model $model, $user, $value);

    /**
     * Get vote
     *
     * @param Model $model
     * @param int $user
     * @return null|Vote
     */
    public function getVote(Model $model, $user);

    /**
     * Update votes
     *
     * @param $model
     * @return mixed
     */
    public function updateVotes(Model $model);

    /**
     * Create a new comment
     *
     * @param array $data
     * @return Comment
     */
    public function create(array $data);

    /**
     * Update comment
     *
     * @param Comment $comment
     * @param array $data
     * @return mixed
     */
    public function update(Comment $comment, array $data);

    /**
     * Delete the comment
     *
     * @param Comment $comment
     * @return bool|null
     */
    public function delete(Comment $comment);

}