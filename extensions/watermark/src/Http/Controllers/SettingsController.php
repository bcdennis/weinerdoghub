<?php

namespace Extensions\Watermark\Http\Controllers;

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
        return view('ext-watermark::settings');
    }

    /**
     * Store watermark settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function store(Request $request)
    {
        $rules = [
            'position' => 'required',
            'rotation' => 'required|numeric',
            'x' => 'required|numeric',
            'y' => 'required|numeric',
        ];

        if ($request->hasFile('watermark') || ! $this->settings->get('watermark.image')) {
            $rules['watermark'] = 'required|mimes:png';
        }

        $this->validate($request, $rules);

        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('watermark.position', $request->get('position'));
        $this->settings->set('watermark.rotation', $request->get('rotation'));
        $this->settings->set('watermark.offset.x', $request->get('x'));
        $this->settings->set('watermark.offset.y', $request->get('y'));

        if ( ! isset($rules['watermark'])) {
            return redirect()->back();
        }

        $watermark = $request->file('watermark');
        $file = 'uploads/assets/watermark.png';

        if ($this->filesystem->put($file, file_get_contents($watermark->getRealPath()))) {
            $this->settings->set('watermark.image', $file);
        }

        return redirect()->back();
    }

}
