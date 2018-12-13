<?php

namespace Themes\Site\Http\Controllers;

use Illuminate\Http\Request;
use Smile\Core\Persistence\Models\User;
use Smile\Core\Services\UserService;

class ProfileController extends BaseSiteController
{

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Account overview
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function overview(User $user, Request $request)
    {
        $activities = $this->userService->findActivities($user);

        if ($request->has('ajax')) {
            return $this->respondWithJson($activities, $user, 'ajax.profile.overview');
        }

        return $this->view('profile.overview', compact('user', 'activities'));
    }

    /**
     * User smiles
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function smiles(User $user, Request $request)
    {
        $activities = $this->userService->findActivities($user, 'post.vote.like');

        if ($request->has('ajax')) {
            return $this->respondWithJson($activities, $user, 'ajax.profile.smiles');
        }

        return $this->view('profile.smiles', compact('user', 'activities'));
    }

    /**
     * User posts
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function posts(User $user, Request $request)
    {
        $activities = $this->userService->findActivities($user, 'post.create');

        if ($request->has('ajax')) {
            return $this->respondWithJson($activities, $user, 'ajax.profile.posts');
        }

        return $this->view('profile.posts', compact('user', 'activities'));
    }

    /**
     * User comments
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function comments(User $user, Request $request)
    {
        $activities = $this->userService->findActivities($user, 'post.comment');

        if ($request->has('ajax')) {
            return $this->respondWithJson($activities, $user, 'ajax.profile.comments');
        }

        return $this->view('profile.comments', compact('user', 'activities'));
    }

    /**
     * Respond with json
     *
     * @param $activities
     * @param User $user
     * @param $view
     * @return array
     */
    protected function respondWithJson($activities, User $user, $view)
    {
        $view = $this->view($view, compact('activities', 'user'));

        return $this->jsonPagination($activities, $view);
    }

}
