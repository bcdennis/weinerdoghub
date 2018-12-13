<?php

namespace Smile\Core\Services;

use Smile\Core\Persistence\Models\Comment;
use Smile\Core\Persistence\Models\Post;
use Smile\Core\Persistence\Models\User;
use Smile\Core\Persistence\Repositories\CommentReportContract;
use Smile\Core\Persistence\Repositories\PostReportContract;
use Smile\Core\Persistence\Repositories\StatContract;

class ReportService
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
     * @var StatContract
     */
    private $stat;

    /**
     * @param PostReportContract $postReport
     * @param CommentReportContract $commentReport
     * @param StatContract $stat
     */
    public function __construct(PostReportContract $postReport,
                                CommentReportContract $commentReport,
                                StatContract $stat)
    {
        $this->postReport = $postReport;
        $this->commentReport = $commentReport;
        $this->stat = $stat;
    }

    /**
     * Create post report
     *
     * @param User $user
     * @param Post $post
     * @param $reason
     * @return \Smile\Core\Persistence\Models\PostReport
     */
    public function createPostReport(User $user, Post $post, $reason)
    {
        if ($this->postReport->findByUserAndPost($user, $post, $reason)) {
            return false;
        }

        $this->stat->increment('reports');

        return $this->postReport->create($user, $post, $reason);
    }

    /**
     * Create comment report
     *
     * @param User $user
     * @param Comment $comment
     * @return mixed
     */
    public function createCommentReport(User $user, Comment $comment)
    {
        if ($this->commentReport->findByUserAndComment($user, $comment)) {
            return false;
        }

        $this->stat->increment('reports');

        return $this->commentReport->create($user, $comment);
    }

}
