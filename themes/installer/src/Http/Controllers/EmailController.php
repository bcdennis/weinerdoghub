<?php

namespace Themes\Installer\Http\Controllers;

use Illuminate\Http\Request;

class EmailController extends InstallerController
{

    /**
     * Save email settings
     *
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $rules = [
            'driver' => 'in:smtp,mail',
            'sender-email' => 'required',
            'sender-name'  => 'required',
            'support' => 'required',
        ];

        if ($request->get('driver') == 'smtp') {
            $rules = array_merge($rules,[
                'host' => 'required',
                'password' => 'required',
                'username' => 'required',
                'port'  => 'required'
            ]);
        }

        $this->validate($request, $rules);

        session(['install.email.driver' => $request->get('driver')]);
        session(['install.email.host' => $request->get('host')]);
        session(['install.email.user' => $request->get('username')]);
        session(['install.email.pass' => $request->get('password')]);
        session(['install.email.port' => $request->get('port')]);
        session(['install.email.sender-email' => $request->get('sender-email')]);
        session(['install.email.sender-name' => $request->get('sender-name')]);
        session(['install.email.support' => $request->get('support')]);

        return redirect()->route('admin');
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

        return $this->view('steps.email');
    }

}
