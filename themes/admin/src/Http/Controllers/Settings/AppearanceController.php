<?php

namespace Themes\Admin\Http\Controllers\Settings;

use Illuminate\Http\Request;

class AppearanceController extends BaseSettingController
{

    /**
     * Update text branding
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function branding(Request $request)
    {
        $all = $request->only('title', 'description', 'keywords', 'copyright', 'url-format');

        if ($page = $this->ensure('admin')) {
            return $page;
        }

        foreach ($all as $field => $value) {
            $this->settings->set('branding.'.$field, $value);
        }

        return redirect()->back();
    }

    /**
     * Upload new logo
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logo(Request $request)
    {
        $this->validate($request, [
            'logo' => 'mimes:png',
            'mobile-logo' => 'mimes:png',
        ]);

        if ( ! $request->hasFile('mobile-logo') && ! $request->hasFile('logo')) {
            return redirect()->back();
        }

        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $type = $request->hasFile('mobile-logo') ? 'mobile-logo' : 'logo';
        $logo = $request->file($type);

        $file = 'uploads/assets/'.$type.'.png';

        if ($this->filesystem->put($file, file_get_contents($logo->getRealPath()))) {
            $this->settings->set($type, $file);
        }

        return redirect()->back();
    }

    /**
     * Upload icon
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function favicon(Request $request)
    {
        $this->validate($request, [
            'favicon' => 'required|image',
        ]);

        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $favicon = $request->file('favicon');

        $file = 'uploads/assets/favicon.'.$favicon->getClientOriginalExtension();

        if ($this->filesystem->put($file, file_get_contents($favicon->getRealPath()))) {
            $this->settings->set('favicon', $file);
        }

        return redirect()->back();
    }

    /**
     * On/Off for slug
     *
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse|null
     */
    public function slug(Request $request)
    {
        $this->validate($request, ['active' => 'required|boolean']);

        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('branding.slug', $request->get('active'));

        return [];
    }

    /**
     * Appearance settings forms
     *
     * @return \Illuminate\View\View
     */
    public function form()
    {
        return $this->view('settings.appearance');
    }

}
