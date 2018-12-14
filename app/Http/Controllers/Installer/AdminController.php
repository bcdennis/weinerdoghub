<?php

namespace Smile\Http\Controllers\Installer;

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
        $request->validate([
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

        $request->session()->put('install.done.admin', true);
        $request->session()->put('install.admin.user', $user->name);

        return redirect()->route('finish');
    }

    /**
     * Get started page
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function page(Request $request)
    {
        if ($response = $this->ensureSteps($request, 'license|requirements|database')) {
            return $response;
        }
        if (session('just-update')) {
            $request->session()->put('install.done.admin', true);
            return redirect()->route('finish');
        }

        return $this->view('steps.admin');
    }

}
