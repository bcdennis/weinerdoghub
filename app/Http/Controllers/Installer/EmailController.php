<?php

namespace Smile\Http\Controllers\Installer;

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
            'sender-name' => 'required',
            'support' => 'required',
        ];

        if ($request->get('driver') == 'smtp') {
            $rules = array_merge($rules, [
                'host' => 'required',
                'password' => 'required',
                'username' => 'required',
                'port' => 'required'
            ]);
        }

        $request->validate($rules);

        $request->session()->put('install.email.driver', $request->get('driver'));
        $request->session()->put('install.email.host', $request->get('host'));
        $request->session()->put('install.email.user', $request->get('username'));
        $request->session()->put('install.email.pass', $request->get('password'));
        $request->session()->put('install.email.port', $request->get('port'));
        $request->session()->put('install.email.sender-email', $request->get('sender-email'));
        $request->session()->put('install.email.sender-name', $request->get('sender-name'));
        $request->session()->put('install.email.support', $request->get('support'));

        return redirect()->route('admin');
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

        return $this->view('steps.email');
    }

}
