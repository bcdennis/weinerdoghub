<?php

namespace Themes\Admin\Http\Controllers;


use Illuminate\Http\Request;
use Smile\Core\Services\PostService;

class PostsController extends BaseAdminController
{
    /**
     * @var PostService
     */
    private $post;

    /**
     * @param PostService $post
     */
    public function __construct(PostService $post)
    {
        $this->middleware('auth.admin');

        $this->post = $post;
    }

    /**
     * List all posts
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function all(Request $request)
    {
        $posts = $this->post->search($request->get('q'));
        $hold = $this->post->hold(null, 1);

        return $this->view('posts.list', compact('posts', 'hold'));
    }

    /**
     * List all non accepted posts
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function hold(Request $request)
    {
        $posts = $this->post->search(null, 1);
        $hold = $this->post->hold($request->get('q'));

        return $this->view('posts.hold', compact('posts', 'hold'));
    }

    /**
     * Delete post
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pin($id)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->post->togglePin($id);

        return redirect()->back();
    }

    /**
     * Delete post
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->post->deleteById($id);

        return redirect()->back();
    }

    /**
     * Accept post
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function accept($id)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->post->acceptById($id);

        return redirect()->back();
    }
}
