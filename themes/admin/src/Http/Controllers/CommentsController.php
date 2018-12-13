<?php

namespace Themes\Admin\Http\Controllers;

use Smile\Core\Services\CommentService;

class CommentsController extends BaseAdminController
{
    /**
     * @var CommentService
     */
    private $commentService;

    /**
     * @param CommentService $commentService
     */
    public function __construct(CommentService $commentService)
    {
        $this->middleware('auth.admin');

        $this->commentService = $commentService;
    }

    /**
     * Delete comment
     *
     * @param $commentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($commentId)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->commentService->delete($commentId);

        return redirect()->back();
    }

}
