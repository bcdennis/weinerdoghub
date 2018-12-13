<?php

namespace Themes\Admin\Http\Controllers\Settings;

use Illuminate\Http\Request;

class AnalyticsController extends BaseSettingController
{

    /**
     * Store analytics settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('analytics.code', $request->get('value'));

        return redirect()->back();
    }

    /**
     * Settings form
     *
     * @return \Illuminate\View\View
     */
    public function form()
    {
        return $this->view('settings.analytics');
    }

}
