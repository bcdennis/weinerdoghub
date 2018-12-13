<?php

namespace Themes\Admin\Http\Controllers;

use Smile\Core\Persistence\Repositories\StatContract;

class HomeController extends BaseAdminController
{

    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    /**
     * Admin dashboard
     *
     * @param StatContract $stat
     * @return \Illuminate\View\View
     */
    public function dashboard(StatContract $stat)
    {
        $data = [
            'visitsNow' => $stat->get('visits'),
            'visitsThen' => $stat->get('visits', -1),
            'usersNow' => $stat->get('users'),
            'usersThen' => $stat->get('users', -1),
            'postsNow' => $stat->get('posts'),
            'postsThen' => $stat->get('posts', -1),
            'reportsNow' => $stat->get('reports'),
            'reportsThen' => $stat->get('reports', -1),
            'chartData' => $stat->all('visits', 6),
            'totalVisits' => $stat->count('visits'),
            'totalPosts' => $stat->count('posts'),
            'totalUsers' => $stat->count('users'),
            'totalReports' => $stat->count('reports'),
        ];

        return $this->view('dashboard', $data);
    }

}
