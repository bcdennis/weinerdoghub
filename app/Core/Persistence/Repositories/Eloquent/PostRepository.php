<?php

namespace Smile\Core\Persistence\Repositories\Eloquent;

use Carbon\Carbon;
use Smile\Core\Persistence\Models\Category;
use Smile\Core\Persistence\Models\User;
use Smile\Core\Persistence\Repositories\PostContract;
use Smile\Core\Persistence\Models\Post;

class PostRepository extends BaseRepository implements PostContract
{
    use VoteableTrait;

    /**
     * @param Post $model
     */
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    /**
     * Add categories to post
     *
     * @param Post $post
     * @param mixed $categories
     */
    public function addCategories(Post $post, $categories)
    {
        $post->categories()->sync($categories);
    }

    /**
     * Creates a new post
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $post = $this->getNew();
        $post->fill($data);
        $post->save();

        return $post;
    }

    /**
     * Delete post
     *
     * @param Post $post
     * @return mixed
     */
    public function delete(Post $post)
    {
        return $post->delete();
    }

    /**
     * Update post
     *
     * @param Post $post
     * @param array $data
     * @return mixed
     */
    public function update(Post $post, array $data)
    {
        $post->fill($data);
        $post->save();

        return $post;
    }

    /**
     * Find post by its slug
     *
     * @param $slug
     * @return mixed
     */
    public function findBySlug($slug)
    {
        return $this->model->whereSlug($slug)->first();
    }

    /**
     * Get all post info
     *
     * @param $id
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function findWithRelationships($id, User $user = null)
    {
        $post = $this->model->with(['votes' => function ($query) use ($user) {
            $query->where('user_id', $user ? $user->id : null);
        }, 'user']);

        if (is_numeric($id)) {
            $post->where('id', $id);
        } else {
            $post->where('slug', $id);
        }
        $post->where('parent_id', null);

        return $post->first();
    }

    /**
     * Find post by id
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public function findById($id)
    {
        return $this->model->with('user')->where('id', $id)->first();
    }

    /**
     * Find posts by category
     *
     * @param Category $category
     * @param User $user
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findByCategory(Category $category, User $user = null, $perPage = 10)
    {
        $posts = $this->model->with(['votes' => function ($query) use ($user) {
            $query->where('user_id', $user ? $user->id : null);
        }]);
        $posts->where('accepted', true);

        if ($category->template == '') {
            $posts->whereHas('categories', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })->orderBy('pinned', 'desc')->orderBy('id', 'desc');
        }

        if ($category->template == 'nsfw') {
            $posts->where('safe', false)
                ->orderBy('pinned', 'desc')
                ->orderBy('id', 'desc');
        }

        if ($category->template == 'all') {
            $posts->orderBy('points', 'DESC')->orderBy('id', 'desc');
        }

        if ($category->template == 'fresh') {
            $posts->orderBy('id', 'desc');
        }

        if ($category->template == 'gif') {
            $posts->whereIn('type', ['gif', 'video'])
                ->orderBy('pinned', 'desc')
                ->orderBy('id', 'desc');
        }

        if ($category->template == 'video') {
            $posts->whereIn('type', ['youtube', 'vimeo', 'facebook', 'dmotion'])
                            ->orderBy('pinned', 'desc')
                            ->orderBy('id', 'desc');
        }

        if ($category->template == 'vine') {
            $posts->whereIn('type', ['vine'])
                ->orderBy('pinned', 'desc')
                ->orderBy('id', 'desc');
        }

        if ($category->template == 'sound') {
            $posts->whereIn('type', ['soundcloud'])
                ->orderBy('pinned', 'desc')
                ->orderBy('id', 'desc');
        }

        if ($category->template == 'hot') {
            $posts->orderByRaw('LOG10(ABS(points)+1)*SIGN(points)+(UNIX_TIMESTAMP(created_at)/300000) DESC');
        }

        if ($category->template == 'hot2') {
            $posts->selectRaw('*, LOG10(points + 1) * 143507 + UNIX_TIMESTAMP(created_at) AS hotness');
            $posts->orderBy('hotness', 'desc');
        }

        $posts->where('parent_id', null);

        return $posts->paginate($perPage);
    }

    /**
     * Get top posts for a specific timestamp
     *
     * @param $top
     * @param User|null $user
     * @param int $perPage
     * @return mixed
     */
    public function topPosts($top, User $user = null, $perPage = 10)
    {
        $posts = $this->model->with(['votes' => function ($query) use ($user) {
            $query->where('user_id', $user ? $user->id : null);
        }]);
        $posts->where('accepted', true);

        switch ($top) {
            case 'weekly':
                $start = Carbon::now()->startOfWeek();
                break;
            case 'monthly':
                $start = Carbon::now()->startOfMonth();
                break;
            case 'yearly':
                $start = Carbon::now()->startOfYear();
                break;
            default:
                $start = Carbon::now()->startOfDay();
        }

        $posts->where('created_at', '>=', $start);
        $posts->where('parent_id', null);
        $posts->orderBy('points', 'desc');

        return $posts->paginate($perPage);
    }

    /**
     * Find featured posts
     *
     * @param int $limit
     * @param User $user
     * @return mixed
     */
    public function findFeatured($limit = 10, User $user = null)
    {
        $posts = $this->model->where('accepted', true)->random()->limit($limit);

        if ( ! $user || ! $user->nsfw) {
            $posts->where('safe', 1);
        }
        $posts->where('parent_id', null);

        return $posts->get();
    }

    /**
     * Random post
     *
     * @param User|null $user
     * @return mixed
     */
    public function random(User $user = null)
    {
        $posts = $this->model->where('accepted', true)->random()->limit(1);

        if ( ! $user || ! $user->nsfw) {
            $posts->where('safe', 1);
        }
        $posts->where('parent_id', null);

        return $posts->first();
    }

    /**
     * Search for posts
     *
     * @param $query
     * @param int $perPage
     * @return mixed
     */
    public function search($query = null, $perPage = 10)
    {
        $search = $this->model->with(['categories', 'user'])
            ->where('title', 'like', '%'.$this->escape($query).'%')
            ->where('accepted', true)
            ->where('parent_id', null);

        return $search->paginate($perPage);
    }

    /**
     * Search for posts that have not be accepted
     *
     * @param $query
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function hold($query = null, $perPage = 10)
    {
        $search = $this->model->with(['categories', 'user'])
            ->where('title', 'like', '%'.$this->escape($query).'%')
            ->where('accepted', false)
            ->where('parent_id', null);

        return $search->paginate($perPage);
    }

    /**
     * Count posts
     *
     * @param User $user
     * @return mixed
     */
    public function countPosts(User $user)
    {
        return $this->model->where('user_id', $user->id)
            ->where('parent_id', null)
            ->count('id');
    }

    /**
     * Count active posts for user
     *
     * @param User $user
     * @return mixed
     */
    public function countAcceptedPosts(User $user)
    {
        return $this->model->where('user_id', $user->id)
            ->where('accepted', true)
            ->where('parent_id', null)
            ->count('id');
    }

    /**
     * User post likes
     *
     * @param User $user
     * @return mixed
     */
    public function userPoints(User $user)
    {
        $likes = $this->model->where('user_id', $user->id)->selectRaw(
            'sum(points) as points'
        )->groupBy('user_id')->first();

        return $likes->points;
    }

    /**
     * Find the post next to current post
     *
     * @param Post $post
     * @return mixed
     */
    public function next(Post $post)
    {
        return $this->model->where('id', '<', $post->id)
                        ->where('accepted', true)
                        ->where('parent_id', null)
                        ->orderBy('id', 'desc')
                        ->first();
    }

}
