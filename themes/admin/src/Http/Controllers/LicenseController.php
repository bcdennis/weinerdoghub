<?php

namespace Themes\Admin\Http\Controllers;

use IonutMilica\LaravelSettings\SettingsContract;
use Illuminate\Http\Request;
use Smile\Core\Updater\Manager;

class LicenseController extends BaseAdminController
{
    /**
     * @var Manager
     */
    private $manager;
    /**
     * @var SettingsContract
     */
    private $settings;

    /**
     * @param Manager $manager
     * @param SettingsContract $settings
     */
    public function __construct(Manager $manager, SettingsContract $settings)
    {
        $this->middleware('auth.admin');

        $this->manager = $manager;
        $this->settings = $settings;
    }

    /**
     * Save the license
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, ['license' => 'required']);

        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $license = $request->get('license');

        if ($this->manager->forceValidate($license)) {
            file_put_contents(storage_path('app/.license'), $license);
            $this->settings->set('license', $license);
        }

        return redirect()->back();
    }

    /**
     * Get all the modules
     *
     * @return \Illuminate\View\View
     */
    public function form()
    {
        $current = $this->settings->get('license');
        $valid = $this->manager->validate();

        $currentVersion = VERSION;
        $latestVersion = $this->manager->checkVersion();

        return $this->view('license.form', compact('current', 'valid', 'currentVersion', 'latestVersion'));
    }

}
