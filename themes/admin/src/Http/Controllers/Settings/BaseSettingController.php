<?php

namespace Themes\Admin\Http\Controllers\Settings;

use IonutMilica\LaravelSettings\SettingsContract;
use Illuminate\Contracts\Filesystem\Filesystem;
use Themes\Admin\Http\Controllers\BaseAdminController;

class BaseSettingController extends BaseAdminController
{
    /**
     * @var SettingsContract
     */
    protected $settings;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param SettingsContract $settings
     * @param Filesystem $filesystem
     */
    public function __construct(SettingsContract $settings, Filesystem $filesystem)
    {
        $this->middleware('auth.admin');

        $this->settings = $settings;
        $this->filesystem = $filesystem;
    }

}
