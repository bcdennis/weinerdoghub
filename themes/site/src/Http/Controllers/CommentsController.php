<?php

namespace Themes\Site\Http\Controllers;

use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Smile\Core\Persistence\Models\Comment;
use Smile\Core\Persistence\Models\Post;
use Smile\Core\Persistence\Repositories\CommentContract;
use Smile\Core\Services\CommentService;
use Smile\Core\Services\ReportService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentsController extends BaseSiteController
{
    /**
     * @var CommentContract
     */
    private $comment;

    /**
     * @var CommentService
     */
    private $commentService;

    /**
     * @var ReportService
     */
    private $report;

    /**
     * @param CommentContract $comment
     * @param Guard $auth
     * @param CommentService $commentService
     * @param ReportService $report
     */
    public function __construct(CommentContract $comment,
                                Guard $auth,
                                CommentService $commentService,
                                ReportService $report
    )
    {
        $this->middleware('auth', ['only' => 'vote']);

        $this->currentUser = $auth->user();
        $this->comment = $comment;
        $this->commentService = $commentService;
        $this->report = $report;
    }

    /**
     * Vote comment
     *
     * @param integer $comment
     * @param Request $request
     * @return mixed
     */
    public function vote($comment, Request $request)
    {
        $this->validate($request, [
            'value' => 'required|in:-1,0,1'
        ]);

        $comment = $this->comment->findById($comment, $this->currentUser);

        if ( ! $comment) {
            throw new NotFoundHttpException;
        }

        $value = $request->get('value');

        return $this->commentService->vote($this->currentUser, $comment, $value);
    }

    /**
     * Report comment
     *
     * @param $comment
     * @return mixed
     */
    public function report($comment)
    {
        $comment = $this->comment->findById($comment, $this->currentUser);

        if ( ! $comment) {
            throw new NotFoundHttpException;
        }

        $this->report->createCommentReport($this->currentUser, $comment);

        return [];
    }

    /**
     * Delete comment
     *
     * @param $comment
     * @return array
     */
    public function delete($comment)
    {
        $comment = $this->comment->findById($comment, $this->currentUser);

        if ( ! $comment) {
            throw new NotFoundHttpException;
        }

        $this->commentService->delete($comment->id);

        return [];
    }

    /**
     * Initial comments
     *
     * @param Post $post
     * @param Request $request
     * @return array
     */
    public function loadComments(Post $post, Request $request)
    {
        $comments = $this->comment->findByPostId($post->id, $this->currentUser, 10);

        $partial = $this->view('partials.comments', compact('comments', 'post'));

        if ($request->has('ajax')) {
            return $this->jsonPagination($comments, $partial);
        }

        return ['partial' => $partial];
    }

    /**
     * More comments for parent comment
     *
     * @param $comment
     * @param Request $request
     * @return null|\Smile\Core\Persistence\Models\Comment
     */
    public function loadMore($comment, Request $request)
    {
        $comment = $this->comment->findById($comment);

        if ( ! $comment) {
            return [];
        }

        $last = ((int) $request->get('last', 0));
        $comments = $this->comment->findByParentId($comment->id, $this->currentUser, $last, 5);
        $post = $comment->post;

        $partial = $this->view('partials.more-comments', compact('comments', 'post'))->render();

        return [
            'partial' => $partial,
            'total' => count($comments),
            'last'    => $comments[$comments->count() - 1]->id,
            'hasMore' => $comments->count() != $comments->total()
        ];
    }

}