<?php

namespace Extensions\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Themes\Admin\Http\Controllers\Settings\BaseSettingController;

class SettingsController extends BaseSettingController
{
    /**
     * Settings page
     *
     * @return \Illuminate\View\View
     */
    public function form()
    {
        return view('ext-auth::settings');
    }

    /**
     * Store facebook settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function facebook(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('auth.facebook.client_id', $request->get('client_id'));
        $this->settings->set('auth.facebook.client_secret', $request->get('client_secret'));

        return redirect()->back();
    }

    /**
     * Store google+ settings
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function google(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('auth.google.client_id', $request->get('client_id'));
        $this->settings->set('auth.google.client_secret', $request->get('client_secret'));

        return redirect()->back();
    }

}
