<?php

namespace Extensions\Ads\Http\Controllers;

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
        return view('ext-ads::settings');
    }


    /**
     * Ads status
     *
     * @param Request $request
     * @return array
     */
    public function status(Request $request)
    {
        $this->validate($request, ['active' => 'required|boolean']);

        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('ads.on', $request->get('active', false));

        return [];
    }

    /**
     * Store ad
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function upload(Request $request)
    {
        $type = $request->hasFile('rectangle-ad-image') ? 'rectangle-ad-image' : 'square-ad-image';
        $ad = $request->file($type);
        $ext = $ad->getClientOriginalExtension();

        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $file = 'uploads/assets/'.$type.'.'.$ext;

        if ($this->filesystem->put($file, file_get_contents($ad->getRealPath()))) {
            $this->settings->set($type, $file);
            $this->settings->forget(str_replace('image', 'code', $type));
        }

        return redirect()->back();
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

        foreach ($request->all() as $field => $value) {
            if ($field[0] == '_') continue;
            setting_set($field, $value);
            setting_forget(str_replace('code', 'image', $field));
        }

        return redirect()->back();
    }

}
