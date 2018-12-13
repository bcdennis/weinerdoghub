<?php

namespace Themes\Admin\Http\Controllers\Settings;

use Illuminate\Http\Request;

class SocialController extends BaseSettingController
{

    /**
     * Store facebook page url for social plugin
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function facebook(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('social.facebook', $request->get('url'));

        return redirect()->back();
    }

    /**
     * Store twitter page url for social plugin
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function twitter(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('social.twitter.name', $request->get('name'));
        $this->settings->set('social.twitter.widget', $request->get('widget'));

        return redirect()->back();
    }

    /**
     * Store google page url for social plugin
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function google(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('social.google', $request->get('url'));

        return redirect()->back();
    }

    /**
     * Update social plugins status
     *
     * @param Request $request
     * @return array
     */
    public function status(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('social.on', $request->get('active'));

        return [];
    }

    /**
     * Settings form
     *
     * @return \Illuminate\View\View
     */
    public function form()
    {
        return $this->view('settings.social');
    }

}
