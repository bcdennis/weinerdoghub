<?php

namespace Themes\Admin\Http\Controllers\Settings;

use Illuminate\Http\Request;

class CommentsController extends BaseSettingController
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

        $this->settings->set('comments.facebook.on', $request->get('active'));

        return [];
    }


    /**
     * Store facebook page url for social plugin
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disqus(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('comments.disqus.on', $request->get('active'));

        return [];
    }

    /**
     * Store facebook page url for social plugin
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disqusId(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('comments.disqus.id', $request->get('id'));

        return redirect()->back();
    }

    /**
     * Store facebook page url for social plugin
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fbId(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('comments.fb.id', $request->get('id'));

        return redirect()->back();
    }

    /**
     * Store facebook page url for social plugin
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function local(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->settings->set('comments.local.on', $request->get('active'));

        return [];
    }

    /**
     * Settings form
     *
     * @return \Illuminate\View\View
     */
    public function form()
    {
        return $this->view('settings.comments');
    }

}
