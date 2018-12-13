<?php

namespace Extensions\S3\Http\Controllers;

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
        return view('ext-s3::settings');
    }

    /**
     * Store settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function store(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        foreach ($request->all() as $field => $value) {
            if ($field[0] == '_') continue;

            $this->settings->set('extensions.s3.'.$field, $value);
        }

        return redirect()->back();
    }

}
