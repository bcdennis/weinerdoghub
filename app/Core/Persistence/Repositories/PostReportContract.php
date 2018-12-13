<?php

namespace Smile\Core\Persistence\Repositories;

use Smile\Core\Persistence\Models\Post;
use Smile\Core\Persistence\Models\PostReport;
use Smile\Core\Persistence\Models\User;

interface PostReportContract
{

    /**
     * Find report by user and comment
     *
     * @param User $user
     * @param Post $post
     * @param $reason
     * @return mixed
     */
    public function findByUserAndPost(User $user, Post $post, $reason);

    /**
     * @param User $user
     * @param Post $post
     * @param $reason
     * @return PostReport
     */
    public function create(User $user, Post $post, $reason);

    /**
     * Find reports by post id
     *
     * @param null $q
     * @param int $perPage
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function all($q = null, $perPage = 10);

    /**
     * Count post reports
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
    public function deleteByPost($id);

}
