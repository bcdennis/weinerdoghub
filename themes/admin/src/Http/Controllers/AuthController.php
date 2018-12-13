<?php

namespace Themes\Admin\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Smile\Http\Requests\CreateAuthRequest;

class AuthController extends BaseAdminController
{
    /**
     * @var Guard
     */
    private $auth;

    /**
     * @param Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->middleware('auth.admin', [
            'except' => ['showLogin', 'doLogin']
        ]);
        $this->auth = $guard;
    }

    /**
     * Display login page
     *
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        return $this->view('login');
    }

    /**
     * Do login authentication
     *
     * @param CreateAuthRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function doLogin(CreateAuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt($credentials, true)) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors([
            'general' => 'Invalid username or password!'
        ]);
    }

    /**
     * Logout from admin panel
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doLogout()
    {
        $this->auth->logout();

        return redirect()->route('admin.users');
    }

}
