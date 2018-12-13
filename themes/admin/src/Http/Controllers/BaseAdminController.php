<?php

namespace Themes\Admin\Http\Controllers;

use Smile\Http\Controllers\Controller;

class BaseAdminController extends Controller
{

    /**
     * Get view for selected theme
     *
     * @param $view
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function view($view, array $data = [])
    {
        $theme = config('smile.adminTheme', 'admin');

        return $this->themeView($theme, $view, $data);
    }

    /**
     * Ensure that user has a specified permission
     *
     * @param $permission
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function ensure($permission)
    {
        $perm = perm();

        if ($perm == 'admin' || perm() == $permission) {
            return null;
        }

        return redirect()->back();
    }

}
