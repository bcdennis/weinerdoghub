<?php

namespace Smile\Core\Persistence\Repositories\Eloquent;

use Smile\Core\Persistence\Models\Post;
use Smile\Core\Persistence\Models\PostReport;
use Smile\Core\Persistence\Models\User;
use Smile\Core\Persistence\Repositories\PostReportContract;

class PostReportRepository extends BaseRepository implements PostReportContract
{
	/**
	 * @param PostReport $model
	 */
    public function __construct(PostReport $model)
    {
        $this->model = $model;
    }

	/**
	 * @param User $user
	 * @param Post $post
	 * @param $reason
	 * @return PostReport
	 */
    public function create(User $user, Post $post, $reason)
    {
        $report = $this->getNew();
        $report->fill([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'reason'  => $reason,
        ]);
        $report->save();

        return $report;
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
     * Find report by post and user
     *
     * @param User $user
     * @param Post $post
     * @param $reason
     * @return mixed
     */
    public function findByUserAndPost(User $user, Post $post, $reason)
    {
        return $this->model->where('user_id', $user->id)
                       ->where('post_id', $post->id)
                       ->where('reason', $reason)
                       ->first();
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
        $reports = $this->model->with(['post.user', 'user'])
          ->orderBy('id', 'desc')
          ->groupBy('post_id')
          ->groupBy('reason')
          ->whereHas('post', function ($query) use ($q) {
              if ($q) {
                  $query->where('title', 'like', '%'.$this->escape($q).'%');
              }
          });

        return $reports->paginate($perPage);
    }

    /**
     * Close reports
     *
     * @param $id
     * @return bool|null
     */
    public function deleteByPost($id)
    {
        return $this->model->where('post_id', $id)->delete();
    }

}
