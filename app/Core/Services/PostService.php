<?php
namespace Smile\Core\Services;

use Exception;
use Illuminate\Http\Request;
use Smile\Core\Contracts\Embed\ManagerContract;
use Smile\Core\Contracts\Image\UploaderContract;
use Smile\Events\Comment\CommentWasCreated;
use Smile\Events\Post\PostWasAccepted;
use Smile\Events\Post\PostWasCreated;
use Smile\Events\Post\PostWasDeleted;
use Smile\Events\Post\PostWasVoted;
use Smile\Events\Post\PostWasUnvoted;
use Smile\Exceptions\DataSourceException;
use Smile\Core\Persistence\Models\Post;
use Smile\Core\Persistence\Models\User;
use Smile\Core\Persistence\Repositories\ActivityContract;
use Smile\Core\Persistence\Repositories\CategoryContract;
use Smile\Core\Persistence\Repositories\CommentContract;
use Smile\Core\Persistence\Repositories\PostContract;
use Smile\Core\Persistence\Repositories\UserContract;
use Smile\Core\Persistence\Repositories\VoteContract;

class PostService
{
    /**
     * @var PostContract
     */
    private $post;

    /**
     * @var UploaderContract
     */
    private $imageUploadService;

    /**
     * @var CategoryContract
     */
    private $category;

    /**
     * @var VoteContract
     */
    private $vote;

    /**
     * @var CommentContract
     */
    private $comment;
    /**
     * @var ActivityContract
     */
    private $activity;
    /**
     * @var UserContract
     */
    private $user;
    /**
     * @var ManagerContract
     */
    private $embed = null;

    /**
     * @param PostContract $post
     * @param CategoryContract $category
     * @param VoteContract $vote
     * @param UploaderContract $imageUploadService
     * @param CommentContract $comment
     * @param ActivityContract $activity
     * @param UserContract $user
     * @param ManagerContract $embed
     */
    public function __construct(PostContract $post,
                                CategoryContract $category,
                                VoteContract $vote,
                                CommentContract $comment,
                                ActivityContract $activity,
                                UserContract $user,
                                UploaderContract $imageUploadService,
                                ManagerContract $embed)
    {
        $this->imageUploadService = $imageUploadService;
        $this->category = $category;
        $this->comment = $comment;
        $this->post = $post;
        $this->vote = $vote;
        $this->activity = $activity;
        $this->user = $user;
        $this->embed = $embed;
    }

    /**
     * Create list by merging posts
     *
     * @param User $user
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function createList(User $user, array $data)
    {
        $db = app('db');

        $db->beginTransaction();

        try {
            $post = $this->create($user, $data, 'list');

            foreach ($data['items'] as $pos => $item) {
                if (isset($item['media']) && is_object($item['media']))
                    unset($item['link']);
                else
                    unset($item['media']);

                $item['parent_id'] = $post->id;
                $item['position'] = $pos;

                try {
                    $this->create($user, $item, 'item');
                } catch (Exception $e) {
                    throw new Exception($pos.'.'.(isset($item['media']) ? 'media' : 'link'));
                }
            }

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        return [];
    }

    /**
     * Creates a new post for a given user
     *
     * @param User $user
     * @param array $data
     * @param string $type
     * @return mixed
     * @throws DataSourceException
     */
    public function create(User $user, array $data, $type = 'post')
    {
        $activeSlug = setting('branding.slug', false);

        $slug = $activeSlug ? str_slug($data['title']) : str_random(14);
        $slug = ($slug == '') ? str_random(14) : $slug;

        $data['media'] = isset($data['link']) ? $data['link'] : $data['media'];
        $data['slug'] = $user->id.'-'.mt_rand(10000, 99999).'-'.$slug;

        if ($this->embed->isEmbeddable($data['media'])) {
            $data = $this->processPostWithVideo($data);
        } else {
            $data = $this->processPostWithImage($data);
        }

        if ($type == 'list') {
            $data['type'] = 'list';
        }

        $data['user_id'] = $user->id;
        $data['description'] = isset($data['description']) ? preg_replace('#<.*?>#i', '', $data['description']) : '';
        $data['accepted'] = ! setting('post-moderation', false);

        $post = $this->post->create($data);

        if ( ! $post) {
            throw new DataSourceException;
        }

        $this->post->update($post, [
            'slug' => ($activeSlug ? $post->id.'-' : '').$slug,
        ]);

        if ($type != 'item') {
            $this->processCategories($post, $data, $type);
            event(new PostWasCreated($user, $post));
        }

        return $post;
    }

    /**
     * Update post views
     *
     * @param Post $post
     * @param Request $request
     */
    public function updateViews(Post $post, Request $request)
    {
        $session = $request->session();
        $posts = $session->get('posts', []);

        if ( ! in_array($post->id, $posts)) {
            $posts[] = $post->id;
            $this->post->update($post, ['views' => $post->views + 1]);
            $session->put('posts', $posts);
        }
    }

    /**
     * Process post categories
     *
     * @param Post $post
     * @param array $data
     * @param string $type
     */
    protected function processCategories(Post $post, array $data, $type = 'post')
    {
        if ($data['type'] == 'gif') {
            $gifCategories = $this->category->findSlugsByTemplate('gif');
            $data['categories'] = array_merge($data['categories'], $gifCategories);
        }

        if ($type == 'meme') {
            $memesCategories = $this->category->findSlugsByTemplate('meme');
            $data['categories'] = array_merge($data['categories'], $memesCategories);
        }

        $categories = $this->category->findBySlugs($data['categories']);
        $this->post->addCategories($post, $categories);

        foreach ($categories as $category) {
            if ($category->template == 'nsfw') {
                $this->post->update($post, ['safe' => false]);
                break;
            }
        }
    }

    /**
     * Process post with image
     *
     * @param array $data
     * @return array
     */
    protected function processPostWithImage(array $data)
    {
        return $this->imageUploadService->uploadPostImage($data);
    }

    /**
     * Process post with video
     *
     * @param array $data
     * @return array
     * @throws Exception
     */
    protected function processPostWithVideo(array $data)
    {
        $post = null;

        foreach ($this->embed->all() as $embedder) {
            if ($embedder->canEmbed($data['media'])) {
                $post = $embedder->process($data);
                break;
            }
        }

        return $post;
    }

    /**
     * Vote post
     *
     * @param User $user
     * @param Post $post
     * @param $value
     * @return mixed
     */
    public function vote(User $user, Post $post, $value)
    {
        $vote = $this->post->getVote($post, $user->id);

        if (is_null($vote) && $value) {
            $this->post->vote($post, $user->id, $value);
            event(new PostWasVoted($user, $post, $value));
        } else if ($value == 0 || $value == $vote->value) {
            $this->vote->delete($vote);
            event(new PostWasUnvoted($user, $post, $value));
        } else {
            $this->vote->update($vote, $value);
            event(new PostWasVoted($user, $post, $value));
        }

        $post = $this->post->updateVotes($post);

        $owner = $post->user;

        $this->user->update($owner, [
            'points' => $this->post->userPoints($owner),
        ]);

        return $post;
    }

    /**
     * Create a new comment
     *
     * @param User $user
     * @param Post $post
     * @param array $data
     * @return \Smile\Core\Persistence\Models\Comment
     */
    public function comment(User $user, Post $post, array $data)
    {
        $data['user_id'] = $user->id;
        $data['post_id'] = $post->id;

        $this->post->update($post, ['comments' => $post->comments + 1]);

        // Update the parent of the comment with the right number of comments

        if (isset($data['parent_id'])) {
            $parent = $this->comment->findById($data['parent_id']);
            $this->comment->update($parent, ['comments' => $parent->comments + 1]);
        }

        $data['message'] = preg_replace('#<.*?>#i', '', $data['message']);

        $comment = $this->comment->create($data);

        if ($comment) {
            event(new CommentWasCreated($user, $post, $comment));
        }

        return $comment;
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
        return $this->post->search($query, $perPage);
    }

    /**
     * Get on hold posts
     *
     * @param $query
     * @param int $perPage
     * @return mixed
     */
    public function hold($query = null, $perPage = 10)
    {
        return $this->post->hold($query, $perPage);
    }

    /**
     * Find the next post
     *
     * @param Post $post
     * @return mixed
     */
    public function next(Post $post)
    {
        return $this->post->next($post);
    }

    /**
     * Find featured posts
     *
     * @param int $limit
     * @param User $user
     * @return mixed
     */
    public function featured($limit = 10, User $user = null)
    {
        return $this->post->findFeatured($limit, $user);
    }

    /**
     * Delete post by its id
     *
     * @param $id
     * @return bool
     */
    public function deleteById($id)
    {
        $post = $this->post->findById($id);

        if ( ! $post) {
            return false;
        }

        $this->user->update($post->user, [
            'posts' => $post->user->posts - 1,
        ]);

        $this->imageUploadService->remove($post->featured);

        if ($post->type == 'image' || $post->type == 'gif') {
            $this->imageUploadService->remove($post->thumbnail);
            $this->imageUploadService->remove($post->media);
        }

        $this->post->delete($post);

        event(new PostWasDeleted($post));

        return true;
    }

    /**
     * Accept post by id
     *
     * @param $id
     * @return bool
     */
    public function acceptById($id)
    {
        $post = $this->post->findById($id);

        if ( ! $post) {
            return false;
        }

        $this->post->update($post, [
            'accepted' => true,
        ]);

        event(new PostWasAccepted($post));

        return true;
    }

    /**
     * Toggle pin
     *
     * @param $id
     * @return bool|mixed
     */
    public function togglePin($id)
    {
        $post = $this->post->findById($id);

        if ( ! $post) {
            return false;
        }

        $this->post->update($post, ['pinned' => $post->pinned ? false : true]);

        return $post;
    }

    /**
     * Get random post
     *
     * @param null|User $user
     * @return mixed
     */
    public function random(User $user = null)
    {
        return $this->post->random($user);
    }

    /**
     * Update post
     *
     * @param Post $post
     * @param array $data
     */
    public function update(Post $post, array $data)
    {
        $this->post->update($post, $data);

        $oldCategories = $post->categories;

        foreach ($oldCategories as $category) {
            if ($category->template != '') {
                $data['categories'][] = $category->slug;
            }
        }

        $categories = $this->category->findBySlugs($data['categories']);

        $this->post->addCategories($post, $categories);
    }

}
