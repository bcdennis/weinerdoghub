<?php
namespace Extensions\Style\Http\Controllers;

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
        return view('ext-style::settings');
    }

    /**
     * Store a new ad code
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('style.css', $request->get('css'));

        return redirect()->back();
    }

}
