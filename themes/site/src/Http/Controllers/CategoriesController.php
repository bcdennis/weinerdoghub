<?php

namespace Themes\Site\Http\Controllers;

use Illuminate\Http\Request;
use Smile\Core\Persistence\Repositories\CategoryContract;
use Smile\Core\Persistence\Repositories\PostContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoriesController extends BaseSiteController
{

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
     */
    public function __construct(CategoryContract $category, PostContract $post)
    {
        $this->category = $category;
        $this->post = $post;
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
        $category = !$slug ? $this->category->first() :
            $this->category->findBySlug($slug);

        if (!$category) {
            throw new NotFoundHttpException();
        }

        $posts = $this->post->findByCategory($category, $request->user(), 10);

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
        $posts = $this->post->topPosts('weekly', $request->user());

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
        $posts = $this->post->topPosts('monthly', $request->user());

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
        $posts = $this->post->topPosts('yearly', $request->user());

        if ($request->has('ajax')) {
            return $this->jsonPagination($posts, $this->view('ajax.posts', compact('posts')));
        }

        return $this->view('post.list', compact('category', 'posts'));
    }

}
