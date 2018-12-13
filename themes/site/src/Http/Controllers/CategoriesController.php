<?php

namespace Themes\Site\Http\Controllers;

use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Smile\Core\Persistence\Repositories\CategoryContract;
use Smile\Core\Persistence\Repositories\PostContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoriesController extends BaseSiteController {

    /**
     * Current user
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $currentUser;

    /**
     * @var CategoryContract
     */
    private $category;
    /**
     * @var PostContract
     */
    private $post;

    /**
     * @param CategoryContract $category
     * @param PostContract $post
     * @param Guard $auth
     */
    public function __construct(CategoryContract $category, PostContract $post, Guard $auth)
    {
        $this->category = $category;
        $this->post = $post;
        $this->currentUser = $auth->user();
    }

    /**
     * Show posts from category
     *
     * @param Request $request
     * @param null $slug
     * @return \Illuminate\View\View
     */
    public function category(Request $request, $slug = null)
    {
        $category = ! $slug ? $this->category->first() :
                            $this->category->findBySlug($slug);

        if ( ! $category) {
            throw new NotFoundHttpException();
        }

        $posts = $this->post->findByCategory($category, $this->currentUser, 10);

        if ($request->has('ajax')) {
            return $this->jsonPagination($posts, $this->view('ajax.posts', compact('posts')));
        }

        return $this->view('post.list', compact('category', 'posts'));
    }

    /**
     * Weekly top
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function weekly(Request $request)
    {
        $posts = $this->post->topPosts('weekly', $this->currentUser);

        if ($request->has('ajax')) {
            return $this->jsonPagination($posts, $this->view('ajax.posts', compact('posts')));
        }

        return $this->view('post.list', compact('category', 'posts'));
    }

    /**
     * Monthly top
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function monthly(Request $request)
    {
        $posts = $this->post->topPosts('monthly', $this->currentUser);

        if ($request->has('ajax')) {
            return $this->jsonPagination($posts, $this->view('ajax.posts', compact('posts')));
        }

        return $this->view('post.list', compact('category', 'posts'));
    }

    /**
     * Yearly top
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function yearly(Request $request)
    {
        $posts = $this->post->topPosts('yearly', $this->currentUser);

        if ($request->has('ajax')) {
            return $this->jsonPagination($posts, $this->view('ajax.posts', compact('posts')));
        }

        return $this->view('post.list', compact('category', 'posts'));
    }

}
