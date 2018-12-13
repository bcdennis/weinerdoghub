<?php

namespace Smile\Core\Persistence\Repositories;

use Smile\Core\Persistence\Models\Comment;
use Smile\Core\Persistence\Models\User;

interface CommentReportContract
{

    /**
     * Find reports by post id
     *
     * @param null $q
     * @param int $perPage
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
	public function all($q = null, $perPage = 10);

    /**
     * Count comment reports
     *
     * @return mixed
     */
    public function count();

    /**
     * Close reports
     *
     * @param $id
     * @return bool|null
     */
    public function deleteByComment($id);

    /**
     * Create comment report
     *
     * @param User $user
     * @param Comment $comment
     * @return mixed
     */
    public function create(User $user, Comment $comment);

    /**
     * Find report by user and comment
     *
     * @param User $user
     * @param Comment $comment
     * @return mixed
     */
    public function findByUserAndComment(User $user, Comment $comment);

}
