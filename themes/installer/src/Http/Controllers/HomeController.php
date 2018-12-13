<?php

namespace Themes\Installer\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends InstallerController
{
    /**
     * Get started page
     *
     * @return \Illuminate\View\View
     */
    public function getStarted()
    {
        return $this->view('start');
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function store(Request $request)
    {
        $status = $this->client->validate($request->get('license'));

        if ($status) {
            $request->session()->set('install.done.license', $request->get('license'));
            return redirect()->route('requirements');
        }

        return redirect()->back()->withErrors([
            'license' => 'Invalid license',
        ]);
    }

}
