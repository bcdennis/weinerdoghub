<?php

namespace Themes\Admin\Http\Controllers\Settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RestrictionsController extends BaseSettingController
{

    /**
     * Store restriction setting
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $all = $request->all();

        foreach ($all as $field => $value) {
            if ($field[0] == '_') continue;

            $this->settings->set($field, $value);
        }

        return redirect()->back();
    }

    /**
     * Toggle maintenance mode
     *
     * @param Request $request
     * @return array
     */
    public function maintenance(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        if ($request->get('active')) {
            Artisan::call('up');
        } else {
            Artisan::call('down');
        }

        return [];
    }

    /**
     * Activate or deactivate video in posts
     *
     * @param Request $request
     * @return array
     */
    public function video(Request $request)
    {
        $this->validate($request, ['active' => 'required|boolean']);

        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('videoPost', $request->get('active'));

        return [];
    }

    /**
     * Activate or deactivate registration
     *
     * @param Request $request
     * @return array
     */
    public function register(Request $request)
    {
        $this->validate($request, ['active' => 'required|boolean']);

        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('registration', $request->get('active'));

        return [];
    }

    /**
     * Enable/Disable post moderation
     *
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse|null
     */
    public function postModeration(Request $request)
    {
        $this->validate($request, ['active' => 'required|boolean']);

        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('post-moderation', $request->get('active'));

        return [];
    }

    /**
     * Settings form
     *
     * @return \Illuminate\View\View
     */
    public function form()
    {
        return $this->view('settings.restrictions');
    }

}
