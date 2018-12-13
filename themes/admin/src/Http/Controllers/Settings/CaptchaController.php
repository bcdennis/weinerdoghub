<?php

namespace Themes\Admin\Http\Controllers\Settings;

use Illuminate\Http\Request;

class CaptchaController extends BaseSettingController
{

    /**
     * Save settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('captcha.key', $request->get('key'));
        $this->settings->set('captcha.secret', $request->get('secret'));

        return redirect()->back();
    }

    /**
     * Settings form
     *
     * @return \Illuminate\View\View
     */
    public function form()
    {
        return $this->view('settings.captcha');
    }

}
