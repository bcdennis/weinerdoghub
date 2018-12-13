<?php

namespace Themes\Admin\Http\Controllers\Settings;

use Illuminate\Http\Request;

class EmailController extends BaseSettingController
{

    /**
     * Store email settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        foreach ($request->all() as $field => $value) {
            if ($field[0] == '_') continue;
            $this->settings->set('email.'.$field, $value);
        }

        return redirect()->back();
    }

    /**
     * Store support email
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSupportEmail(Request $request)
    {
        $this->validate($request, ['support' => 'email']);

        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('email.support', $request->get('support'));

        return redirect()->back();
    }

    /**
     * Settings form
     *
     * @return \Illuminate\View\View
     */
    public function form()
    {
        return $this->view('settings.email');
    }

}
