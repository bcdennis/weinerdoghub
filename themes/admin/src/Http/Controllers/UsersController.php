<?php

namespace Themes\Admin\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Smile\Core\Persistence\Models\User;
use Smile\Core\Services\UserService;

class UsersController extends BaseAdminController
{

    /**
     * @var UserService
     */
    private $user;

    /**
     * @var User
     */
    private $currentUser;

    /**
     * @param UserService $user
     * @param Guard $auth
     */
    public function __construct(UserService $user, Guard $auth)
    {
        $this->middleware('auth.admin');

        $this->user = $user;
        $this->currentUser = $auth->user();
    }

    /**
     * Display all the users
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function all(Request $request)
    {
        $users = $this->user->search($request->get('q'));

        return $this->view('users.list', compact('users'));
    }

    /**
     * Block user account
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function block($id)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->user->toggleBlock($id);

        return redirect()->back();
    }


    /**
     * Delete an user
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->user->deleteById($id);

        return redirect()->route('admin.users');
    }

}
