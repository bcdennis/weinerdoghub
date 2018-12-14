<?php

namespace Themes\Site\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Smile\Core\Persistence\Models\Post;
use Smile\Core\Persistence\Repositories\CommentContract;
use Smile\Core\Services\PostService;
use Smile\Core\Services\ReportService;
use Smile\Http\Requests\CreateCommentRequest;
use Smile\Http\Requests\CreateFileUploadRequest;
use Smile\Http\Requests\CreateListRequest;
use Smile\Http\Requests\CreateUrlUploadRequest;

class PostsController extends BaseSiteController
{

    /**
     * @var PostService
     */
    private $postService;

    /**
     * @var CommentContract
     */
    private $comment;
    /**
     * @var ReportService
     */
    private $report;

    /**
     * @param PostService $postService
     * @param CommentContract $comment
     * @param ReportService $report
     */
    public function __construct(PostService $postService,
                                CommentContract $comment,
                                ReportService $report)
    {
        $this->middleware('auth', ['except' => ['search', 'random', 'servePost']]);

        $this->postService = $postService;
        $this->comment = $comment;
        $this->report = $report;
    }

    /**
     * Create list form
     *
     * @return \Illuminate\View\View
     */
    public function listForm()
    {
        return $this->view('post.make-list');
    }

    /**
     * Store list
     *
     * @param CreateListRequest $request
     * @return array|JsonResponse
     */
    public function storeList(CreateListRequest $request)
    {
        $user = $request->user();
        $data = $request->only('title', 'description', 'media', 'categories', 'items');

        if (count($request->get('items', [])) > setting('max-list-items', 10)) {
            return $this->jsonErrors([
                'general' => __('A list should have maximum :items items!', ['items' => setting('max-list-items', 1)])
            ]);
        }

        try {
            $this->postService->createList($user, $data);
        } catch (Exception $e) {
            return $this->jsonErrors([
                'items.' . $e->getMessage() => 'Invalid format provided!',
            ]);
        }

        return [
            'to' => route('profile.posts', $user->name)
        ];
    }

    /**
     * POst info
     *
     * @param Post $post
     * @return array
     */
    public function info(Post $post)
    {
        return [
            'title' => $post->title,
            'description' => $post->description,
            'categories' => $post->categories
        ];
    }

    /**
     * Edit post
     *
     * @param Post $post
     * @param Request $request
     * @return array
     */
    public function edit(Post $post, Request $request)
    {
        $rules = [
            'title' => 'required',
            'categories' => 'required|between:1,' . setting('maximum-categories', 2),
        ];

        foreach ($request->get('categories', []) as $category) {
            $rules['categories.' . $category] = 'required|exists:categories,slug';
        }

        $this->validate($request, $rules);

        $this->postService->update($post, $request->only('title', 'description', 'categories'));

        return ['to' => route('post', $post->slug)];
    }

    /**
     * Displays the post by its slug
     *
     * @param Post $post
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function servePost(Post $post, Request $request)
    {
        $this->postService->updateViews($post, $request);

        $next = $this->postService->next($post);

        return $this->view('post.show', compact('post', 'next'));
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return array
     */
    public function vote(Request $request, Post $post)
    {
        $this->validate($request, [
            'value' => 'required|in:-1,0,1'
        ]);

        $value = $request->get('value');

        return $this->postService->vote($request->user(), $post, $value);
    }

    /**
     * Post a new comment
     *
     * @param Post $post
     * @param CreateCommentRequest $request
     * @return \Smile\Core\Persistence\Models\Comment
     * @throws \Throwable
     */
    public function comment(Post $post, CreateCommentRequest $request)
    {
        $interval = setting('comment-interval', 0);

        if ($request->user()->last_comment + $interval > time()) {
            return $this->jsonErrors([
                'comment' => __('You can add a new comment every :seconds seconds!', ['seconds' => $interval]),
            ]);
        }

        $all = $request->all();
        $comment = $this->postService->comment($request->user(), $post, $all);

        $viewData = ['comment' => $comment, 'post' => $post];

        if ($request->has('parent_id')) {
            $viewData['reply'] = '';
        }

        $partial = $this->view('partials.comment', $viewData);

        return ['partial' => $partial->render()];
    }

    /**
     * Store post
     *
     * @param CreateFileUploadRequest $request
     * @return array
     */
    public function fileUpload(CreateFileUploadRequest $request)
    {
        $fields = $request->only('title', 'media', 'categories', 'description');
        $user = $request->user();

        try {
            $post = $this->postService->create($user, $fields);
        } catch (Exception $e) {
            \Log::error($e);
            return $this->jsonErrors(['media' => __('Invalid media format!'), 'e' => $e->getMessage()]);
        }

        return [
            'post' => $post,
            'to' => route('profile.posts', $user->name)
        ];
    }

    /**
     * Upload post from url
     *
     * @param CreateUrlUploadRequest $request
     * @return array|\Symfony\Component\HttpFoundation\Response
     */
    public function urlUpload(CreateUrlUploadRequest $request)
    {
        $fields = $request->only('title', 'link', 'categories', 'description');
        $user = $request->user();

        try {
            $post = $this->postService->create($user, $fields);
        } catch (Exception $e) {
            return response()->json(['link' => __('Url format is invalid!'), 'e' => $e->getMessage()], 422);
        }

        return [
            'post' => $post,
            'to' => route('profile.posts', $user->name)
        ];
    }

    /**
     * Delete post
     *
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Post $post)
    {
        if ($request->user()->id == $post->user_id) {
            $this->postService->deleteById($post->id);
        }

        return redirect()->back();
    }

    /**
     * Create post report
     *
     * @param Post $post
     * @param Request $request
     */
    public function report(Post $post, Request $request)
    {
        $this->validate($request, [
            'reason' => 'required'
        ]);

        $this->report->createPostReport($request->user(), $post, $request->get('reason'));
    }

    /**
     * Find posts
     *
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $searchStr = $request->get('q');
        $posts = $this->postService->search($searchStr);

        if ($request->has('ajax')) {
            return $this->jsonPagination($posts, $this->view('ajax.search', compact('posts')));
        }

        return $this->view('post.search', compact('posts', 'searchStr'));
    }

    /**
     * Redirect to random post
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function random(Request $request)
    {
        $post = $this->postService->random($request->user());

        if (!$post) {
            return redirect()->back();
        }

        return redirect()->route('post', $post->slug);
    }

}
