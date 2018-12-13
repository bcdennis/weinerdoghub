<?php

namespace Themes\Admin\Http\Controllers\Settings;

use Illuminate\Http\Request;

class ConversionsController extends BaseSettingController
{

    /**
     * Conversion status
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

        $this->settings->set('conversion.on', $request->get('active', false));

        return [];
    }

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

        $this->settings->set('conversion.binaries.ffmpeg', $request->get('ffmpeg'));
        $this->settings->set('conversion.binaries.ffprobe', $request->get('ffprobe'));

        return redirect()->back();
    }

    /**
     * Settings form
     *
     * @return \Illuminate\View\View
     */
    public function form()
    {
        return $this->view('settings.conversion');
    }

}
