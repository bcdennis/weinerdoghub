<?php

namespace Themes\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Smile\Core\Persistence\Repositories\CommentReportContract;
use Smile\Core\Persistence\Repositories\PostReportContract;

class ReportsController extends BaseAdminController
{
    /**
     * @var PostReportContract
     */
    private $postReport;
    /**
     * @var CommentReportContract
     */
    private $commentReport;

    /**
     * @param PostReportContract $postReport
     * @param CommentReportContract $commentReport
     */
    public function __construct(PostReportContract $postReport, CommentReportContract $commentReport)
    {
        $this->middleware('auth.admin');

        $this->postReport = $postReport;
        $this->commentReport = $commentReport;
    }

    /**
     * Display post reports
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function posts(Request $request)
    {
        $reports = $this->postReport->all($request->get('q'));
        $postsNum = $this->postReport->count();
        $commentsNum = $this->commentReport->count();

        return $this->view('reports.posts', compact('reports', 'commentsNum', 'postsNum'));
    }

    /**
     * Get all reports for the comments
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function comments(Request $request)
    {
        $reports = $this->commentReport->all($request->get('q'));
        $postsNum = $this->postReport->count();
        $commentsNum = $this->commentReport->count();

        return $this->view('reports.comments', compact('reports', 'commentsNum', 'postsNum'));
    }


    /**
     * Close report
     *
     * @param $postId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function closePost($postId)
    {
        $this->postReport->deleteByPost($postId);

        return redirect()->back();
    }

    /**
     * Close comment report
     *
     * @param $commentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function closeComment($commentId)
    {
        $this->commentReport->deleteByComment($commentId);

        return redirect()->back();
    }
}
