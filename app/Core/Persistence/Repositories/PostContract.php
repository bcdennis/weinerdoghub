<?php

namespace Smile\Core\Persistence\Repositories;

use Illuminate\Database\Eloquent\Model;
use Smile\Core\Persistence\Models\Category;
use Smile\Core\Persistence\Models\Post;
use Smile\Core\Persistence\Models\User;
use Smile\Core\Persistence\Models\Vote;

interface PostContract
{

    /**
     * Find post by its slug
     *
     * @param $slug
     * @return mixed
     */
    public function findBySlug($slug);

    /**
     * Get all post info
     *
     * @param $id
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function findWithRelationships($id, User $user = null);

    /**
     * Find posts by category
     *
     * @param Category $category
     * @param User $user
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findByCategory(Category $category, User $user = null, $perPage = 10);

    /**
     * Get top posts for a specific timestamp
     *
     * @param $top
     * @param User|null $user
     * @param int $perPage
     * @return mixed
     */
    public function topPosts($top, User $user = null, $perPage = 10);

    /**
     * Find featured posts
     *
     * @param int $limit
     * @param User $user
     * @return mixed
     */
    public function findFeatured($limit = 10, User $user = null);

    /**
     * Vote post
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
     * Creates a new post
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update post
     *
     * @param Post $post
     * @param array $data
     * @return mixed
     */
    public function update(Post $post, array $data);

    /**
     * Delete post
     *
     * @param Post $post
     * @return mixed
     */
    public function delete(Post $post);

    /**
     * Add categories to post
     *
     * @param Post $post
     * @param mixed $categories
     */
    public function addCategories(Post $post, $categories);

    /**
     * Find post by id
     *
     * @param $id
     * @return mixed
     */
    public function findById($id);


    /**
     * Find the post next to current post
     *
     * @param Post $post
     * @return mixed
     */
    public function next(Post $post);

    /**
     * Count user posts
     *
     * @param User $user
     */
    public function countPosts(User $user);

    /**
     * Count active posts for user
     *
     * @param User $user
     * @return mixed
     */
    public function countAcceptedPosts(User $user);

    /**
     * User post likes
     *
     * @param User $user
     * @return mixed
     */
    public function userPoints(User $user);

    /**
     * Search for posts
     *
     * @param $query
     * @param $perPage
     * @return mixed
     */
    public function search($query = null, $perPage = 10);

    /**
     * Get on hold posts
     *
     * @param $query
     * @param $perPage
     * @return mixed
     */
    public function hold($query = null, $perPage = 10);

}