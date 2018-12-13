<?php

namespace Extensions\Sitemap\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        return view('ext-sitemap::settings');
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

        Cache::forget('laravel.sitemap');

        $request->session()->flash('sitemap', true);

        return redirect()->back();
    }

}
