<?php

namespace Themes\Installer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Smile\Core\Persistence\Repositories\UserContract;

class AdminController extends InstallerController
{

    /**
     * Save email settings
     *
     * @param Request $request
     * @param UserContract $userRepo
     * @return mixed
     */
    public function save(Request $request, UserContract $userRepo)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:15',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);

        Artisan::call('migrate:refresh', [
            '--force' => true,
        ]);

        $user = $userRepo->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'permission' => 'admin',
            'status' => 1,
        ]);

        session(['install.done.admin' => true]);
        session(['install.admin.user' => $user->name]);

        return redirect()->route('finish');
    }

    /**
     * Get started page
     *
     * @return \Illuminate\View\View
     */
    public function page()
    {
        if ($response = $this->ensureSteps('license|requirements|database')) {
            return $response;
        }
        if (session('just-update')) {
            session(['install.done.admin' => true]);
            return redirect()->route('finish');
        }

        return $this->view('steps.admin');
    }

}
